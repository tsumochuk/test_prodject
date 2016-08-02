<?php
namespace Products;

use Products\Model\Product;
use Products\Model\ProductTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;




class Module 
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
	
	
	public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Products\Model\ProductTable' =>  function($sm) {
                     $tableGateway = $sm->get('ProductTableGateway');
                     $table = new ProductTable($tableGateway);
                     return $table;
                 },
                 'ProductTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Product());
                     return new TableGateway('product', $dbAdapter, null, $resultSetPrototype);
                 }, 
             ),
         );
     }
    
   
}