<?php

namespace Magazin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Magazin\Form\SortForm;
use Magazin\Form\SortFormFilter;

class IndexController extends AbstractActionController
{
protected $productTable = null;

public function indexAction()
    {
		$paginator = $this->getProductTable()->fetchAll(true,1);
		$paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(3);

		return new ViewModel(array('rowset' => $paginator));	
	}			 

    public function sortnameAction() 
    {
		$paginator = $this->getProductTable()->fetchAll(true,2);
		$paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(3);

		return new ViewModel(array('rowset' => $paginator));
        
    }
	    public function sortcheapAction() 
    {
		$paginator = $this->getProductTable()->fetchAll(true,3);
		$paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(3);

		return new ViewModel(array('rowset' => $paginator)); 
        
    }
	    public function sortcostlyAction() 
    {
		$paginator = $this->getProductTable()->fetchAll(true,4);
		$paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(3);

		return new ViewModel(array('rowset' => $paginator));; 
        
    }
	


    public function taskAction()
    {
        return new ViewModel();    
    }
    


    public function getProductTable()
    {
	 if (!$this->productTable) {
             $sm = $this->getServiceLocator();
             $this->productTable = $sm->get('Products\Model\ProductTable');
         }
         return $this->productTable;
     }
	

}

