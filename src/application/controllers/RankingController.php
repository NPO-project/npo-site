<?php

class RankingController extends Zend_Controller_Action
{
    const PAGE_SIZE = 50;
    private static $_validSections = array('players', 'tribes');

    public function init()
    {
        $this->view->headTitle('Tribal Wars NPO-Manifest')
            ->setSeparator(' - ')
            ->append('Ranglijst');
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $page = $this->_getParam('page', 1);
        $section = $this->_getParam('section', self::$_validSections[0]);

        if (!in_array($section, self::$_validSections))
            throw new Exception('Invalid Section');

        $model = $this->_helper->model($section);

        $this->view->players = $model->listRanking($page, self::PAGE_SIZE);
    }
}

