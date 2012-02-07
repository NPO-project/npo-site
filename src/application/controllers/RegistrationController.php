<?php

class RegistrationController extends Zend_Controller_Action
{
    private $_form;
    private $_registrations;

    public function init()
    {
        $this->view->headTitle('Tribal Wars NPO-Manifest');
    }

    public function indexAction()
    {
        $form = new \Npo\Form\Registration('\registration\register');
        $view = 'index';

        $this->view->form = $form;

        return $this->render($view);
    }

    public function registerAction()
    {
        $model = $this->_helper->model('Registrations');
        $form = new \Npo\Form\Registration('\registration\register');
        $view = 'verification';

        if (!$this->getRequest()->isPost())
            return $this->_forward('index');

        try
        {
            $data = $this->getRequest()->getPost();
            $registration = $form->createRegistration($data);

            $model->save($registration);
        } 
        catch (Zend_Validate_Exception $e)
        {
            $this->view->form = $form;
            $view = 'index';
        }

        return $this->render($view);
    }
}

