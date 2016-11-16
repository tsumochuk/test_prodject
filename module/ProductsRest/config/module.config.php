<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ProductsRest\Controller\ProductsRest' => 'ProductsRest\Controller\ProductsRestController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'products-rest' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/products-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ProductsRest\Controller\ProductsRest',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
         'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);