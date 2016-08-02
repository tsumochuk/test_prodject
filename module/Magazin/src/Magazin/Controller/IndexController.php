<?php

namespace Magazin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

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
        $paginator->setItemCountPerPage(3);
        return new ViewModel(array('rowset' => $paginator)); 
    }
		
	public function taskAction()
    {
        return new ViewModel();    
    }



	public function getProductTable()
    {
		if (!$this->productTable) {
			$this->productTable = new TableGateway(
			'product', 
			$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
			);
		}
	return $this->productTable;
    }	
	

}

