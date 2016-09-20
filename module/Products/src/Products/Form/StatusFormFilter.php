<?php
namespace Products\Form;

use Zend\InputFilter\InputFilter;

class StatusFormFilter extends InputFilter
{
	public function __construct($sm)
	{
            $this->add(array(
                'name'     => 'order_status',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'Digits',
                    ),
                ),
            ));			
	}
}