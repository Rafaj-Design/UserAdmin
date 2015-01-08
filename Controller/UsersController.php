<?php

App::uses('UserAdminAppController', 'UserAdmin.Controller');
App::uses('Me', 'UserAdmin.Lib');


class UsersController extends UserAdminAppController {
	
	public $layout = 'default';
	
	public $uses = array('UserAdmin.Account', 'UserAdmin.Team');
	
	public $components = array('Paginator');
	
	public $scaffold;
	
	
	public function beforeFilter() {
		parent::beforeFilter();		
	}
	
	// Security
	
	public function checkSecurity() {
		if (!(bool)Me::id()) {
			if ($this->action != 'logout' && $this->action != 'login') {
				return $this->redirect(array('controller' => 'users', 'action' => 'logout'));
			}
		}
	}

	
	// Custom page methods
	
	public function index() {
		$this->Paginator->settings = array(
			'limit' => 10,
			'url' => array('plugin' => null),
		);
		//$this->paginator->options(array('url' => array('controller' => 'users', 'action' => 'userlist')));
		$this->Account->recursive = 0;
		
		$search = $this->request->query('search');
		$this->set('search', $search);
		if ($search) {
			$where = array(
				'OR' => array(
			        'Account.lastname LIKE' => "%$search%",
			        'Account.firstname LIKE' => "%$search%"
			    )
		    );
		}
		else {
			$where = array();
		}
		$this->set('accounts', $this->Paginator->paginate('Account', $where, array('lastname')));
	}
	
	public function logout() {
		Me::logout();
		AuthsomeComponent::logout();
		//Error::add('You have been successfully logged out', Error::TypeOk);
	    return $this->redirect(array('controller' => 'users', 'action' => 'login'));
	}
	
	public function login() {
		$this->tryLoadOuterLayout();
		if ($this->request->is('post')) {
			$this->checkIfDefaultDataExists();
			$account = Authsome::login($this->data['Account']);
			if ($account) {
	        	Me::reload($account);
	        	Error::add('You have been successfully logged in', Error::TypeOk);
	        	
	        	$teams = Me::teams();
	        	if (count($teams) > 1) {
	        		
		        	return $this->redirect(array('plugin' => null, 'controller' => 'teams', 'action' => 'selector'));
	        	}
	        	elseif (count($teams) == 0) {
		        	Error::add('There is no team?! Mate, what did you do this time?!!!!', Error::TypeError);
	        	}
	        	else {
	        		Me::selectTeam($teams[0]['id']);
		        	return $this->redirect(array('plugin' => null, 'controller' => 'pages', 'action' => 'home'));
	        	}
	        }
	        else {
	        	Error::add('Unable to login. Please check your login details and try again!', Error::TypeError);
		        $this->logout();
	        }
		}
	}
	
	public function account() {
		
	}
	
	public function view() {
		
	}
	
	public function edit() {
		
	}
	
	public function delete() {
		
	}
	
	// Private methods
	
	private function checkIfDefaultDataExists() {
		if (!$this->Team->find('first', 1)) {
			if (!$this->Team->createAdminTeam()) {
				// TODO: handle error
			}
		}
		if (!$this->Account->find('first', 1)) {
			if (!$this->Account->createAdminAccount()) {
				// TODO: handle error
			}
		}
	}
	

}
