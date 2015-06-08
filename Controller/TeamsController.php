<?php

App::uses('UserAdminAppController', 'UserAdmin.Controller');
App::uses('Me', 'UserAdmin.Lib');
App::uses('Team', 'UserAdmin.Model');
App::uses('Account', 'UserAdmin.Model');
App::uses('Role', 'UserAdmin.Model');


class TeamsController extends UserAdminAppController {
	
	public $layout = 'default';
	
	public $uses = array('UserAdmin.Team', 'UserAdmin.Account', 'UserAdmin.Role');
	
	public $components = array('Paginator', 'Session');
	
	
	// Private page helpers
	
	public function reloadMe() {
		$account = $this->Account->read(null, Me::id());
		$teamId = Me::teamId();
		Me::reload($account);
		Me::selectTeam($teamId);
	}
	
	// Public page methods
	
	public function index() {
		$this->Team->recursive = 0;
		$this->Paginator->settings = $this->Team->getAllOptions();
		$this->set('teams', $this->Paginator->paginate());
	}
	
	public function add() {
		$this->set('title_for_layout', WBA('Create new team'));
		
		if ($this->request->is('post')) {
			$this->Team->create();
			$this->request->data['Team']['identifier'] = htmlentities(strtolower($this->request->data['Team']['name']));
			$this->request->data['Team']['stripetoken'] = '';
			$this->request->data['Account']['Account'][] = Me::id();
			$team = $this->Team->save($this->request->data);
			if ($team) {
				$this->reloadMe();
				$this->Role->createRole(Me::id(), $team['Team']['id']);
				
				Error::add(WBA('The team has been saved.'));
				if (isset($this->request->data['apply'])) {
					return $this->redirect(array('action' => 'edit', $team['Team']['id'], $team['Team']['identifier']));
				}
				return $this->redirect('/users/?changeTeam='.$team['Team']['id']);
			}
			else {
				Error::add(WBA('The team could not be saved. Please, try again.'), Error::TypeError);
			}
		}
		$accounts = $this->Team->Account->find('list');
		$this->set(compact('accounts'));
	}
	
	public function edit($id = null) {
		if (!$this->Team->exists($id)) {
			throw new NotFoundException(WBA('Invalid team'));
		}
		
		$this->set('title_for_layout', WBA('Edit team'));
		
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Team']['identifier'] = htmlentities(strtolower($this->request->data['Team']['name']));
			$this->Team->id = $this->request->data['Team']['id'];
			$team = $this->Team->save($this->request->data);
			if ($team) {
				$this->reloadMe();
				Error::add(WBA('The team has been saved.'));
				if (isset($this->request->data['apply'])) {
					return $this->redirect(array('action' => 'edit', $team['Team']['id'], $team['Team']['identifier']));
				}
				return $this->redirect(array('action' => 'index'));
			}
			else {
				Error::add(WBA('The team could not be saved. Please, try again.'), Error::TypeError);
			}
		}
		else {
			$options = array('conditions' => array('Team.' . $this->Team->primaryKey => $id));
			$this->request->data = $this->Team->find('first', $options);
		}
		$accounts = $this->Team->Account->find('list');
		$this->set(compact('accounts'));
	}
	
	public function delete($id = null) {
		$this->Team->id = $id;
		if (!$this->Team->exists()) {
			throw new NotFoundException(WBA('Invalid team'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Team->delete()) {
			$this->reloadMe();
			Error::add(WBA('The team has been deleted.'));
		}
		else {
			Error::add(WBA('The team could not be deleted. Please, try again.'), Error::TypeError);
		}
		return $this->redirect(array('action' => 'index'));
	}
	
}
