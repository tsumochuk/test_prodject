<?php
namespace Products\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProductTable
{
    protected $tableGateway;
    protected $s1= 'product_id DESC';
    protected $s2= 'product_name ASC';
    protected $s3 = 'product_price ASC';
    protected $s4= 'product_price DESC';
    protected $sortType = '';


    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
    public function fetchAll($paginated=false, $flag)
    {
        if ($paginated) {
            // create a new Select object for the table album
            $select = new Select('product');
			$select->order($this->sortType($flag) );
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Product());
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
	
	
	public function fetch()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
	
	    
	public function getProduct($product_id)
    {
        $product_id = (int) $product_id;
        $rowset = $this->tableGateway->select(array('product_id' => $product_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $product_id");
        }
        return $row; 
    }
	
    public function saveProduct(Product $product)
    {
        $data = array(
            //'product_id'		=>  $product->product_id,
            'product_name'		=>  $product->product_name,
            'product_discribe'		=>  $product->product_discribe,
            'product_price'		=>  $product->product_price,
            'product_amount'		=>  $product->product_amount,
            'product_create_date'	=>  $product->product_create_date,
        );
        
        $product_id = (int) $product->product_id;
        if ($product_id == 0) {
            $this->tableGateway->insert($data);
            $product_id = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getProduct($product_id)) {
            //if($product_id!=0){
                $this->tableGateway->update($data, array('product_id' => $product_id));
            } else {
                throw new \Exception('Upload ID does not exist');
            }
        }
        return $product_id;
    }
    public function updateProduct(Product $product)
    {
        $data = array(
            'product_id'		=>  $product->product_id,
            'product_name'		=>  $product->product_name,
            'product_discribe'		=>  $product->product_discribe,
            'product_price'		=>  $product->product_price,
            'product_amount'		=>  $product->product_amount,
            'product_create_date'	=>  $product->product_create_date,
        );
        
        $product_id = (int) $product->product_id;
        
        $this->tableGateway->update($data,
                                    array('product_id' => $product_id)); 
    }
	
    public function findProduct($id)
    {
		$id = (int) $id;
        $resultSet = $this->tableGateway->select(array('product_id' => $id));
        return $resultSet;
    }
    
    public function updateProductAmount($product_id, $newAmount) 
    {
        $product_id = (int) $product_id;
        $this->tableGateway->update(array('product_amount' => $newAmount),
                                    array('product_id' => $product_id));  
    }
    
    public function deleteProduct($product_id)
    {
	$product_id = (int) $product_id;
        $this->tableGateway->delete(array('product_id' => $product_id));   
    }
    
        public function sortType($flag) 
    {
        switch ($flag) {
            case 1:
                $this->sortType = 'product_id DESC';
                break;
            case 2:
                $this->sortType = 'product_name ASC';
                break;
            case 3:
                $this->sortType = 'product_price ASC';
                break;
            case 4:
                $this->sortType = 'product_price DESC';
                break;
            default :
                $this->sortType = 'product_id DESC';
                break;
        }
        return $this->sortType;
    }
}