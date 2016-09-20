<?php
namespace Auth\Form;

use Zend\Form\Form;

class AuthForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('auth');
        $this->setAttribute('method', 'post');
	$this->setAttribute('class', 'bs-example form-horizontal');

        $this->add(array(
            'name' => 'usr_name',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
                'type'  => 'Text',
            ),
            'options' => array(
                'label' => 'Логін',
            ),
        ));
        $this->add(array(
            'name' => 'usr_password',
            'attributes' => array(
                'type'  => 'Password',
            ),
            'options' => array(
                'label' => 'Пароль',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
		'type'  => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'rememberme',
            'type' => 'checkbox', // 'Zend\Form\Element\Checkbox',			
//            'attributes' => array( // Is not working this way
//                'type'  => '\Zend\Form\Element\Checkbox',
//            ),
            'options' => array(
                'label' => 'Запам\'яти?',
//		'checked_value' => 'true', without value here will be 1
//		'unchecked_value' => 'false', // witll be 1
            ),
        ));			
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
		'class' => 'btn btn-success btn-lg btn-block',
            ),
        )); 
    }
}