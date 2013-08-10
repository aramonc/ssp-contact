<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aramonc
 * Date: 7/21/13
 * Time: 12:17 PM
 * To change this template use File | Settings | File Templates.
 */

namespace SspContact\Form;


use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname;

class ContactFilter extends InputFilter
{

    public function __construct()
    {
        // HIDDENS
        $this->add(
            array(
                'name' => 'id',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )
        );

        $this->add(
            array(
                'name' => 'is_active',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )
        );

        // NAME
        $this->add(
            array(
                'name' => 'first_name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 255,
                        ),
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name' => 'last_name',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 255,
                        ),
                    ),
                ),
            )
        );

        // EMAIL
        $this->add(
            array(
                'name' => 'email',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                        'options' => array(
                            'allow' => Hostname::ALLOW_DNS,
                            'domain' => true,
                        ),
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 255,
                        ),
                    ),
                ),
            )
        );

        // SUBJECT
        $this->add(
            array(
                'name' => 'subject',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 140,
                        ),
                    ),
                ),
            )
        );

        // MESSAGE
        $this->add(
            array(
                'name' => 'message',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )
        );
    }

}