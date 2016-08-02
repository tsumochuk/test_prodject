<?php

return array(
'controllers' => array(
        'invokables' => array(
            'Products\Controller\Index'  => 'Products\Controller\IndexController',           
        ),
    ),
	'router' => array(
        'routes' => array(
        'products' => array(
		'type'    => 'Literal',
		'options' => array(
                    'route'    => '/products',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Products\Controller',
                        'controller'    => 'index',
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
                               '__NAMESPACE__' => 'Products\Controller',
                                'controller'    => 'index',
                                'action'        => 'index',
                            ),
                        ),
                    ),
					
                ),
            ),			
		),
    ),
    /*'router' => array(
        'routes' => array(
            'products' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/products[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Products',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),*/
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);

