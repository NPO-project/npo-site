<?php

class AlternativesController extends Zend_Controller_Action
{
    
    public function init()
    {
        $this->view->headTitle('Tribal Wars NPO-Manifest')
            ->setSeparator(' - ')
            ->append('Alternatieven');
    }
    
    public function indexAction()
    {
    }
    
}

