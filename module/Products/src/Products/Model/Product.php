<?php 
namespace Products\Model;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
 
class Product implements InputFilterAwareInterface
{
    public $product_id;
    public $product_name;
    public $product_discribe;
    public $product_price;
    public $product_amount;
    public $product_create_date;
	
    protected $inputFilter;
     
    public function exchangeArray($data)
    {
        $this->product_id  = (isset($data['product_id'])) ? $data['product_id']      : null; 
        $this->product_name  = (isset($data['product_name'])) ? $data['product_name']      : null; 
	$this->product_discribe  = (isset($data['product_discribe'])) ? $data['product_discribe']      : null; 
        $this->product_price  = (isset($data['product_price'])) ? $data['product_price']      : null; 
	$this->product_amount  = (isset($data['product_amount'])) ? $data['product_amount']      : null; 
	$this->product_create_date  = (isset($data['product_create_date'])) ? $data['product_create_date']      : null; 
   
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
              
            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'product_name',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 100,
                            ),
                        ),
                    ),
                ))
            );
             
            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'product_discribe',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 1000,
                            ),
                        ),
                    ),
                ))
            );
			
			$inputFilter->add(array(
                'name'     => 'product_price',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Digits'),
                ),
            ));
			
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
