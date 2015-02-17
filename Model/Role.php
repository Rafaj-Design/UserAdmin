<?php

App::uses('UserAdminAppModel', 'UserAdmin.Model');


class Role extends UserAdminAppModel {
	
	
	// Public methods
	
	public function getForAccountAndTeam($accountId, $teamId) {
		$data = $this->getFullForAccountAndTeam($accountId, $teamId);
		if (isset($data['Role']['role'])) {
			return $data['Role']['role'];
		}
		return null;
	}
	
	public function getFullForAccountAndTeam($accountId, $teamId) {
		$options = array();
		$options['conditions'] = array('Role.account_id' => (int)$accountId, 'Role.team_id' => (int)$teamId);
		$data = $this->find('first', $options);
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
		$data[] = array('role' => 'view', 'name' => 'Viewer');
		$data[] = array('role' => 'trans', 'name' => 'Translator');
		$data[] = array('role' => 'dev', 'name' => 'Developer');
		$data[] = array('role' => 'admin', 'name' => 'Admin');
		return $data;
	}
	
	public function checkRole($role) {
		$data = array();
		$data['view'] = 1;
		$data['trans'] = 1;
		$data['dev'] = 1;
		$data['admin'] = 1;
		if (isset($data[$role])) {
			return $role;
		}
		else {
			return false;
		}
	}
	
	public function saveUserRole($accountId, $role='view', $expires=false) {
		if (!Me::minAdmin()) return false;
		$r = $this->getFullForAccountAndTeam($accountId, Me::teamId());
		$role = $this->checkRole($role);
		if (!$r || empty($r)) {
			$this->create();
			$this->set('team_id', Me::teamId());
			$this->set('account_id', (int)$accountId);
			$this->set('role', $role);
			$this->set('lastip', '');
			$this->set('lastlogin', '0000-00-00 00:00:00');
			$this->set('expires', ($expires ? $expires : '0000-00-00 00:00:00'));
			return (bool)$this->save();
		}
		else {
			$fields = array();
			$expires = ($expires ? $expires : '0000-00-00 00:00:00');
			$fields['Role.role'] = "'$role'";
			$fields['Role.expires'] = "'$expires'";
			$conditions = array();
			$conditions['Role.team_id'] = Me::teamId();
			$conditions['Role.account_id'] = (int)$accountId;
			return (bool)$this->updateAll($fields, $conditions);
		}
	}
	
	public function updateRole($role, $accountId, $teamId=null) {
		if (!$teamId) {
			$teamId = Me::teamId();
		}
		$role = $this->checkRole(strtolower($role));
		if (!$role) {
			return false;
		}
		$fields = array('role' => "'$role'");
		$conditions = array('account_id' => (int)$accountId, 'team_id' => (int)$teamId);
		
		return $this->updateAll($fields, $conditions);
	}
	
	public function setLastLogin($accountId, $teamId=null) {
		if (!$teamId) {
			$teamId = Me::teamId();
		}
		$date = date('Y-m-d H:i:s');
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$fields = array('lastlogin' => "'$date'", 'lastip' => "'$ip'");
		$conditions = array('account_id' => (int)$accountId, 'team_id' => (int)$teamId);
		return $this->updateAll($fields, $conditions);
	}
	
	public function deleteAccountInTeam($accountId, $teamId) {
	    $conditions = array();
	    $conditions['Role.account_id'] = (int)$accountId;
	    $conditions['Role.team_id'] = (int)$teamId;
	    return $this->deleteAll($conditions, false);
    }
	
}