<?php

App::uses('UserAdminAppController', 'UserAdmin.Controller');
App::uses('Me', 'UserAdmin.Lib');


class UsersController extends UserAdminAppController {
	
	public $layout = 'default';
	
	public $uses = array('UserAdmin.Account', 'UserAdmin.Team', 'UserAdmin.Role');
	
	public $components = array('Paginator');
	
	public $scaffold;
	
	
	public function beforeFilter() {
	    if (isset($this->request->query['changeTeam'])) {
		    Me::selectTeam($this->request->query['changeTeam']);
		    $this->reloadRole();
		    return $this->redirect('/');
	    }
		parent::beforeFilter();
	}
	
	
	// Security
	
	private function reloadRole() {
	    $role = $this->Role->getForAccountAndTeam(Me::id(), Me::teamId());
	    if (!$role || empty($role)) {
		    Error::add(WBA('You don\'t have permissions to access this team'), Error::TypeError);
		    //return $this->redirect(array('controller' => 'users', 'action' => 'logout'));
	    }
	    Me::role($role);
	}
	
	public function checkSecurity() {
		if (!(bool)Me::id()) {
			if ($this->action != 'logout' && $this->action != 'login' && $this->action != 'register' && $this->action != 'forgot-password') {
				return $this->redirect(array('controller' => 'users', 'action' => 'logout'));
			}
		}
	}
	
	
	// Custom page methods
	
	public function index() {
		$this->set('title_for_layout', 'List users');
		
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
		
		$this->Paginator->settings = $this->Account->getAllWithRolesOptions();
		$account = $this->Paginator->paginate('Account', $where, array('lastname'));
		$this->set('accounts', $account);
	}
	
	public function logout() {
		Me::logout();
		AuthsomeComponent::logout();
		//Error::add('You have been successfully logged out', Error::TypeOk);
	    return $this->redirect(array('controller' => 'users', 'action' => 'login'));
	}
	
	public function login() {
		$this->set('title_for_layout', 'Login');
		
		$this->tryLoadOuterLayout();
		if ($this->request->is('post')) {
			$this->checkIfDefaultDataExists();
			$account = Authsome::login($this->data['Account']);
			if ($account) {
				$remember = (isset($this->data['Account']['remember']) && !empty($this->data['Account']['remember']));
				if ($remember) {
					Authsome::persist('2 weeks');
				}
	        	Me::reload($account);
	        	
	        	$this->reloadRole();
	        	
				if (Me::isDemoAccount()) {
					Error::add(__('You are logged in as a demo user, you won\'t be able to save or modify any data!'), Error::TypeInfo);
				}
	        	Error::add('You have been successfully logged in', Error::TypeOk);
	        	
	        	$teams = Me::teams();
				/*
				// Disable selector
	        	if (count($teams) > 1) {
		        	return $this->redirect(array('plugin' => null, 'controller' => 'teams', 'action' => 'selector'));
	        	}
	        	else
				*/
	        	if (count($teams) == 0) {
	                $this->Team->create();
					$data['Team']['name'] = $account['Account']['username'];
					$data['Team']['identifier'] = $account['Account']['username'];
					$team = $this->Team->save($data);
					
					$account['Team']['Team'][] = $team['Team']['id'];
					
					$this->Account->id = $account['Account']['id'];
					$this->Account->dontEncodePassword = true;
					$account = $this->Account->save($account);
					
					return $this->login();
					
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
	
	public function register() {
		$this->set('title_for_layout', 'Register');
		
		$this->tryLoadOuterLayout();
		if ($this->request->is('post')) {
            $this->Account->create();
            $this->request->data['Account']['lastlogin'] = '00-00-0000 00:00:00';
			
			$account = $this->Account->save($this->request->data);
            if ($account) {            	
                $this->Team->create();
				$data['Team']['name'] = $account['Account']['username'];
				$data['Team']['identifier'] = $account['Account']['username'];
				$team = $this->Team->save($data);
				
				$account['Team']['Team'][] = $team['Team']['id'];
				
				$this->Account->id = $account['Account']['id'];
				$this->Account->dontEncodePassword = true;
				$account = $this->Account->save($account);
				
				$role = $this->Role->createRole($account['Account']['id'], $team['Team']['id']);
            	
                Error::add('Registration has been finished successfully.', Error::TypeOk);
                $this->login();
            }
            else {
            	Error::add('The user could not be saved. Please, try again.', Error::TypeError);
            }
        }
   	}
	
	public function account() {
		$this->set('title_for_layout', 'My account');
		
		$account = $this->Account->find('first', Me::id());
		$this->set('account', $account);
		if (empty($this->request->data)) {
			$this->request->data = $account;
		}
		else {
			$this->Account->id = Me::id();
			unset($this->request->data['Account']['username']);
			if (empty($this->request->data['Account']['password']) && !empty($account)) {
				$this->request->data['Account']['password'] = $account['Account']['password'];
				$this->Account->dontEncodePassword = true;
			}
			$ok = $this->Account->save($this->request->data, true);
			if ($ok) {
				Error::add('Your details have been successfully saved.');
				$this->redirect(array('controller' => 'users', 'action' => 'account'));
			}
			else {
				Error::add('Unable to save your details. Please try again or contact system administrator.', Error::TypeError);
			}
		}
	}
	
	public function view() {
		
	}
	
	public function edit($accountId) {
		if ($this->request->is('post')) {
			
		}
		
		$roles = $this->Role->roles();
		$this->set('roles', $roles);
		
		$account = $this->Account->read(null, $accountId);
		$this->set('account', $account);
		
		$this->set('role', $this->Role->getForAccountAndTeam($accountId, Me::teamId()));
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
