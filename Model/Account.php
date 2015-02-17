<?php

App::uses('UserAdminAppModel', 'UserAdmin.Model');


class Account extends UserAdminAppModel {
	
	public $dontEncodePassword = false;
	
	public $displayField = 'fullname';
	
	public $virtualFields = array(
	    'fullname' => 'CONCAT(Account.lastname, ", ", Account.firstname)'
	);
	
	
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
		    )
        ),
        'password' => array(
            'required' => array(
                'rule'    => array('minLength', '8'),
				'message' => 'Minimum 8 characters long',
            ),
        )
    );

	public $hasMany = array('UserAdmin.LoginToken', 'UserAdmin.Role');

	public $hasAndBelongsToMany = array(
		'Team' => array(
			'className' => 'UserAdmin.Team',
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
	
	
	// Before save
	
    public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password']) && !$this->dontEncodePassword) {
	        $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], 'sha1', true);
	    }
	    return true;
	}
	
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
			case 'cookie':
				Error::add('Cookie login!', Error::TypeInfo);
				list($token, $accountId) = split(':', $credentials['token']);
				$duration = $credentials['duration'];

				$loginToken = $this->LoginToken->find('first', array(
					'conditions' => array(
						'account_id' => $accountId,
						'token' => $token,
						'duration' => $duration,
						'used' => false,
						'expires <=' => date('Y-m-d H:i:s', strtotime($duration)),
					),
					'contain' => false
				));

				if (!$loginToken) {
					return false;
				}

				$loginToken['LoginToken']['used'] = true;
				$this->LoginToken->save($loginToken);

				$conditions = array(
					'Account.id' => $loginToken['LoginToken']['account_id']
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
    
	public function identicalFieldValues($field=array(), $compare_field=null) { 
        foreach ($field as $key => $value) { 
            $v1 = $value; 
            $v2 = $this->data[$this->name][$compare_field];                  
            if ($v1 !== $v2) { 
                return false; 
            }
            else { 
                continue; 
            } 
        } 
        return true; 
    }
    
	// Custom methods
	
	public function getAllWithRolesOptions() {
		$options = array();
		$options['fields'] = array('*');
		$options['joins'] = array(
		    array('table' => 'roles',
		        'alias' => 'Role',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'Account.id = Role.account_id',
		        )
		    ),
		);
		$options['conditions'] = array('Role.team_id' => Me::teamId());
		$options['order'] = array('Account.lastname' => 'ASC');
		return $options;
	}
	
	/*
	public function getOneWithRolesOptions($accountId) {
		$options = array();
		$options['fields'] = array('*');
		$options['joins'] = array(
		    array('table' => 'roles',
		        'alias' => 'Role',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'Account.id' => 'Role.account_id',
		        )
		    ),
		);
		//$options['conditions'] = array('Role.account_id' => (int)$accountId, 'Role.team_id' => (int)Me::teamId());
		$data = $this->find('first', $options);
		debug($data);
		die();
		return $data;
	}
	//*/
	
	public function verifiedAccountInMyTeam($accountId) {
		$options = array();
		$options['fields'] = array('*');
		$options['joins'] = array(
		    array('table' => 'teams_accounts',
		        'alias' => 'TeamsJoin',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'Account.id = TeamsJoin.account_id',
		        )
		    ),
		);
		$options['conditions'] = array('Account.id' => (int)$accountId);
		$data = $this->find('first', $options);
		if (isset($data['Team'])) foreach ($data['Team'] as $team) {
			if ($team['id'] == Me::teamId()) {
				return $data;
			}
		}
        return false;
	}
	
	public function getOne($accountId) {
		$data = $this->read(null, (int)$accountId);;
        if (!$data) return false;
        unset($data['Account']['password']);	
        unset($data['Account']['password_token']);
        if (isset($data['Account'])) $data['Account']['gravatar_url'] = 'https://www.gravatar.com/avatar/'.md5($data['Account']['email']).'.jpg';
        return $data;
	}
	
	/*
	public function getOne($accountId) {
		$data = $this->verifiedAccountInMyTeam($accountId);
        if (!$data) return false;
        unset($data['Account']['password']);	
        unset($data['Account']['password_token']);
        if (isset($data['Account'])) $data['Account']['gravatar_url'] = 'https://www.gravatar.com/avatar/'.md5($data['Account']['email']).'.jpg';
        return $data;
	}
	//*/
	
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
	
	public function authsomePersist($user, $duration) {
		$token = md5(uniqid(mt_rand(), true));
		$accountId = $user['Account']['id'];
		
		$this->LoginToken->create(array(
			'account_id' => $accountId,
			'token' => $token,
			'duration' => $duration,
			'expires' => date('Y-m-d H:i:s', strtotime($duration)),
		));
		$this->LoginToken->save();

		return "${token}:${accountId}";
	}
	
	private function addGravatars($data) {
		foreach ($data as $key=>$account) {
			$data[$key]['Account']['gravatar_url'] = 'https://www.gravatar.com/avatar/'.md5($account['Account']['email']).'.jpg';
		}
		return $data;
	}
	
	public function isUsername($username) {
		return (bool)$this->find('count', array('conditions' => array('Account.username' => $username)));
	}
	
	public function isEmail($email) {
		return (bool)$this->find('count', array('conditions' => array('Account.email' => $email)));
	}
	
    public function getAccountByEmail($email) {
	    $options = array();
		$options['conditions'] = array('Account.email' => $email);
		$options['limit'] = 1;
		$data = $this->find('all', $options);
		$data = $this->addGravatars($data);
		if (count($data) > 0) {
			return $data[0]['Account'];
		}
		return false;
    }
    
	public function searchForNickname($nickname) {
		$this->unbindModel(array('hasAndBelongsToMany' => array('Group', 'Teams')));
		
		$options = array();
		$options['fields'] = array('id', 'username', 'email', 'firstname', 'lastname');
		$options['conditions'] = array('username LIKE \'%'.$nickname.'%\'', 'enabled' => 1);
		$options['limit'] = 50;
		$data = $this->find('all', $options);
		
		foreach ($data as $key=>$account) {
			$data[$key]['Account']['gravatar_url'] = 'https://www.gravatar.com/avatar/'.md5($account['Account']['email']).'.jpg';
			$member = false;
			if (isset($account['Role']) && !empty($account['Role'])) {
				foreach ($account['Role'] as $role) {
					if ($role['team_id'] == Me::teamId()) {
						$member = true;
					}
				}
			}
			$data[$key]['Account']['member'] = $member;
			if (!empty($data[$key]['Account']['lastname'])) {
				$data[$key]['Account']['lastname'] = ucfirst(substr($data[$key]['Account']['lastname'], 0, 1).'*****');
			}
			else {
				$data[$key]['Account']['lastname'] = '';
			}
			unset($data[$key]['Account']['email']);
		}
		
		return $data;
	}
	
	public function unlinkUser($accountId) {
		if (!Me::minAdmin()) return false;
		$user = $this->getOne($accountId);
		if ($user['Account']['id'] != Me::id()) {
			$this->Role->deleteAccountInTeam($accountId, Me::teamId());
			$this->Team->deleteAccountInTeam($accountId, Me::teamId());
			return true;
		}
		return false;
	}
	
	public function saveInvitation($data) {
		$this->validator()->remove('username');
		$this->validator()->remove('password');
		$this->validator()->remove('password2');
		
		$data = array('Account' => $data['Account']);
		$data['Account']['username'] = '';
		$data['Account']['password'] = '';
		$data['Account']['lastlogin'] = '0000-00-00 00:00:00';
		
		$this->create();
		return $this->save($data);
	}
	
	private function GUID() {
		if (function_exists('com_create_guid') === true) {
			return trim(com_create_guid(), '{}');
		}
		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	public function getPasswordToken($accountId) {
		$this->id = (int)$accountId;
		$token = $this->GUID();
		$ok = $this->saveField('password_token', $token);
		if ($ok) return $token;
		else return false;
	}
	
    public function getAccountByPasswordToken($token) {
	    $options = array();
		$options['conditions'] = array('Account.password_token' => $token);
		$data = $this->find('all', $options);
		if (count($data) > 0) {
			return $data[0]['Account'];
		}
		return false;
    }
    
	public function isTokenValid($token) {
		$user = $this->getAccountByPasswordToken($token);
		if (!empty($user)) {
			if (strtotime($user['modified']) < (time() - (24 * 60 * 60))) return false;
			else return (int)$user['id'];
		}
		else return false;
	}
	
	public function updatePasswords($data) {
		$this->validator()->remove('firstname');
		$this->validator()->remove('lastname');
		$data['Account']['password_token'] = '';
		$data['Account']['enabled'] = 1;
		return $this->save($data, true);
	}
	
}
