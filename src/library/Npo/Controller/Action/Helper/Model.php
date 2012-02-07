<?php
namespace Npo\Controller\Action\Helper;

class Model
    extends \Zend_Controller_Action_Helper_Abstract
{
    private $_cache = array();

    public function direct($name)
    {
        $name = ucfirst($name);

        if (array_key_exists($name, $this->_cache))
            return $this->_cache($name);

        $modelName = '\Npo\Model\\' . $name;

        return new $modelName();
    }
}
