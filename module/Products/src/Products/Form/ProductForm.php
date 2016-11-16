<?php

namespace Products\Form;

use Zend\Form\Form;

class ProductForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Add product');
        $this->setAttribute('method', 'post');
		$this->setAttribute('class', 'bs-example form-horizontal');

        $this->add(array(
             'name' => 'product_id',
             'type' => 'Hidden',
         ));
        $this->add(array(
             'name' => 'product_create_date',
             'type' => 'Hidden',
         ));
         $this->add(array(
            'name' => 'product_name',
            'attributes' => array(
                'type'  => 'text',
				'class' => 'form-control',
                'required' => 'required',
                
            ),
            'options' => array(
                'label' => 'Назва товару',
            ),
        ));
        
        $this->add(array(
            'name' => 'product_discribe',
            'attributes' => array(
                'type'  => 'textarea',
				'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Опис товару',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'product_price',
            'attributes' => array(
                'type'  => 'text',
				'class' => 'form-control',
                'required' => 'required',
				
            ),
            'options' => array(
                'label' => 'Ціна',
            ),
        ));
		
		$this->add(array(
            'name' => 'product_amount',
            'attributes' => array(
                'type'  => 'text',
				'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Кількість',
            ),
        ));

	//_______________________________________________	
	/*	$this->add(array(
            'name' => 'new_price',
            'attributes' => array(
                'type'  => 'number',
				'class' => 'form-control',
                'required' => 'required',
				'min'  => '0',
				'max'  => '100000',
				'step' => 'any',
				 'value' => 'Go',
            ),
            'options' => array(
                'label' => 'new price',
            ),
        ));
		
		$this->add(array(
            'name' => 'new_amount',
            'attributes' => array(
                'type'  => 'number',
				'class' => 'form-control',
                'required' => 'required',
				'min'  => '0',
				'max'  => '100000',
				'step' => '1',
            ),
            'options' => array(
                'label' => 'new amount',
            ),
        ));
		*/
		//_______________________________________________	
         
		
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