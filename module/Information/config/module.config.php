<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Information\Controller\Information' => 'Information\Controller\InformationController',
         ),
     ),
     'router' => array(
         'routes' => array(
             'information' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/information[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Information\Controller\Information',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'album' => __DIR__ . '/../view',
         ),
     ),
 );