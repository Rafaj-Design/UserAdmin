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
		    $this->Role->setLastLogin(Me::id());
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
	        	$this->Role->setLastLogin($account['Account']['id']);
	        	
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
				return $this->redirect(array('controller' => 'users', 'action' => 'account'));
			}
			else {
				Error::add('Unable to save your details. Please try again or contact system administrator.', Error::TypeError);
			}
		}
	}
	
	public function view() {
		
	}
	
	public function edit($accountId) {
		if (isset($this->request->data['id'])) {
			if ($this->request->is('post') && ($this->request->data['id'] != Me::id())) {
				$this->Role->updateRole($this->request->data['role'], $accountId);
			}
		}
		
		$roles = $this->Role->roles();
		$this->set('roles', $roles);
		
		$account = $this->Account->read(null, $accountId);
		$this->set('account', $account);
		
		if ($account['Account']['id'] == Me::id()) {
			Error::add(WBA('You can not change your own permissions'), Error::TypeError);
			return $this->redirect(array('action' => 'index'));
		}
		
		$this->set('role', $this->Role->getForAccountAndTeam($accountId, Me::teamId()));
	}
	
	public function delete() {
		
	}
	
	public function invite($id=false) {
		$this->set('title_for_layout', 'Manage users');
		
		if (Me::minAdmin()) {
			$id = (int)$id;
			if ($id) {
				$this->Role->saveUserRole($id, 'view', '0000-00-00 00:00:00');
				$teamId = Me::teamId();
				$this->Account->query("INSERT INTO `teams_accounts` (`team_id`, `account_id`) VALUES ($teamId, $id);");
				Error::add(WBA('User has been linked to this account successfully.'), Error::TypeOk);
				return $this->redirect('/users/invite/?q='.$this->request->query['q']);
			}
			else if (isset($this->request->data['Account']['email'])) {
				if (empty($this->request->data['Account']['email']) || empty($this->request->data['Account']['email']) || empty($this->request->data['Account']['email'])) {
					Error::add(WBA('All the fields are mandatory, please check the values and try again.'), Error::TypeError);
				}
				else {
					$id = 0;
					$ok = false;
					$creating = true;
					$account = $this->Account->getAccountByEmail($this->request->data['Account']['email']);
					if (!empty($account) && isset($account['id'])) {
						$id = $account['id'];
						$ok = true;
						$creating = false;
					}
					else {
				    	$account = $this->Account->saveInvitation($this->request->data);
				    	if (isset($account['Account']['id'])) {
					    	$id = $account['Account']['id'];
							$ok = true;
						}
					}
					if ($id && $ok) {
						if (!$creating) {
							Error::add(WBA('User with this email address is already member of this team.'), Error::TypeWarning);
							Error::add(WBA('If the user is unable to access their account please tell them to reset their password.'), Error::TypeInfo);
						}
						else {
							$this->Role->saveUserRole($id, 'view', '0000-00-00 00:00:00');
							$teamId = Me::teamId();
							$this->Account->query("INSERT INTO `teams_accounts` (`team_id`, `account_id`) VALUES ($teamId, $id);");
							
					    	$mailer = new PasswordMailer();
					    	if ($mailer->sendInvite($this->request->data['Account']['email'], null)) {
						    	Error::add(WBA('Email with instructions has been sent to the user.'), Error::TypeOk);
					    	}
					    	return $this->redirect('/users/invite/');
						}
					}
					else {
						Error::add(WBA('Unable to finish the registration, something went wrong.'), Error::TypeError);
					}
				}
			}
		}

	}
	
	public function unlink($id, $username=null, $redirectOverride=false) {
    	if (!Me::minAdmin() || !$this->Account->verifiedAccountInMyTeam($id) || $id == Me::id()) {
    		if ($id == Me::id()) {
	    		Error::add('It would not be very wise to unlink yourself from this account!', Error::TypeWarning);
    		}
			else {
				Error::add('User can not be deleted.', Error::TypeError);
			}
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		if ($this->Account->unlinkUser($id)) {
			Error::add('User has been unlinked from this account.');
		}
		else {
			Error::add('Unable to unlink user.', Error::TypeError);
		}
		return $this->redirect(($redirectOverride ? $redirectOverride : array('action' => 'index')));
	}
	
	public function remove($id=false, $username=null) {
		$id = (int)$id;
		return $this->unlink($id, $username, '/users/invite/?q='.$this->request->query['q']);
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
