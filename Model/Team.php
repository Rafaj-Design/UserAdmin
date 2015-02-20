<?php

App::uses('UserAdminAppModel', 'UserAdmin.Model');


class Team extends UserAdminAppModel {

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Name of the team can not be empty',
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
	
	public function getAllOptions() {
		$options = array();
		$options['fields'] = array('*');
		$options['joins'] = array(
		    array('table' => 'teams_accounts',
		        'alias' => 'AccountsJoin',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'Team.id = AccountsJoin.team_id',
		        )
		    ),
		);
		$options['conditions'] = array('AccountsJoin.account_id' => Me::id());
		$options['order'] = array('Team.name' => 'ASC');
		return $options;
	}
	
	public function getAll() {
		$options = getAllOptions();
		$data = $this->find('all', $options);
		return $data;
	}
	
	public function getOne($teamId) {
		$data = $this->read(null, (int)$teamId);
		return $data;
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

	public function deleteAccountInTeam($accountId, $teamId) {
		/*
	    $conditions = array();
	    $conditions['Team.account_id'] = (int)$accountId;
	    $conditions['Team.team_id'] = (int)$teamId;
	    $this->deleteAll($conditions, false);
		*/
		$accountId = (int)$accountId;
		$teamId = (int)$teamId;
		$query = "DELETE `Team` FROM `teams_accounts` AS `Team` WHERE `Team`.`account_id` = $accountId AND `Team`.`team_id` = $teamId;";
		return $this->query($query);
    }
    
}
