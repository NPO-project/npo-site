<?php

class PlayerController extends Zend_Controller_Action
{
    public function migrateAction()
    {
        $model = new \Npo\Model\Players;
        $view = 'json';

        $this->_helper->layout->setLayout('json');
        $this->view->result = $model->migrate('http://nl15.tribalwars.nl/map/player.txt.gz');

        return $this->render($view);
    }
}

