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
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/contact',
                    'defaults' => array(
                        'controller'    => 'sspcontact-contact-controller',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'foo' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/foo',
                            'defaults' => array(
                                'controller' => 'sspcontact-contact-controller',
                                'action'     => 'foo',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'SspContact' => __DIR__ . '/../view',
        ),
    ),
);
