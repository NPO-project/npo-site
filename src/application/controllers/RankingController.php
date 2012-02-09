<?php
class RankingController extends Zend_Controller_Action
{
    private $_model;

    public function init()
    {
        $this->view->headTitle('Tribal Wars NPO-Manifest')
            ->setSeparator(' - ')
            ->append('Ranglijst');
    }

    public function indexAction()
    {
        return $this->_forward('players');
    }

    public function playersAction()
    {
        return $this->_showRanking('players');
    }

    public function TribesAction()
    {
        return $this->_showRanking('tribes');
    }

    private function _showRanking($section)
    {
        $view = 'list';
        $this->_model = $this->_helper->model($section);
        $paginator = $this->_model->getPaginator();

        if (!$this->_hasParam('page') && $this->_hasParam('find'))
            $this->_findPage();

        $page = $this->_getParam('page', 1);

        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
        $this->view->section = $section;

        return $this->render($view);
    }

    private function _findPage()
    {
        $name = $this->_getParam('find', null);

        if ($name !== null)
            $page = $this->_model->findPage($name);

        if ($page)
            $this->_setParam('page', $page);
    }
}

