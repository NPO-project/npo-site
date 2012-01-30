<?php
namespace Npo\Model;

abstract class ModelAbstract
{
    private $_entityManager;

    protected function getEntityManager()
    {
        if (!$this->_entityManager)
            $this->_entityManager = \Zend_Registry::get('doctrine')->getEntityManager('default');

        return $this->_entityManager;
    }
}
