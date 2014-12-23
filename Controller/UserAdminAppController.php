<?php

App::uses('AppController', 'Controller');
App::uses('Me', 'UserAdmin.Lib');
App::uses('Account', 'UserAdmin.Model');


class UserAdminAppController extends AppController {
	
	public $components = array(
	    'Session',
	    'Authsome.Authsome' => array(
            'model' => 'UserAdmin.Account'
        ),
	    'Cookie'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		Me::setSession($this->Session);
	}
	
	public function tryLoadOuterLayout() {
		$path = APP.'View'.DS.'Layouts'.DS;
		if (file_exists($path.'outer.ctp')) {
			$this->layout = 'outer';
		}
	}

}
