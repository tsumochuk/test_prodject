<?php

return array(
'controllers' => array(
        'invokables' => array(
            'Products\Controller\Index'  => 'Products\Controller\IndexController',     
            'Products\Controller\Order'  => 'Products\Controller\OrderController',
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
                    'paginator_order' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/order/:controller/[page/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*',
                            ),
                            'defaults' => array(
                               '__NAMESPACE__' => 'Products\Controller',
                                'controller'    => 'order',
                                'action'        => 'all',
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
    ),
);

