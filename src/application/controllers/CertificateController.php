<?php

class CertificateController extends Zend_Controller_Action
{
    
    public function indexAction()
    {
        $cert = new \Npo\Entity\Certificate;
        $cert->player = 'Someone';
        $this->view->headTitle('Tribal Wars NPO-Manifest')
            ->setSeparator(' - ')
            ->append($cert->player . '\'s certificaat');
        $this->view->assign('cert', $cert);
    }

}
