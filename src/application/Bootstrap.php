<?php

class Bootstrap
    extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initAutoloaderNamespaces()
    {
        require_once APPLICATION_PATH . '/../library/Doctrine/Common/ClassLoader.php';
        
        $autoloader = \Zend_Loader_Autoloader::getInstance();
        $ffmAutoloader = new \Doctrine\Common\ClassLoader('Bisna');
        $autoloader->pushAutoloader(array($ffmAutoloader, 'loadClass'), 'Bisna');   
    }
}

