<?php

class PlayerController extends Zend_Controller_Action
{
    public function migrateAction()
    {
        $model_tribes = $this->_helper->model('tribes');
        $model_players = $this->_helper->model('players');
        $view = 'json';

        $this->_helper->layout->setLayout('json');
        $this->view->result = $model_tribes->migrate('http://nl26.tribalwars.nl/map/ally.txt.gz');
        $this->view->result = $model_players->migrate('http://nl26.tribalwars.nl/map/player.txt.gz');

        return $this->render($view);
    }
}

