<?php

App::uses('UserAdminAppModel', 'UserAdmin.Model');


class Account extends UserAdminAppModel {

	public $validate = array(
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'firstname' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lastname' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
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
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
	
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
