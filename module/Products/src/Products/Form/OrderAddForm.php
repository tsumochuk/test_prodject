<?php

namespace Products\Form;

use Zend\Form\Form;

class OrderAddForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Add order');
        $this->setAttribute('method', 'post');
	$this->setAttribute('class', 'bs-example form-horizontal');
                
        $this->add(array(
            'type' => 'number',
            'name' => 'order_amount',
            'options' => array(
                'label' => 'Кількість товару',
                
            ),
            'attributes' => array(
                //'min'=> '',
                //'max' => '',
                //'step' => '',
                'value' => '1',
            ),
        ));
             
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
		'class' => 'btn btn-success  btn-lg btn-block'
            ),
        )); 
    }
}