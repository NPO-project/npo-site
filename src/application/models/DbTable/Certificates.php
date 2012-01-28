<?php

class Application_Model_DbTable_Certificates extends Zend_Db_Table_Abstract
{

    protected $_nameSyntax = '{DB_PREFIX}_%s_certificates';
    
    public function setWorld($world)
    {
        $this->_name = sprintf($this->_nameSyntax, $world);
    }
    
}

