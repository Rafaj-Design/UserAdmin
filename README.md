UserAdmin
=========

Needs https://github.com/felixge/cakephp-authsome to work
Please follow the Authsome instructions to install

Implementation:

1) In app/Config/bootstrap add:
	CakePlugin::load('UserAdmin', array('bootstrap' => false, 'routes' => true));
	
2) In app/Controller/AppController.php add:
	App::uses('Me', 'UserAdmin.Lib');
	
	
	public function beforeFilter() {
		$this->checkSecurity();
		
		parent::beforeFilter();
	}
	
	public function checkSecurity() {
		if (!(bool)Me::id()) {
			return $this->redirect(array('controller' => 'users', 'action' => 'logout'));
		}
	}
	
3) Link to user and team controllers like this:
	<a href="<?= $this->Html->url(array('controller' => 'users', 'action' => 'index', 'plugin' => null)); ?>">Users index</a>
