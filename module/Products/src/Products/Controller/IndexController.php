<?php

namespace Products\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

use Products\Model\Product;
use Products\Form\ProductForm;
use Products\Form\ProductFilter;
use Products\Form\ProductEditFilter;

use Zend\Stdlib\ParametersInterface;

class IndexController extends AbstractActionController
{
	
	protected $productTable = null;

    public function indexAction()
    {
			$paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbTableGateway($this->getProductTable()));

            $page = 1;
            if ($this->params()->fromRoute('page')) {
            $page = $this->params()->fromRoute('page');}
            $paginator->setCurrentPageNumber((int)$page);
            $paginator->setItemCountPerPage(5);
            return new ViewModel(array('rowset' => $paginator));
		 //return new ViewModel(array(
         //   'rowset' => $this->getProductTable()->fetchAll()));
    }
	
	public function addAction() 
	{
		$form = new ProductForm();
		$form->get('submit')->setValue('Add now');
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$form->setInputFilter(new ProductFilter($this->getServiceLocator()));
			$form->setData($request->getPost());
			 if ($form->isValid()) {			 
				$data = $form->getData();
				$data = $this->prepareData($data);
				$product = new Product();
				$product->exchangeArray($data);

				$this->ProductTable()->saveProduct($product);
				
				return $this->redirect()->toRoute('products/default', array('controller'=>'index', 'action'=>'index'));					
			}			 
		}
		
		return new ViewModel(array('form' => $form));
	}
	
	public function editAction()
    {
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('products/default', array('controller' => 'index', 'action' => 'index'));
		$form = new ProductForm();
		$request = $this->getRequest();
        if ($request->isPost()) {
		$form->setInputFilter(new ProductEditFilter($this->getServiceLocator()));
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				//if (empty($data['product_create_date'])) $data['product_create_date'] = '2013-07-19 12:00:00';
				$this->getProductTable()->update($data, array('product_id' => $id));
				return $this->redirect()->toRoute('products/default', array('controller' => 'index', 'action' => 'index'));													
			}			 
		}
		else {
			$form->setData($this->getProductTable()->select(array('product_id' => $id))->current());			
		}
		
		return new ViewModel(array('form' => $form, 'id' => $id));
	}
	
	public function deleteAction()
    {
		$id = $this->params()->fromRoute('id');
		if ($id) {
			$this->getProductTable()->delete(array('product_id' => $id));
		}
		
		return $this->redirect()->toRoute('products/default', array('controller' => 'index', 'action' => 'index'));											
	}
	
	public function viewAction() 
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('products/default', array('controller' => 'index', 'action' => 'index'));
        return new ViewModel(array('rowset' => $this->ProductTable()->getProduct($id)));
	}
	
	public function AllAction() 
	{
			$paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbTableGateway($this->getProductTable()));

            $page = 1;
            if ($this->params()->fromRoute('page')) {
            $page = $this->params()->fromRoute('page');}
            $paginator->setCurrentPageNumber((int)$page);
            $paginator->setItemCountPerPage(2);
            return new ViewModel(array('rowset' => $paginator));
	}
	
	
	public function prepareData($data) 
	{
		$date = new \DateTime();
		$data['product_create_date'] = $date->format('Y-m-d H:i:s');
		return $data;
	}
	
	public function ProductTable()
    {
        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Products\Model\ProductTable');
        }
        return $this->productTable;
    }
	
	public function getProductTable()
    {
	// I have a Table data Gateway ready to go right out of the box
	if (!$this->productTable) {
            $this->productTable = new TableGateway(
		'product', 
		$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
                //new \Zend\Db\TableGateway\Feature\RowGatewayFeature('usr_id') // Zend\Db\RowGateway\RowGateway Object
                //ResultSetPrototype
            );
	}
	return $this->productTable;
    }
}

