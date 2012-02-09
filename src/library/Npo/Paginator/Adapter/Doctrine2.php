<?php

namespace Npo\Paginator\Adapter;

use Doctrine\ORM\Query;

class Doctrine2 implements \Zend_Paginator_Adapter_Interface {
    private $_count;
    private $_select;

    public function __construct(Query $select, Query $count) {
        $this->_select = $select;
        $this->_count = $count;
    }

    public function getItems($offset, $itemCountPerPage) {
        $this->_select
            ->setFirstResult($offset)
            ->setMaxResults($itemCountPerPage);

        return $this->_select->execute();
    }

    public function count() {
        return (int)$this->_count->getSingleScalarResult();
    }
}
