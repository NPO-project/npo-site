<?php

class IndexController extends Zend_Controller_Action
{
    public function preDispatch()
    {
        $this->_forward('index', 'registration');
    }

    public function indexAction()
    {
    }
}

