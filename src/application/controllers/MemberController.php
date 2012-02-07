<?php

class MemberController extends Zend_Controller_Action
{
    public function init()
    {
        $this->view->headTitle('Tribal Wars NPO-Manifest');
    }

    public function indexAction()
    {
        $model_registrations = $this->_helper->model('Registrations');
        $ns_auth = new \Zend_Session_Namespace('auth');

        if ($ns_auth->currentMember)
            return $this->forward('view');

        $form = new \Npo\Form\Member('\member\create', $model_registrations->getOpenRegistrations());
        $view = 'index';

        $this->view->form = $form;

        return $this->render($view);
    }

    private function _mailSummary($member, $password)
    {
        $mail = new \Zend_Mail;
        
        $mail->setBodyText('Beste ' . $member->name . ', u werd zonet aangenomen bij Tribal Wars NPO. Hierbij werd een account opgemaakt en toegevoegd aan het systeem. Om in te loggen dient u uw e-mailadres te gebruiken en het volgende wachtwoord: ' . $password)
            ->setFrom('dennisdegryse@gmail.com', 'Tribal Wars - NPO')
            ->addTo($member->email, $member->name)
            ->setSubject('NPO - Lidmaatschap')
            ->send();
    }

    public function createAction()
    {
        $model_members = $this->_helper->model('Members');
        $model_registrations = $this->_helper->model('Registrations');
        $form = new \Npo\Form\Member('\member\create', $model_registrations->getOpenRegistrations());
        $view = 'verification';

        if (!$this->getRequest()->isPost())
            return $this->_forward('index');

        try
        {
            $data = $this->getRequest()->getPost();
            $registration = $model_registrations->get($data['registration']);
            $password = $this->_helper->generatePassword();
            $member = $form->createMember($data, $password, $registration);

            $model_members->save($member);
            $this->_mailSummary($member, $password);
        } 
        catch (Zend_Validate_Exception $e)
        {
            $this->view->form = $form;
            $view = 'index';
        }

        return $this->render($view);
    }
}

