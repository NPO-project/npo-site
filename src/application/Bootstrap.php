<?php

class Bootstrap
    extends \Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoloaderNamespaces()
    {
        require_once APPLICATION_PATH . '/../library/Doctrine/Common/ClassLoader.php';
        
        $autoloader = \Zend_Loader_Autoloader::getInstance();
        $ffm_autoloader = new \Doctrine\Common\ClassLoader('Bisna');
        $autoloader->pushAutoloader(array($ffm_autoloader, 'loadClass'), 'Bisna');   
    }

    protected function _initHelpers()
    {
        Zend_Controller_Action_HelperBroker::addHelper(new \Npo\Controller\Action\Helper\Model);
        Zend_Controller_Action_HelperBroker::addHelper(new \Npo\Controller\Action\Helper\GeneratePassword);
    }

    protected function _initAuth()
    {
        $auth = new \Zend_Session_Namespace('members');
        $auth->currentMember = null;
    }

    protected function _initAcl()
    {
        $acl_helper = new \Npo\Controller\Helper\Acl;
        $acl_helper->setRoles();
        $acl_helper->setResources();
        $acl_helper->setPrivileges();
        $acl_helper->setAcl();

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new \Npo\Controller\Plugin\Acl);
    }
}

