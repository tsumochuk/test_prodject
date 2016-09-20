<?php
namespace Magazin\Form;

use Zend\InputFilter\InputFilter;

class SortFormFilter extends InputFilter
{
	public function __construct($sm)
	{
            $this->add(array(
                'name'     => 'sort1',
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