<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

class AdminController extends AbstractActionController
{
    protected $usersTable = null;
    protected $proTable = null;
    
    
    public function indexAction()
    {
    
            $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbTableGateway($this->getUsersTable()));

            $page = 1;
            if ($this->params()->fromRoute('page')) {
            $page = $this->params()->fromRoute('page');}
            $paginator->setCurrentPageNumber((int)$page);
            $paginator->setItemCountPerPage(5);
            return new ViewModel(array('rowset' => $paginator));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('auth/default', array('controller' => 'admin', 'action' => 'index'));
        return new ViewModel(array('rowset' => $this->getUsersTable()->select(array('usr_id' => $id))));  
    }

    public function getUsersTable()
    {
	if (!$this->usersTable) {
            $this->usersTable = new TableGateway(
			'users', 
			$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
            );
	}
	return $this->usersTable;
    } 
    
     public function getproTable()
        {
            if (!$this->proTable) {
                $sm = $this->getServiceLocator();
                $this->proTable = $sm->get('Auth\Model\UsersTable');
            }
            return $this->proTable;
        }
    
     
}

