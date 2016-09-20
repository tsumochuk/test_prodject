<?php

namespace Magazin\Form;

use Zend\Form\Form;

class SortForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Сортування');
        $this->setAttribute('method', 'get');
		$this->setAttribute('class', 'bs-example form-horizontal');
               
       /* $this->add(array(
            'name' => 'sort1',
			'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Критерій сортування',
				'value_options' => array(
                                    '1' => 'Показати найновіші товари',
                                    '2' => 'Сортувати за ціною',
                                    '3' => 'Показати найдешевші товари',
                                    '4' => 'Показати найдорощі товари',
				),
            ),
        ));*/

		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'sort2',
				'options' => array(
					'label' => 'Виберіть критерій сортування',
					'value_options' => array(
						'1' => 'Показати найновіші товари',
                        '2' => 'Сортувати за ціною',
                        '3' => 'Показати найдешевші товари',
                        '4' => 'Показати найдорощі товари',
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