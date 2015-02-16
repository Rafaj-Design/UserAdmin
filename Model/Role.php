<?php

App::uses('UserAdminAppModel', 'UserAdmin.Model');


class Role extends UserAdminAppModel {
	
	
	// Public methods
	
	public function getForAccountAndTeam($accountId, $teamId) {
		$options = array();
		$options['fields'] = array('role');
		$options['conditions'] = array('Role.account_id' => (int)$accountId, 'Role.team_id' => (int)$teamId);
		$data = $this->find('first', $options);
		if (isset($data['Role']['role'])) {
			return $data['Role']['role'];
		}
		return $data;
	}
	
	public function createRole($accountId, $teamId, $role='admin') {
		$data = array();
		$data['Role']['account_id'] = (int)$accountId;
		$data['Role']['team_id'] = (int)$teamId;
		$data['Role']['role'] = $role;
		$data['Role']['expires'] = '0000-00-00 00:00:00';
		return $this->save($data);
	}
	
	public function roles() {
		$data = array();
		$data[] = array('role' => 'viewer', 'name' => 'Viewer');
		$data[] = array('role' => 'trans', 'name' => 'Translator');
		$data[] = array('role' => 'dev', 'name' => 'Developer');
		$data[] = array('role' => 'admin', 'name' => 'Admin');
		return $data;
	}
	
}