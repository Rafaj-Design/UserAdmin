<?php

App::uses('UserAdminAppController', 'UserAdmin.Controller');
App::uses('Me', 'UserAdmin.Lib');
App::uses('Account', 'UserAdmin.Model');
App::uses('Team', 'UserAdmin.Model');


class UsersController extends UserAdminAppController {
	
	var $uses = array('UserAdmin.Account', 'UserAdmin.Team');
	
	public $scaffold;
	
	
	public function beforeFilter() {
		parent::beforeFilter();		
	}
	
	// Custom page methods
	
	public function logout() {
		Me::logout();
		AuthsomeComponent::logout();
		Error::add('You have been successfully logged out', Error::TypeOk);
	    return $this->redirect(array('controller' => 'users', 'action' => 'login'));
	}
	
	public function login() {
		if ($this->request->is('post')) {
			$this->checkIfDefaultDataExists();
			$account = Authsome::login($this->data['Account']);
			if ($account) {
	        	Me::reload();
	        	Error::add('You have been successfully logged in', Error::TypeOk);
	        	Error::add('Your id is: '.Me::id(), Error::TypeOk);
	        	return $this->redirect(array('plugin' => null, 'controller' => 'pages', 'action' => 'home'));
	        }
	        else {
	        	Error::add('Unable to login. Please check your login details and try again!', Error::TypeError);
		        $this->logout();
	        }
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
