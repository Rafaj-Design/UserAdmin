<?php

App::uses('AuthComponent', 'Controller/Component');
App::uses('AuthsomeComponent', 'Authsome.Controller/Component');
App::uses('AppModel', 'Model');
App::uses('Account', 'UserAdmin.Model');
App::uses('CakeSession', 'Model/Datasource');


class Me {
	
	protected static $componentCollection;
	protected static $session;
	protected static $account;
	protected static $didLoadTeams = false;
	
	
	public static function setSession($session) {
		//self::$session = $session;
	}
	
	protected static function checkComponentCollection() {
		if (!self::$componentCollection || !self::$session) {
			self::$componentCollection = new ComponentCollection();
			self::$session = new SessionComponent(self::$componentCollection);
		}
	}
	
	protected static function prepareSession() {
		if (!self::$session) {
			self::checkComponentCollection();
			if (!self::$session) {
				die('Session has not been created!');
			}
		}
	}
	
	public static function reload($data) {
		$user = new Account();
		//$data = $user->read(null, Me::id());
		if ($data) {
			unset($data['Account']['password']);
			unset($data['Account']['password_token']);
			
			self::prepareSession();
			self::$account = $data['Account'];
			self::$session->write('Auth.Account', self::$account);
			self::$session->write('Auth.Teams', $data['Team']);
		}
	}
	
	public static function teams() {
		self::prepareSession();
		return self::$session->read('Auth.Teams');
	}
	
	public static function overrideTeam($team) {
		self::prepareSession();
		$ret = self::$session->write('Auth.Team', $team);
		return $ret;
	}
	
	public static function selectTeam($teamId) {
		$teams = self::teams();
		if (empty($teams) && !self::$didLoadTeams) {
			self::$didLoadTeams = true;
			//self::reload();
		}
		if ($teamId > 0) foreach ($teams as $team) {
			if ($team['id'] == $teamId) {
				self::overrideTeam($team);
			}
		}
		$team = self::$session->read('Auth.Team');
		if (empty($team) && !empty($teams)) {
			self::overrideTeam($teams[0]);
		}
	}
	
	public static function team($value=null) {
		self::prepareSession();
		$team = self::$session->read('Auth.Team');
		if (empty($team)) {
			self::selectTeam(0);
		}
		if ($value) {
			return (isset($team[$value]) ? $team[$value] : false);
		}
		else return $team;
	}
	
	public static function teamId() {
		return 1;
		
		$team = self::team();
		return (int)$team['id'];
	}
	
	public static function gravatar($size) {
		return 'https://1.gravatar.com/avatar/'.md5(self::get('email')).'&r=x&s='.$size;
	}
	
	public static function id() {
		self::prepareSession();
		return (int)self::get('id');
	}
			
	public static function get($variable='id') {
		self::prepareSession();
		if (!self::$account) {
			self::$account = self::$session->read('Auth.Account');
		}
		return self::$account[$variable];
	}
	
	public static function logout() {
		self::prepareSession();
		self::$session->write('Auth.Account', null);
		self::$session->write('Auth.Teams', null);
		self::$session->write('Auth.Team', null);
	}
			
}