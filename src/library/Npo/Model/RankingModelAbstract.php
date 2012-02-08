<?php
namespace Npo\Model;

abstract class RankingModelAbstract
    extends ModelAbstract 
{
    protected $_entity = null;

    public function get($id)
    {
        $em = $this->getEntityManager();

        return $em->find($this->_entity, $id);
    }

    public function save($entity_object)
    {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();

        try
        {
            $em->persist($entity_object);
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
        $query = $em->createQuery(sprintf('
            SELECT o
            FROM %s o 
            WHERE o.rank BETWEEN :offset AND :max 
            ORDER BY o.rank DESC', $this->_entity));

        $query->setParameter('offset', $offset)
            ->setParameter('max', $offset + $page_size);

        return $query->getResult();
    }

    protected abstract function _migrateRecord($data_line);

    public function migrate($url)
    {
        $em = $this->getEntityManager();
        $data = gzopen($url, 'r');

        $em->getConnection()->beginTransaction();

        try
        {
            while(!gzeof($data))
            {
                $entity_object = $this->_migrateRecord(gzgets($data, 1024));
                $em->persist($entity_object);
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
        $rank = ($page - 1) * $page_size;

        return $this->_listRanking($rank, $page_size);
    }

    public function locate($name, $page_size)
    {
        $player = $this->findByName($name);

        return $this->_listRanking($player->rank, $page_size);
    }

    public function findByName($name) 
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(sprintf('
            SELECT o 
            FROM %s o 
            WHERE o.name = :name', $this->_entity));

        $query->setParameter('name', $name);
        
        return $query->getSingleResult();
    }
}
