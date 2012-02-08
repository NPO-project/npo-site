<?php
namespace Npo\Controller\Helper;

class Acl 
{
    private $_acl;

    public function __construct()
    {
        $this->_acl = new \Zend_Acl();
    }

    public function setRoles()
    {
        $this->_acl->addRole(new \Zend_Acl_Role('guest'))
            ->addRole(new \Zend_Acl_Role('ambassador'), 'guest')
            ->addRole(new \Zend_Acl_Role('programmer'), 'ambassador')
            ->addRole(new \Zend_Acl_Role('bot'), 'programmer')
            ->addRole(new \Zend_Acl_Role('admin'). 'bot');
    }

    public function setResources()
    {
        $this->_acl->add(new \Zend_Acl_Resource('registration'));
    }

    public function setPrivileges()
    {
        $this->_acl->allow('guest', null, array('list', 'read', 'index', 'register', 'create', 'login'))
            ->allow('ambassador', null, array('add', 'delete', 'logout'))
            ->allow('bot', null, 'migrate');
    }

    public function setAcl() 
    {
        \Zend_Registry::set('acl', $this->_acl);    
    }
}
