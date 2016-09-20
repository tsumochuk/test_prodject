<?php 
namespace Products\Model;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
 
class Order implements InputFilterAwareInterface
{
    public $order_id;
    public $order_user_id;
    public $order_product_id;
    public $order_amount;
    public $order_price;
    public $order_create_date;
    public $order_status;
	
    protected $inputFilter;
     
    public function exchangeArray($data)
    {
        $this->order_id  = (isset($data['order_id'])) ? $data['order_id']      : null; 
	$this->order_user_id  = (isset($data['order_user_id'])) ? $data['order_user_id']      : null; 
	$this->order_product_id  = (isset($data['order_product_id'])) ? $data['order_product_id']      : null; 
	$this->order_amount  = (isset($data['order_amount'])) ? $data['order_amount']      : null; 
        $this->order_price  = (isset($data['order_price'])) ? $data['order_price']      : null; 
	$this->order_create_date  = (isset($data['order_create_date'])) ? $data['order_create_date']      : null; 
	$this->order_status  = (isset($data['order_status'])) ? $data['order_status']      : null; 
   
    } 
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
     
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
     
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();	
            $inputFilter->add(array(
                'name'     => 'product_amount',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Digits'),
                ),
            ));
            $this->inputFilter = $inputFilter;
        }     
        return $this->inputFilter;
    }
}
