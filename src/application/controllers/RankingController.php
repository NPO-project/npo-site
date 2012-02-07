<?php

class RankingController extends Zend_Controller_Action
{
    const PAGE_SIZE = 50;

    public function init()
    {
        $this->view->headTitle('Tribal Wars NPO-Manifest')
            ->setSeparator(' - ')
            ->append('Ranglijst');
    }

    public function indexAction()
    {
        $this->_forward('index');
    }

    public function listAction()
    {
        $model = $this->_helper->model('players');
        $page = $this->_getParam('page', 1);

        $this->view->players = $model->listRanking($page, self::PAGE_SIZE);
    }
}

