<?php

App::uses('UserAdminAppModel', 'UserAdmin.Model');


class Account extends UserAdminAppModel {

	public $validate = array(
		'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            ),
            'name' => array(
	            'rule'    => array('minLength', '4'),
	            'allowEmpty' => false,
	            'message' => 'Username needs to have at least 4 characters'
	        ),
	        'between' => array(
                'rule'    => array('between', 4, 40),
                'message' => 'Username needs to be between 4 to 40 characters'
            ),
            'unique' => array(
		        'rule' => 'isUnique',
		        'message' => 'Username is already registered'
		    ),
		    'verifyEmailFormat' => array(
				'rule' => array('verifyEmailFormat'), 
				'message' => 'For security reasons, email should not be used as username' 
			)
    
        ),
		'firstname' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Firstname is required'
            ),
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Alphabets and numbers only'
            ),
            'between' => array(
                'rule'    => array('between', 2, 40),
                'message' => 'First name needs to be between 2 to 40 characters'
            )
        ),
        'lastname' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Lastname is required'
            ),
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Alphabets and numbers only'
            ),
            'between' => array(
                'rule'    => array('between', 2, 40),
                'message' => 'Last name needs to be between 2 to 40 characters'
            )
        ),
		'email' => array(
			'required' => array(
                'rule'    => array('email'),
				'message' => 'Please supply a valid email address',
            ),
            'unique' => array(
		        'rule' => 'isUnique',
		        'message' => 'Email is already registered'
		    ),
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $hasAndBelongsToMany = array(
		'Team' => array(
			'className' => 'Team',
			'joinTable' => 'teams_accounts',
			'foreignKey' => 'account_id',
			'associationForeignKey' => 'team_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => 'name',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
	
	// Authentication
	
	public function authsomeLogin($type, $credentials = array()) {
        switch ($type) {
            case 'guest':
                return array();
            case 'credentials':
                $password = Authsome::hash($credentials['password']);

                // This is the logic for validating the login
                $conditions = array(
                    'Account.email' => $credentials['email'],
                    'Account.password' => $password,
                );
                break;
            default:
                return null;
        }

        return $this->find('first', compact('conditions'));
    }
	
	// Validation methods
	
    public function verifyEmailFormat($field=array()) {
    	$ok = !(bool)filter_var($field['username'], FILTER_VALIDATE_EMAIL);
    	return $ok;
    }
    
    // Handling methods
	
    public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	    }
	    return true;
	}
	
	// Custom methods
	
	public function verifiedAccountInMyTeam($userId) {
		$options = array();
		$options['fields'] = array('*');
		$options['joins'] = array(
		    array('table' => 'teams_accounts',
		        'alias' => 'TeamsJoin',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'User.id = TeamsJoin.account_id',
		        )
		    ),
		);
		$options['conditions'] = array('Account.id' => (int)$userId);
		$data = $this->find('first', $options);
		if (isset($data['Teams'])) foreach ($data['Teams'] as $team) {
			if ($team['id'] == Me::teamId()) {
				return $data;
			}
		}
        return false;
	}
	
	public function getOne($userId) {
		$data = $this->verifiedAccountInMyTeam($userId);
        if (!$data) return false;
        unset($data['Account']['password']);	
        unset($data['Account']['password_token']);
        if (isset($data['Account'])) $data['Account']['gravatar_url'] = 'https://www.gravatar.com/avatar/'.md5($data['Account']['email']).'.jpg';
        return $data;
	}
	
	public function createAdminAccount() {
		$data = array();
		$data['Account'] = array();
		$data['Account']['id'] = 1;
		$data['Account']['username'] = 'admin';
		$data['Account']['firstname'] = 'Super';
		$data['Account']['lastname'] = 'Admin';
		$data['Account']['email'] = 'admin@example.com';
		$data['Account']['password'] = 'password123';
		$db = $this->getDataSource();
		$data['Account']['lastlogin'] = $db->expression('NOW()');
		$data['Team'] = array();
		$data['Team']['Team'] = array();
		$data['Team']['Team'][] = 1;
		return $this->save($data, true);
	}
	
	public function adminAccount() {
		$options = array();
		$options['conditions'] = array('Account.id' => 1);
		$data = $this->find('first', $options);
		return $data;
	}
	
}
