<?php

class Application_Model_CertificateMapper
{
    private $_dbTable;
    
    public function setDbTable($dbTable = 'Application_Model_DbTable_Certificates')
    {
        if (is_string($dbTable)) {
            $this->_dbTable = new $dbTable;
        } elseif ($dbTable instanceof Zend_Db_Table_Abstract) {
            $this->_dbTable = $dbTable;
        } else {
            throw new InvalidArgumentException();
        }
    }
    
    /**
     * @return Application_Model_DbTable_Certificates
     */
    public function getDbTable()
    {
        if (!$this->_dbTable) {
            $this->setDbTable();
        }
        return $this->_dbTable;
    }
    
    public function fetchAll($world)
    {
        $table = $this->getDbTable();
        $table->setWorld($world);
        $select = $table->select();
        $rows = $table->fetchAll($select);
        $data = array();
        foreach ($rows as $row) {
            $tmp = new Application_Model_Certificate;
            $tmp->setPlayerId($row->player_id)
                ->setDate($row->date)
                ->setEndDate($row->end_date);
            $data[] = $tmp;
        }
        return $data;
    }
}

