<?php
namespace Npo\Controller\Plugin;

class Acl
    extends \Zend_Controller_Plugin_Abstract
{
    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {
        $acl = \Zend_Registry::get('acl');
        $ns_auth = new \Zend_Session_Namespace('auth');
        $model = new \Npo\Model\Members;
        $resource = $request->getControllerName();
        $privilege = $request->getActionName();
        $roles = array();

        if (!$acl->has($resource))
            $resource = null;

        if ($ns_auth->currentMember === null)
            $roles[] = 'guest';
        else
        {
            $member = $model->get($ns_auth->currentMember);

            foreach ($member->roles as $role)
                $roles[] = $role->role;
        }

        foreach ($roles as $role)
            if ($acl->isAllowed($role, null, $privilege))
                 return;

        $request->setControllerName('Error');
        $request->setActionName('Index');
    }
}
