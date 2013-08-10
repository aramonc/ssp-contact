<?php

namespace SspContact\Controller;

use SspContact\Entity\Contact as ContactEntity;
use SspContact\Form\ContactFilter;
use SspContact\Form\ContactForm;
use SspContact\Mail\SspSendGridTransport;
use Zend\Mail\Address;
use Zend\Mail\Message;
use Zend\Mvc\Controller\AbstractActionController;

class ContactController extends AbstractActionController
{
    public function indexAction()
    {
        $contactForm = new ContactForm();
        $contactForm->setAttribute('action', $this->url()->fromRoute('contact-index', array('action' => 'send')));

        $this->flashMessenger()->setNamespace('contact-errors');
        if ($this->flashMessenger()->hasMessages()) {
            $messages = $this->flashMessenger()->getMessagesFromNamespace('contact-errors');

            $contactForm->setMessages($messages[0]);
            $data = $this->prg($this->url()->fromRoute('contact-index', array('action' => 'index')), true);
            if (is_array($data)) {
                $contactForm->setData($data);
                $contactForm->isValid();
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
            return $this->prg($this->url()->fromRoute('contact-index', array('action' => 'index')), true);
        }

        $entity = new ContactEntity($filter->getValues());

        // SAVE TO THE DB
        /* @var $mapper \SspContact\Mapper\Contact */
        $mapper = $this->getServiceLocator()->get('contact_mapper');
        $mapper->insert($entity);

        // PREPARE THE EMAIL MESSAGE
        $message = new Message();
        $message->addFrom(new Address($entity->getEmail(),$entity->getFirstName() . ' ' . $entity->getLastName()));
        $message->setSubject($entity->getSubject());

        $body = <<<MSG
New Message \n
From: {$entity->getFirstName()} {$entity->getLastName()} \n
Subject: {$entity->getSubject()} \n
Message: {$entity->getMessage()} \n
MSG;

        $message->setBody($body);

        // SEND THE EMAIL

//        $transport = new SspSendGridTransport($this->getServiceLocator()->get('Config'));
//        $transport->send($message);
        $result = $this->getServiceLocator()->get('transport')->send($message);
        if(isset($result['message']) && $result['message'] == 'error') {
            $this->flashMessenger()->addMessage($result['errors']);
            return $this->prg($this->url()->fromRoute('contact-index', array('action' => 'index')), true);
        }


        return $this->redirect()->toRoute('contact-index', array('action' => 'thanks'));
    }

    public function thanksAction()
    {

        return array();
    }

}
