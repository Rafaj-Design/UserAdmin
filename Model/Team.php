<?php

App::uses('UserAdminAppModel', 'UserAdmin.Model');


class Team extends UserAdminAppModel {

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'identifier' => array(
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
		'Account' => array(
			'className' => 'UserAdmin.Account',
			'joinTable' => 'teams_accounts',
			'foreignKey' => 'team_id',
			'associationForeignKey' => 'account_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
	
	public function createAdminTeam() {
		$data = array();
		$data['Team'] = array();
		$data['Team']['id'] = 1;
		$data['Team']['name'] = 'Admin Team';
		$data['Team']['identifier'] = 'admin';
		return $this->save($data, true);
	}
	
	public function adminTeam() {
		$options = array();
		$options['conditions'] = array('Team.id' => 1);
		$data = $this->find('first', $options);
		return $data;
	}
	
	public function countAll() {
		return (int)$this->find('count');
	}

}
