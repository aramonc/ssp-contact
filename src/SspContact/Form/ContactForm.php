<?php
namespace SspContact\Form;

use Zend\Captcha\Image;
use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = 'contact')
    {
        parent::__construct($name);

        // HIDDENS
        $this->add(
            array(
                'name' => 'id',
                'type' => 'Hidden',
                'attributes' => array(
                    'id' => 'contact_id',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'is_active',
                'type' => 'Hidden',
                'attributes' => array(
                    'id' => 'contact_active',
                ),
            )
        );

        // NAME
        $this->add(
            array(
                'name' => 'first_name',
                'type' => 'Text',
                'attributes' => array(
                    'id' => 'contact_first',
                ),
                'options' => array(
                    'label' => 'First',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'last_name',
                'type' => 'Text',
                'attributes' => array(
                    'id' => 'contact_last',
                ),
                'options' => array(
                    'label' => 'Last'
                ),
            )
        );

        // EMAIL
        $this->add(
            array(
                'name' => 'email',
                'type' => 'Email',
                'attributes' => array(
                    'id' => 'contact_email',
                ),
                'options' => array(
                    'label' => 'E-mail:',
                ),
            )
        );

        // SUBJECT
        $this->add(
            array(
                'name' => 'subject',
                'type' => 'Text',
                'attributes' => array(
                    'id' => 'contact_subject',
                ),
                'options' => array(
                    'label' => 'Subject:'
                )
            )
        );

        // MESSAGE
        $this->add(
            array(
                'name' => 'message',
                'type' => 'Textarea',
                'attributes' => array(
                    'id' => 'contact_message',
                ),
                'options' => array(
                    'label' => 'Message:',
                )
            )
        );

        // CAPTCHA
        $this->add(
            array(
                'name' => 'human_test',
                'type' => 'Captcha',
                'options' => array(
                    'label' => 'Word Verification:',
                    'captcha' => new Image(array(
                        'expiration' => 3600,
                        'font' => realpath(__DIR__ . '/../../../data/data-latin.ttf'),
                        'imgDir' => realpath(__DIR__ . '/../../../../../public/img'),
                        'imgUrl' => '/img',
                    )),
                ),
            )
        );
    }
}