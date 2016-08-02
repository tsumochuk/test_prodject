<?php
namespace Products\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;


class ProductFilter extends InputFilter
{
    public function __construct($sm)
    {
        $this->add(array(
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
				array(
                    'name'		=> 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table'   => 'product',
                        'field'   => 'product_name',
                        'adapter' => $sm->get('Zend\Db\Adapter\Adapter'),
                    ),
				),
            ),
		));
		
		$this->add(array(
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
		));
		
		$this->add(array(
            'name'     => 'product_price',
            'required' => true,
            'filters'  => array(
				array('name' => 'Digits'),
            ),
            'validators' => array(
				array(
					'name'    => 'Digits',
				),
			),	
		));
		
		$this->add(array(
            'name'     => 'product_amount',
            'required' => true,
            'filters'  => array(
				array('name' => 'Digits'),
            ),
            'validators' => array(
				array(
					'name'    => 'Digits',
				),
			),	
		));

			
    }
}