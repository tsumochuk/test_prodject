<?php
namespace Products\Form;

use Zend\InputFilter\InputFilter;

class OrderAddFilter extends InputFilter
{
    public function __construct($sm)
    {
        $this->add(array(
            'name'     => 'order_amount',
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