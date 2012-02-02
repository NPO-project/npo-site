<?php

class Application_Model_DbTable_Registrations extends Zend_Db_Table_Abstract
{
    protected $_name = '{DB_PREFIX}registrations';
    protected $_primary = 'id';
    protected $_sequence = true;
}

