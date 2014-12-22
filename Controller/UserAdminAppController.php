<?php

App::uses('AppController', 'Controller');
App::uses('Me', 'UserAdmin.Lib');


class UserAdminAppController extends AppController {
	
		public $components = array(
	    'Session',
	    'Auth' => array(
	        'loginRedirect' => array('controller' => 'pages', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
	        'authorize' => array('Controller'),
	    ),
	    'Cookie'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		Me::setSession($this->Session);
	}

}
