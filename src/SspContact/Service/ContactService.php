<?php
/**
 * Service (business logic) of the contact module
 *
 * @package SspContact
 * @author Adrian Cardenas <arcardenas@gmail.com>
 * @copyright Sunshine PHP 2014
 *
 */

namespace SspContact\Service;


use SspContact\Entity\Contact;
use SspContact\Form\ContactFilter;
use Zend\Mail\Address;
use Zend\Mail\Message;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactService implements ServiceLocatorAwareInterface
{
    private $sl;

    protected $contactFilter;

    /**
     * Saves the contact message to the database for later administration
     * @param Contact $contactMessage
     */
    public function saveContact(Contact $contactMessage)
    {
        /* @var $mapper \SspContact\Mapper\Contact */
        $mapper = $this->getServiceLocator()->get('contact_mapper');
        $mapper->insert($contactMessage);
    }

    /**
     * Composes & sends the email from a contact message
     * @param Contact $contactMessage
     * @return mixed
     */
    public function sendMessage(Contact $contactMessage)
    {
        // PREPARE THE EMAIL MESSAGE
        $message = new Message();
        $message->addFrom(new Address($contactMessage->getEmail(), $contactMessage->getFirstName() . ' ' . $contactMessage->getLastName()));
        $message->setSubject($contactMessage->getSubject());

        $body = <<<MSG
New Message \n
From: {$contactMessage->getFirstName()} {$contactMessage->getLastName()} \n
Subject: {$contactMessage->getSubject()} \n
Message: {$contactMessage->getMessage()} \n
MSG;

        $message->setBody($body);

        // SEND THE EMAIL
        return $this->getServiceLocator()->get('transport')->send($message);
    }

    /**
     * Validates the contact message
     * @param array $data
     * @return bool
     */
    public function contactIsValid(array $data)
    {
        $this->getContactFilter()->setData($data);
        return $this->getContactFilter()->isValid();
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->sl = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->sl;
    }

    /**
     * @return ContactFilter
     */
    public function getContactFilter()
    {
        if(!$this->contactFilter) {
            $this->contactFilter = new ContactFilter();
        }
        return $this->contactFilter;
    }

    /**
     * @param ContactFilter $contactFilter
     */
    public function setContactFilter(ContactFilter $contactFilter)
    {
        $this->contactFilter = $contactFilter;
    }
}