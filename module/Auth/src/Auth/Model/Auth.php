<?php
namespace Auth\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
// the object will be hydrated by Zend\Db\TableGateway\TableGateway
class Auth implements InputFilterAwareInterface
{
    public $usr_id;
    public $usr_firstname;
    public $usr_secondname;
    public $usr_email;	
    public $usr_phone;	
    public $usr_name;
    public $usr_password;
    public $usrl_id;		
    public $usr_active;	
    public $usr_password_salt;
    public $usr_registration_date;
    public $usr_ip;
    	

	// Hydration
	// ArrayObject, or at least implement exchangeArray. For Zend\Db\ResultSet\ResultSet to work
    public function exchangeArray($data) 
    {
        $this->usr_id=(!empty($data['usr_id'])) ? $data['usr_id'] : null;
        $this->usr_firstname = (!empty($data['usr_firstname'])) ? $data['usr_firstname'] : null;
        $this->usr_secondname = (!empty($data['usr_secondname'])) ? $data['usr_secondname'] : null;
        $this->usr_email = (!empty($data['usr_email'])) ? $data['usr_email'] : null;
        $this->usr_phone = (!empty($data['usr_phone'])) ? $data['usr_phone'] : null;
        $this->usr_name = (!empty($data['usr_name'])) ? $data['usr_name'] : null;
        $this->usr_password = (!empty($data['usr_password'])) ? $data['usr_password'] : null;
        $this->usrl_id = (!empty($data['usrl_id'])) ? $data['usrl_id'] : null;
        $this->usr_active = (isset($data['usr_active'])) ? $data['usr_active'] : null;
        $this->usr_password_salt = (!empty($data['usr_password_salt'])) ? $data['usr_password_salt'] : null;
        $this->usr_registration_date = (!empty($data['usr_registration_date'])) ? $data['usr_registration_date'] : null;
        $this->usr_ip=(!empty($data['usr_ip'])) ? $data['usr_ip'] : null;
        
    }	

	// Extraction. The Registration from the tutorial works even without it.
	// The standard Hydrator of the Form expects getArrayCopy to be able to bind
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	
	protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
	
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'usr_name',
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
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'usr_password',
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
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }	
}