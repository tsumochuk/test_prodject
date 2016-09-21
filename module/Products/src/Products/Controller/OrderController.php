<?php

namespace Products\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

use Products\Model\Order;
use Products\Form\OrderAddForm;
use Products\Form\OrderAddFilter;
use Products\Form\StatusForm;
use Products\Form\StatusFormFilter;



/*
int order_status
 *  0 - щойно замовлений, нерозглянутий, можна змінити або відмінити
 *  1 - розглянутий заказ, змінити неможливо
*/

class OrderController extends AbstractActionController
{
    protected $productTable = null;
    protected $orderTable   = null;
    protected $usersTable = null;


    public function AllAction()
	{
		$paginator = $this->OrderTable()->fetchAll(true);
		$paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1)); 
		$paginator->setItemCountPerPage(5);
		return new ViewModel(array('rowset' => $paginator));	
	}
	
	public function MyAction()
	{
        return new ViewModel(array(
            'myorder' => $this->OrderTable()->findMyOrder($this->getUserId())
        ));
	}
	
	public function AddAction()
	{
         $id = $this->params()->fromRoute('id');
            
        $form = new OrderAddForm();
        $form->get('submit')->setValue('Замовити');
            
        $request = $this->getRequest();
            
        if($request->isPost()) {
            $form->setInputFilter(new OrderAddFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $data = $this->prepareData($data, $id);
                $order = new Order();
                $order->exchangeArray($data);
                $this->OrderTable()->saveOrder($order);         
                $this->updateProductAmount($data, $id);
                return $this->redirect()->toRoute('home');					        
                }
            } 
        return new ViewModel(array(
                'form' => $form,
                'product' => $this->ProductTable()->getProduct($id),
                'user' => $this->identity()
         )); 
	}
	
	public function CancelAction()
	{
            $id = $this->params()->fromRoute('id');
            if (!$id) return $this->redirect()->toRoute('products/default', array('controller' => 'order', 'action' => 'my'));
            $order_inf = $this->OrderTable()->getOrder($id);
            if ($order_inf->order_status == 0) {
                $this->returnProductAmount($order_inf->order_product_id, $order_inf->order_amount);
                $this->OrderTable()->deleteOrder($id);
                return $this->redirect()->toRoute('products/default', array('controller' => 'order', 'action' => 'my'));
                
            } else return $this->redirect()->toRoute('products/default', array('controller' => 'order', 'action' => 'my'));
	}
	
    public function ViewAction()
	{
        $id = $this->params()->fromRoute('id');
        if (!$id) return $this->redirect()->toRoute('products/default', array('controller' => 'order', 'action' => 'all'));
        $order_inf = $this->OrderTable()->getOrder($id);
        $product_inf = $this->ProductTable()->getProduct($order_inf->order_product_id);
        $user_inf = $this->UserTable()->getUser($order_inf->order_user_id);
        return new ViewModel(array(
                'order_inf' => $order_inf,
                'product_inf' => $product_inf,
                'user_inf' => $user_inf,
        ));
	}
    
	public function MyviewAction() 
    {
        $id = $this->params()->fromRoute('id');
        if (!$id) return $this->redirect()->toRoute('products/default', array('controller' => 'order', 'action' => 'my'));
        $order_inf = $this->OrderTable()->getOrder($id);
        $product_inf = $this->ProductTable()->getProduct($order_inf->order_product_id);
        $user_inf = $this->UserTable()->getUser($order_inf->order_user_id);
        return new ViewModel(array(
            'order_inf' => $order_inf,
            'product_inf' => $product_inf,
            'user_inf' => $user_inf,
        ));
    }
	
	public function StatusAction()
	{
        $id = $this->params()->fromRoute('id');
        if (!$id) return $this->redirect()->toRoute('products/default', array('controller' => 'order', 'action' => 'all'));
        $form = new StatusForm();
        $form->get('submit')->setValue('Змінити статус');
        $request = $this->getRequest();
            if ($request->isPost()) {
                $form->setInputFilter(new StatusFormFilter($this->getServiceLocator()));
				$form->setData($request->getPost());
				if ($form->isValid()) {
                    $data = $form->getData();
                    unset($data['submit']);				
                    $this->getOrderTable()->update($data, array('order_id' => $id));
                    return $this->redirect()->toRoute('products/default', array('controller' => 'order', 'action' => 'all'));													
				}			 
			}
			else{
                $form->setData($this->getOrderTable()->select(array('order_id' => $id))->current());			
			}	
		return new ViewModel(array('form' => $form, 'id' => $id));
	}

    public function prepareData($data, $id)       
    {
        $date = new \DateTime();
        $data['order_user_id'] = $this->getUserId();
        $data['order_product_id'] = $id;
        $data['order_price'] = $data['order_amount'] * $this->getProductPrice($id);
        $data['order_create_date'] = $date->format('Y-m-d H:i:s');
        $data['order_status'] = 0;
            
        return $data;
    }
	
    public function getUserId() 
    {
        return $this->identity()->usr_id;
    }

    public function getProductPrice($id) 
    {
        $id = (int)$id;
        $item = $this->ProductTable()->getProduct($id);
        return $item->product_price;
    }
	
    public function getProductAmount($id) 
    {
        $id = (int)$id;
        $item = $this->ProductTable()->getProduct($id);
        return $item->product_amount;
    }
	
    public function updateProductAmount($data, $id)
    {
        $id = (int)$id;
        $newAmount = $this->getProductAmount($id) - $data['order_amount'];
        $this->ProductTable()->updateProductAmount($id, $newAmount);    
    }
    
    public function returnProductAmount($id,  $addamount) 
    {
        $id = (int)$id;
        $newAmount = $this->getProductAmount($id) + $addamount;
        $this->ProductTable()->updateProductAmount($id, $newAmount);   
    }

    public function ProductTable()
    {
        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Products\Model\ProductTable');
        }
        return $this->productTable;
    }
	
    public function OrderTable()
    {
        if (!$this->orderTable) {
            $sm = $this->getServiceLocator();
            $this->orderTable = $sm->get('Products\Model\OrderTable');
        }
        return $this->orderTable;
    }
	
    public function getOrderTable()
    {
		if (!$this->orderTable) {
			$this->orderTable = new TableGateway(
			'order', 
			$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')

				);
		}
		return $this->orderTable;
    }
	
    public function UserTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('Auth\Model\UsersTable');
        }
        return $this->usersTable;
    }
}

