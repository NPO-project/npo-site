<?php
namespace Npo\Model;

abstract class RankingModelAbstract
    extends ModelAbstract 
{
    const CHUNK_SIZE = 200;
    const PAGE_SIZE = 50;

    protected $_entity = null;
    protected $_join = '';
    private $_paginator;

    public function get($id)
    {
        $em = $this->getEntityManager();
        $entityObject = $em->find($this->_entity, $id);

        return $entityObject;
    }

    public function save($entity_object)
    {
        $em = $this->getEntityManager();

        $em->persist($entity_object);
        $em->flush();
    }

    public function clear()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(sprintf('
            DELETE
            FROM %s o',
            $this->_entity));

        return $query->execute();
    }

    public function getPaginator()
    {
        $em = $this->getEntityManager();

        if (!$this->_paginator)
        {
            $query = $em->createQuery(sprintf('
                SELECT o
                FROM %s o %s
                ORDER BY o.rank ASC', 
                $this->_entity, $this->_join));
            $count = $em->createQuery(sprintf('
                SELECT COUNT(o.id)
                FROM %s o', 
                $this->_entity));

            $this->_paginator = new \Zend_Paginator(new \Npo\Paginator\Adapter\Doctrine2($query, $count));
            $this->_paginator->setItemCountPerPage(self::PAGE_SIZE);
        }

        return $this->_paginator;
    }

    protected abstract function _migrateRecord($data_line);

    public function migrate($url)
    {
        $em = $this->getEntityManager();
        $data = gzopen($url, 'r');
        $counter = 0;

        $em->getConnection()->beginTransaction();

        try
        {
            $this->clear();
 
            while(!gzeof($data))
            {
                $entity_object = $this->_migrateRecord(gzgets($data, 1024));
                $em->persist($entity_object);

                if ($counter++ % self::CHUNK_SIZE === 0) 
                {
                    $em->flush();
                    $em->clear();
                }
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

    public function findPage($name)
    {
        $page = null;
        $player = $this->findByName($name);

        if ($player)
            $page = $player->rank / self::PAGE_SIZE + 1;

        return $page;
    }

    public function findByName($name) 
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(sprintf('
            SELECT o 
            FROM %s o %s
            WHERE o.name = :name', 
            $this->_entity, $this->_join));

        $query->setParameter('name', $name);
        
        return $query->getSingleResult();
    }
}
