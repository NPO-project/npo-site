<?php
namespace Npo\Controller\Action\Helper;

class GeneratePassword
    extends \Zend_Controller_Action_Helper_Abstract
{
    public function direct($length = 8, $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_')
    {
        $password = '';

        while ($length--)
            $password .= $alphabet{mt_rand(0, strlen($alphabet))};

        return $password;
    }
}
