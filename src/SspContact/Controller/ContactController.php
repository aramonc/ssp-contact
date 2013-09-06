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

        /* @var $contactService \SspContact\Service\ContactService */
        $contactService = $this->getServiceLocator()->get('contact_service');

        // FILTER & RETURN ERRORS
        if(!$contactService->contactIsValid($data)) {
            $this->flashMessenger()->addMessage($contactService->getContactFilter()->getMessages());
            return $this->prg($this->url()->fromRoute('contact-index', array('action' => 'index')), true);
        }

        $message = new ContactEntity($contactService->getContactFilter()->getRawValues());

        $contactService->saveContact($message);

        $sendResult = $contactService->sendMessage($message);

        if(isset($sendResult['message']) && $sendResult['message'] == 'error') {
            $this->flashMessenger()->addMessage($sendResult['errors']);
            return $this->prg($this->url()->fromRoute('contact-index', array('action' => 'index')), true);
        }

        return $this->redirect()->toRoute('contact-index', array('action' => 'thanks'));
    }

    public function thanksAction()
    {
        return array();
    }

}
