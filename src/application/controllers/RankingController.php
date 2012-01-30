<?php

class RankingController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->headTitle('Tribal Wars NPO-Manifest')
            ->setSeparator(' - ')
            ->append('Ranglijst');
    }

    public function indexAction()
    {
    }


}

