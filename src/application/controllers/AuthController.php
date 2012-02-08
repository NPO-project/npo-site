<?php

class AuthController
    extends Zend_Controller_Action
{
    public function indexAction()
    {
        $ns_auth = new \Zend_Session_Namespace('auth');
        $form = new \Npo\Form\Auth('/auth/login');
        $view = 'index';

        if ($ns_auth->currentMember !== null)
            return $this->_forward('index', 'index');

        $this->view->form = $form;

        return $this->render($view);
    }

    public function loginAction()
    {
        $ns_auth = new \Zend_Session_Namespace('auth');
        $form = new \Npo\Form\Auth('/auth/login');
        $model = new \Npo\Model\Members;
        $request = $this->getRequest();
        $view = 'login';

        if ($ns_auth->currentMember !== null)
            return $this->_forward('index', 'index');

        if (!$request->isPost())
            return $this->_forward('index');

        try
        {
            $data = $request->getPost();

            if (!$form->isValid($data))
                throw new \Zend_Validate_Exception;

            $member = $model->tryLogin($data['email'], $data['password']);

            $ns_auth->currentMember = $member->id;
            $this->view->member = $member;
        }
        catch (\Zend_Validate_Exception $e)
        {
            $view = 'index';
            $this->view->form = $form;
        }

        return $this->render($view);
    }

    public function logoutAction()
    {
        $ns_auth = new \Zend_Session_Namespace('auth');
        $view = 'logout';

        if (!$ns_auth->currentMember)
            return $this->_forward('index');

        $ns_auth->currentMember = null;

        return $this->render($view);
    }
}
