<?php

namespace SspContact\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ContactController extends AbstractActionController
{
    public function indexAction()
    {
        echo 'contact-controller-test';
        
        return array();
    }

    public function fooAction()
    {
        return array();
    }
}
