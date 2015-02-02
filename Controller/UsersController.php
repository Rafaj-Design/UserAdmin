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
		$this->set('accounts', $this->Paginator->paginate('Account', $where, array('lastname')));
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
	
	public function register() {
		$this->set('title_for_layout', 'Register');
		
		$this->tryLoadOuterLayout();
		if ($this->request->is('post')) {
            $this->Account->create();
            $this->request->data['Account']['lastlogin'] = '00-00-0000 00:00:00';
    		$this->request->data['Team']['Team'][] = 1;

            if ($this->Account->save($this->request->data)) {
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
			//$username = $this->request->data['Account']['username'];
			unset($this->request->data['Account']['username']);
			if (empty($this->request->data['Account']['password']) && !empty($account)) {
				$this->request->data['Account']['password'] = $account['Account']['password'];
				$this->request->data['Account']['password2'] = $account['Account']['password'];
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
