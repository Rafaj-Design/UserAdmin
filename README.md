UserAdmin
=========

Needs: 
- https://github.com/felixge/cakephp-authsome
- https://github.com/Ridiculous-Innovations/Error

to work. Please follow the Authsome and Error plugings instructions to install

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

4) Shall you require to display login/registration pages in a different layout template, create layout called outer.ctp which will be used instead of the default one