<?php

return array(
'controllers' => array(
        'invokables' => array(
            'Auth\Controller\Admin'         => 'Auth\Controller\AdminController',		
            'Auth\Controller\Login'         => 'Auth\Controller\LoginController', 
            'Auth\Controller\Registration'=> 'Auth\Controller\RegistrationController',
              
        ),
    ),
   'router' => array(
        'routes' => array(
        'auth' => array(
		'type'    => 'Literal',
		'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Auth\Controller',
                        'controller'    => 'Login',
                        'action'        => 'index',
                    ),
		),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     	 => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(                               
                            ),
                        ),
                    ),
                    'paginator' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/:controller/[page/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*',
                            ),
                            'defaults' => array(
                               '__NAMESPACE__' => 'Auth\Controller',
                                'controller'    => 'admin',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                ),
            ),			
	),
    ),
    'view_manager' => array(
       'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        //'display_exceptions' => true,
        //'template_path_stack' => array(
        //    'auth' => __DIR__ . '/../view'
        //),
    ),
    'service_manager' => array(
		// added for Authentication and Authorization. Without this each time we have to create a new instance.
		// This code should be moved to a module to allow Doctrine to overwrite it
		'aliases' => array( // !!! aliases not alias
			'Zend\Authentication\AuthenticationService' => 'my_auth_service',
		),
		'invokables' => array(
			'my_auth_service' => 'Zend\Authentication\AuthenticationService',
		),
	),
);

