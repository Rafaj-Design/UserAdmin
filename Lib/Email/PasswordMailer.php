<?php

App::uses('Mailer', 'UserAdmin.Lib/Email');
App::uses('Account', 'UserAdmin.Model');
App::uses('Error', 'Error.Lib');


class PasswordMailer extends Mailer {
	
	private $Account;
	private $Template;
	
	function __construct() {
		parent::__construct();
		if (!$this->Account) {
			$this->Account = new Account();
		}
	}
	
	public function sendInvite($email, $message) {
		$this->email->template('UserAdmin.invite', 'UserAdmin.default');
		
		$data = $this->Account->getAccountByEmail($email);
		if (empty($data)) {
			Error::add(WBA('User email hasn\'t been found.'), Error::TypeError);
			return false;
		}
		$data['registration_token'] = $this->Account->getPasswordToken($data['id']);
		$data['reg_url'] = Router::url('/users/finishreg', true);
		$this->setVars($data);
		
		$this->recipient = $data['email'];
		$this->subject = WBA('Invitation');
		
		$ok = $this->send();
		return $ok;
	}
		
	public function sendPasswordReset($email) {
		$this->email->template('UserAdmin.reset', 'UserAdmin.default');
		
		$data = $this->Account->getAccountByEmail($email);
		if (empty($data)) {
			Error::add('User email hasn\'t been found.', Error::TypeError);
			return false;
		}
		$data['password_token'] = $this->Account->getPasswordToken($data['id']);
		$data['newpasswd_url'] = Router::url('/users/newpasswd', true);
		$this->setVars($data);
		
		$this->recipient = $data['email'];
		$this->subject = WBA('Password reset');
		
		$ok = $this->send();
		return $ok;
	}
	
	public function sendRegistrationConfirmation($input) {
		$this->email->template('UserAdmin.confirm', 'UserAdmin.default');
		
		$data = $this->Account->getAccountByEmail($input['Account']['email']);
		if (empty($data)) {
			return false;
		}
		$data['password_token'] = $this->Account->getPasswordToken($data['id']);
		$data['login_url'] = Router::url('/', true);
		
		$this->setVars($data);
		
		$this->recipient = $data['email'];
		$this->subject = WBA('Registration confirmation');
		
		$ok = $this->send();
		return $ok;
	}
		
}
