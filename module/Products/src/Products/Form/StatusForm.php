<?php

namespace Products\Form;

use Zend\Form\Form;

class StatusForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Змінити статус');
        $this->setAttribute('method', 'post');
		$this->setAttribute('class', 'bs-example form-horizontal');
               
        $this->add(array(
            'name' => 'order_status',
			'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Виберіть статус замовлення...',
				'value_options' => array(
					'0' => 'Нове замовлення, нерозглянуте, можливо відмінити',
					'1' => 'Розглянуте, відміна неможлива',
				),
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