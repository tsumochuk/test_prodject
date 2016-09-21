<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
// from http://framework.zend.com/manual/2.1/en/modules/zend.navigation.quick-start.html
// the array was empty before that
return array( // ToDO make it dynamic - comes from the DB
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Головна',
                'route' => 'home',
		// 'class' => 'item-1', // with the help of ->setAddClassToListItem(true) the class will be moved to li or a tags
		// 'anchor_class' => "mmhome",
		// 'type' => 'Csn\Zend\Navigation\Page\Mvc',
            ),
            array(
                'label' => 'Увійти', // 'Page #2',
                'route' => 'auth/default', // 'page-2',
				'controller' => 'login',
				'action'	=> 'index',
				'resource'   => 'Auth\Controller\Login', // 'mvc:admin',
				'privilege'	=> 'index'
            ),
            array(
                'label' => 'Реєстрація', // 'Page #2',
                'route' => 'auth/default', // 'page-2',
                    'controller'=> 'registration',
                    'action'    => 'index',
                    'resource'  => 'Auth\Controller\Registration', // 'mvc:admin',
                    'privilege' => 'index'
            ),
            array(
                'label' => 'Керування користувачами',
                'route' => 'auth/paginator',
                    'controller'=>'admin',
                    'action'    =>'index',
                    'resource'  =>'Auth\Controller\Admin',
                    'privilege' =>'index',
            ),
            array(
                'label' => 'Керування товарами', // 'Page #2',
                'route' => 'products', // 'page-2',
                    'controller'=>'index',
                    'action'=>'index',
                    'resource'=>'Products\Controller\Index', // 'mvc:admin',
                    'privilege'=>'index'
            ),
            array(
                'label' =>  'Керування замовленнями',
                'route' =>  'products/default',
                    'controller'    =>  'order',
                    'action'        =>  'all',
                    'resource'      =>  'Products\Controller\Order',
                    'privilege'     =>  'all'
            ),
            array(
                'label' =>  'Мої замовлення',
                'route' =>  'products/default',
                'controller'    => 'order',
                'action'    =>  'my',
                'resource'      =>  'Products\Controller\Order',
                'privilege'     =>  'my'
            ),
            array(
                'label' => 'Вийти', // 'Page #2',
                'route' => 'auth/default', // 'page-2',
                    'controller' => 'login',
                    'action'	=> 'logout',
                    'resource'   => 'Auth\Controller\Login', // 'mvc:admin',
                    'privilege'	=> 'logout'
            ),
         ),				  
     ),
     'service_manager' => array(
         'factories' => array(
             'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
         ),
     ),
);
