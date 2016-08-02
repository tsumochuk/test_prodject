<?php
namespace Products\Model;

use Zend\Db\TableGateway\TableGateway;

class ProductTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
	public function fetchAll()
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
            //'product_id'			=>  $product->product_id,
            'product_name'			=>  $product->product_name,
			'product_discribe'		=>  $product->product_discribe,
			'product_price'			=>  $product->product_price,
			'product_amount'		=>  $product->product_amount,
			'product_create_date'	=>  $product->product_create_date,
        );
        
        $product_id = (int) $product->product_id;
        if ($product_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getProduct($product_id)) {
                $this->tableGateway->update($data, array('product_id' => $product_id));
            } else {
                throw new \Exception('Upload ID does not exist');
            }
        }
    }
	
    public function findProduct($id)
    {
		$id = (int) $id;
        $resultSet = $this->tableGateway->select(array('product_id' => $id));
        return $resultSet;
    }
    
    public function deleteProduct($product_id)
    {
		$product_id = (int) $product_id;
        $this->tableGateway->delete(array('product_id' => $product_id));   
    }
}