<?php

namespace SspContact\Controller;

use SspContact\Form\ContactFilter;
use SspContact\Form\ContactForm;
use Zend\Mvc\Controller\AbstractActionController;

class ContactController extends AbstractActionController
{
    public function indexAction()
    {
        $contactForm = new ContactForm();
        $contactForm->setAttribute('action', $this->url()->fromRoute('contact-index', array('action' => 'send')));

        $this->flashMessenger()->setNamespace('contact-errors');
        $messages = false;
        if ($this->flashMessenger()->hasMessages()) {
            $messages = $this->flashMessenger()->getMessagesFromNamespace('contact-errors');
            $contactForm->setMessages($messages[0]);
            $data = $this->prg($this->url()->fromRoute('contact-index', array('action' => 'index')), true);
            if (is_array($data)) {
                $contactForm->setData($data);
            }
        }

        return array('form' => $contactForm);
    }

    public function sendAction()
    {
        $this->flashMessenger()->setNamespace('contact-errors');
        $this->flashMessenger()->clearMessages();
        $data = $this->params()->fromPost();
        $filter = new ContactFilter();

        // FILTER & RETURN ERRORS
        $filter->setData($data);
        if(!$filter->isValid()) {
            $this->flashMessenger()->addMessage($filter->getMessages());
            return $this->prg($this->url()->fromRoute('contact-index', array('action' => 'send')), true);
        }

        return $this->redirect()->toRoute('contact-index', array('action' => 'thanks'));
    }

    public function thanksAction()
    {

        return array();
    }

}
