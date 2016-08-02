<?php
namespace Auth\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;  
    }

    public function getUser($usr_id)
    {
        $usr_id  = (int) $usr_id;
        $rowset = $this->tableGateway->select(array('usr_id' => $usr_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getUserByEmail($usr_email)
    {
        $rowset = $this->tableGateway->select(array('usr_email' => $usr_email));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $usr_email");
        }
        return $row;
    }
	
    public function saveUser(Auth $auth)
    {
		// for Zend\Db\TableGateway\TableGateway we need the data in array not object
        $data = array(
            'usr_firstname'             => $auth->usr_firstname,
            'usr_secondname'            => $auth->usr_secondname,
            'usr_email'                 => $auth->usr_email,
            'usr_phone'                 => $auth->usr_phone,
            'usr_name'                  => $auth->usr_name,
            'usr_password'  		=> $auth->usr_password, 
            'usrl_id'                   => $auth->usrl_id,
            'usr_active'                => $auth->usr_active,
            'usr_password_salt' 	=> $auth->usr_password_salt,
            'usr_registration_date'     => $auth->usr_registration_date,
            'usr_ip'                    => $auth->usr_ip,
           
        );
		// If there is a method getArrayCopy() defined in Auth you can simply call it.
		// $data = $auth->getArrayCopy();

        $usr_id = (int)$auth->usr_id;
        if ($usr_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($usr_id)) {
                $this->tableGateway->update($data, array('usr_id' => $usr_id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
	
    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('usr_id' => $usr_id));
    }	
}