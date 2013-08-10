<?php

namespace SspContact\Controller;

use SspContact\Form\ContactForm;
use Zend\Mvc\Controller\AbstractActionController;

class ContactController extends AbstractActionController
{
    public function indexAction()
    {
        $contactForm = new ContactForm();
        return array('form' => $contactForm);
    }


}
