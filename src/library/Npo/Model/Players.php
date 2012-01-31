<?php
namespace Npo\Model;

class Players
    extends ModelAbstract 
{
    public function save($player)
    {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();

        try
        {
            $em->persist($player);
            $em->flush();
            $em->getConnection()->commit();
        }
        catch (Exception $e)
        {
            $em->getConnection()->rollback();
            $em->close();

            throw $e;
        }
    }

    private function _listRanking($rank, $page_size)
    {
        $em = $this->getEntityManager();
        $offset = $rank - $rank % $page_size + 1;
        $query = $em->createQuery('
            SELECT p
            FROM \Npo\Entity\Player
            WHERE p.rank BETWEEN :offset AND :max
            ORDER BY p.rank DESC');

        return $query->getResult();
    }

    public function migrate($url)
    {
        $em = $this->getEntityManager();
        $data = gzopen($url, 'r');

        $em->getConnection()->beginTransaction();

        try
        {
            while(!gzeof($data))
            {
                $player = new \Npo\Entity\Player;
                list($id, $name, $ally, $villages, $points, $rank) = explode(',', gzgets($data, 1024));

                $player->id = $id;
                $player->name = $name;
                $player->points = $points;
                $player->rank = $rank;

                $em->persist($player);
            }

            $em->flush();
            $em->getConnection()->commit();
        }
        catch (Exception $e)
        {
            $em->getConnection()->rollback();
            $em->close();

            throw $e;
        }

        return array();
    }

    public function listRanking($page = 1, $page_size)
    {
        $em = $this->getEntityManager();
        $rank = ($page - 1) * $page_size;

        return $this->_listRanking($rank, $page_size);
    }

    public function locatePlayer($name, $page_size)
    {
        $player = $this->findPlayer($name);

        return $this->_listRanking($player->rank, $page_size);
    }

    public function findPlayer($name) 
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT p 
            FROM \Npo\Entity\Player 
            WHERE p.name = :name');

        $query->setParameter('name', $name);
        
        return $query->getSingleResult();
    }
}
