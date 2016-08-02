<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Auth\Model\Auth;
use Auth\Form\RegistrationForm;
use Auth\Form\RegistrationFilter;

use Zend\Stdlib\ParametersInterface;

class RegistrationController extends AbstractActionController
{
    protected $usersTable;
    
    public function indexAction()
    {
        $form = new RegistrationForm();
        $form->get('submit')->setValue('Register now');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
			$form->setData($request->getPost());
			 if ($form->isValid()) {			 
				$data = $form->getData();
				$data = $this->prepareData($data);
				$auth = new Auth();
				$auth->exchangeArray($data);

				$this->getUsersTable()->saveUser($auth);
				
				return $this->redirect()->toRoute('auth/default', array('controller'=>'login', 'action'=>'index'));					
			}			 
		}
		return new ViewModel(array('form' => $form));
    }
    
    public function prepareData($data)
    {
	$data['usr_active'] = 1;
	$data['usr_password_salt'] = $this->generateDynamicSalt();				
	$data['usr_password'] = $this->encriptPassword(
            $this->getStaticSalt(), 
            $data['usr_password'], 
            $data['usr_password_salt']
	);
	$data['usrl_id'] = 2;
	$date = new \DateTime();
	$data['usr_registration_date'] = $date->format('Y-m-d H:i:s');
        $data['usr_ip'] = $this->getIp();
	return $data;
    }
    
    public function generateDynamicSalt()
    {
	$dynamicSalt = '';
	for ($i = 0; $i < 50; $i++) {
            $dynamicSalt .= chr(rand(33, 126));
	}
        return $dynamicSalt;
    }
	
    public function getStaticSalt()
    {
	$staticSalt = '';
	$config = $this->getServiceLocator()->get('Config');
	$staticSalt = $config['static_salt'];		
        return $staticSalt;
    }

    public function encriptPassword($staticSalt, $password, $dynamicSalt)
    {
	return $password = md5($staticSalt . $password . $dynamicSalt);
    }

    public function getIp()
    {
        $request = $this->getRequest();
        $servParam = $request->getServer();
        $remoteAddr = $servParam->get('REMOTE_ADDR');
        return $remoteAddr;
    }

    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('Auth\Model\UsersTable');
        }
        return $this->usersTable;
    }    
}

