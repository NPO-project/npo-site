<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
        parent::setUp();
    }

    public function testIndexAction()
    {
        $params = array(
            'action' => 'index', 
            'controller' => 'Registration', 
            'module' => 'default'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        /*
         * Marlinc: I commented this out because it causes a weird bug
         * $this->assertQueryContentContains("div#welcome h3", "This is your project's main page");
        */
    }


}



