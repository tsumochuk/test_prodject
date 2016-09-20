<?php

namespace Auth\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');
	$this->setAttribute('class', 'bs-example form-horizontal');

        $this->add(array(
            'name' => 'usr_firstname',
            'attributes' => array(
                'type'  => 'text',
				'class' => 'form-control',
                'required' => 'required',
                
            ),
            'options' => array(
                'label' => 'І\'мя',
            ),
        ));
        
        $this->add(array(
            'name' => 'usr_secondname',
            'attributes' => array(
                'type'  => 'text',
				'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Прізвище',
            ),
        ));
        
        	
        $this->add(array(
            'name' => 'usr_email',
            'attributes' => array(
                'type'  => 'email',
			'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'E-mail',
            ),
        ));
        
         $this->add(array(
            'name' => 'usr_phone',
            'attributes' => array(
                'type'  => 'text',
				'class' => 'form-control',
                'required' => 'required',
				'placeholder' => '(___)___ __ __',
				'id' => 'user_phone',
            ),
            'options' => array(
                'label' => 'Телефон',
            ),
        ));
        
        $this->add(array(
            'name' => 'usr_name',
            'attributes' => array(
                'type'  => 'text',
				'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Логін',
            ),
        ));
         
       
	
		
        $this->add(array(
            'name' => 'usr_password',
            'attributes' => array(
                'type'  => 'password',
				'class' => 'form-control',
                'required' => 'required',
				
            ),
            'options' => array(
                'label' => 'Пароль',
            ),
        ));
		
        $this->add(array(
            'name' => 'usr_password_confirm',
            'attributes' => array(
                'type'  => 'password',
				'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Повторіть пароль',
            ),
        ));	
		
		  

		$this->add(array(
			'type' => 'Zend\Form\Element\Captcha',
			'name' => 'captcha',
			'options' => array(
				'label' => 'Введіть зображені символи',
				'captcha' => new \Zend\Captcha\Figlet(),
			),
			'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
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