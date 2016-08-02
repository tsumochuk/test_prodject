<?php
// http://p0l0.binware.org/index.php/2012/02/18/zend-framework-2-authentication-acl-using-eventmanager/
// First I created an extra config for ACL (could be also in module.config.php, but I prefer to have it in a separated file)
return array(
    'acl' => array(
        'roles' => array(
            'guest'   => null,
            'member'  => 'guest',
            'admin'  => 'member',
        ),
        'resources' => array(
            'allow' => array(
				'Magazin\Controller\Index' => array(
					'index'	=> 'guest',
					'task'	=> 'guest',
				
					//'add'	=> 'admin',
					//'delete'=> 'admin',
				),
				
				'Application\Controller\Index' => array(
					'all'   => 'guest'					
				),
				'Auth\Controller\Login' => array(
					'index' => 'guest',
					'logout'=> 'member',
                    //'all'   => 'member',	
					//'all'   => 'guest'					
				),
				'Auth\Controller\Admin' => array(
					'index' => 'admin',
                    // 'all'   => 'member',	
					//'all'   => 'guest'
					'view' => 'admin',
				),
				'Auth\Controller\Registration' => array(
					// 'index' => 'guest',
                    // 'all'   => 'member',	
					'index'   => 'guest'					
				),
				'Products\Controller\Index' => array(
					'index' => 'admin',
                    'all'   => 'admin',	
					'add' 	=> 'admin',
					'edit'  => 'admin',
					'view'	=> 'guest',
				),
			
            ),
			'deny' => array (
				'Auth\Controller\Login' => array(
					'index' => 'member',
					//'logout'=> 'member',
                    //'all'   => 'member',	
					//'all'   => 'guest'					
				),
				'Auth\Controller\Registration' => array(
					// 'index' => 'guest',
                    // 'all'   => 'member',	
					'index'   => 'member'					
				),

			),
        )
    )
);
