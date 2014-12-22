<?php

App::uses('UserAdminAppController', 'UserAdmin.Controller');
App::uses('Me', 'UserAdmin.Lib');
App::uses('Account', 'UserAdmin.Model');
App::uses('Team', 'UserAdmin.Model');


class UsersController extends UserAdminAppController {
	
	var $uses = array('UserAdmin.Team', 'UserAdmin.Account');
	
	public $scaffold;
	
	
	// Custom page methods
	
	public function logout() {
		Me::logout();
		$this->Cookie->write('remember_me_cookie',  null);
	    return $this->redirect(array('controller' => 'users', 'action' => 'login'));
	}
	
	public function login() {
		if ($this->request->is('post')) {
			$this->checkIfDefaultDataExists();
			
			return $this->redirect(array('plugin' => null, 'controller' => 'pages', 'action' => 'home'));
		}
	}
	
	public function account() {
		
	}
	
	// Private methods
	
	private function checkIfDefaultDataExists() {
		if (!$this->Team->adminTeam()) {
			if (!$this->Team->createAdminTeam()) {
				// TODO: handle error
			}
		}
		if (!$this->Account->adminAccount()) {
			if (!$this->Account->createAdminAccount()) {
				// TODO: handle error
			}
		}
	}
	

}
