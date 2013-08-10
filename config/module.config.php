<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'sspcontact-contact-controller' => 'SspContact\Controller\ContactController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'contact-index' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/contact[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller'    => 'sspcontact-contact-controller',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'SspContact' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'contact_mapper' => 'SspContact\Factory\ContactMapperFactory',
            'transport' => 'SspContact\Factory\MailTransport',
        ),
    ),
    'contact' => array(
        'transport_class' => 'SspContact\\Mail\\SspSendGridTransport',
    ),
);
