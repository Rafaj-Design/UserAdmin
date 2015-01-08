<?php
App::uses('Team', 'UserAdmin.Model');

/**
 * Team Test Case
 *
 */
class TeamTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_admin.team',
		'plugin.user_admin.user',
		'plugin.user_admin.teams_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Team = ClassRegistry::init('UserAdmin.Team');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Team);

		parent::tearDown();
	}

}
