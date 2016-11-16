<?php
namespace ProductsRest\Controller;
 
use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\Db\TableGateway\TableGateway;
 
use Products\Model\Product;
use Products\Form\ProductForm;
use Products\Model\ProductTable;
use Zend\View\Model\JsonModel;
 
class ProductsRestController extends AbstractRestfulController
{
    protected $productTable = null;
     
    public function getList()
    {
        $results = $this->getProductTable()->fetch();
        $data = array();
        foreach($results as $result) {
            $data[] = $result;
        }
        return new JsonModel(array('data' => $data));
        
    }
 
    public function get($id)
    {
       $product = $this->getProductTable()->getProduct($id);
       return new JsonModel(array('data' => $product));
    }
 
    public function create($data)
    {
        $form = new ProductForm();
        $product = new Product();
        $form->setInputFilter($product->getInputFilter());
       // $form->setInputFilter(new ProductFilter($this->getServiceLocator()));
        //$data = $this->prepareData($data);
        $form->setData($data);
        if ($form->isValid()) {
           // $data = $form->getData();
            $data = $this->prepareData($form->getData());
            $product->exchangeArray($data);
           // $product->exchageArray($this->prepareData($form->getData()));
            $id = $this->getProductTable()->saveProduct($product);
            return new JsonModel(array(
                'data' => 'Its OK! Added',
            ));
        }

    }
 
    public function update($id, $data)
    {
        $data['product_id'] = $id;
        $data = $this->prepareData($data);
      
        $product = $this->getProductTable()->getProduct($id);
        
        $form  = new ProductForm();
        $form->bind($product);
        $form->setInputFilter($product->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
             //$data = $this->prepareData($form->getData());
            $this->getProductTable()->saveProduct($form->getData());
        }
 
        return new JsonModel(array(
            'data' => $form->getData(),
        ));
 
    }
 
    public function delete($id)
    {
        $this->getProductTable()->deleteProduct($id);
 
        return new JsonModel(array(
        'data' => 'deleted',
        ));
    }
    
    public function getProductTable()
    {
        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Products\Model\ProductTable');
        }
        return $this->productTable;
    }
    
    public function prepareData($data) 
    {
	$date = new \DateTime();
	$data['product_create_date'] = $date->format('Y-m-d H:i:s');
	return $data;
    }
}