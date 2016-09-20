<?php
namespace Products\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;;

class OrderTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
    public function fetchAll($paginated=false)
    {
        if ($paginated) {
            // create a new Select object for the table album
            $select = new Select('order');
            $select->order('order_id DESC');
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Order());
            // create a new pagination adapter object
            $paginatorAdapter = new DbSelect(
                // our configured select object
                $select,
                // the adapter to run it against
                $this->tableGateway->getAdapter(),
                // the result set to hydrate
                $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    public function fetchAllDESC()
    {
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->order('order_id DESC');
        });
        return $resultSet;
    }
	    
    public function getOrder($order_id)
    {
        $order_id = (int) $order_id;
        $rowset = $this->tableGateway->select(array('order_id' => $order_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $order_id");
        }
        return $row; 
    }
	
    public function saveOrder(Order $order)
    {
        $data = array(
            //'order_id'              =>  $order->order_id,
            'order_user_id'		=>  $order->order_user_id,
            'order_product_id'		=>  $order->order_product_id,
            'order_amount'		=>  $order->order_amount,
            'order_price'		=>  $order->order_price,
            'order_create_date'         =>  $order->order_create_date,
            'order_status'              =>  $order->order_status,
        );
        
        $order_id = (int) $order->order_id;
        if ($order_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getOrder($order_id)) {
                $this->tableGateway->update($data, array('order_id' => $order_id));
            } else {
                throw new \Exception('Upload ID does not exist');
            }
        }
    }
	
    public function findOrder($order_id)
    {
	$order_id = (int) $order_id;
        $resultSet = $this->tableGateway->select(array('order_id' => $order_id));
        return $resultSet;
    }
    
    public function findMyOrder($user_id) 
    {
        $order_user_id = (int) $user_id;
        $resultSet = $this->tableGateway->select(array('order_user_id' => $user_id));
        return $resultSet;
    }
    
    public function deleteOrder($order_id)
    {
	$order_id = (int) $order_id;
        $this->tableGateway->delete(array('order_id' => $order_id));   
    }
}