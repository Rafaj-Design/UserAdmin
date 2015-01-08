<?php

App::uses('AppModel', 'Model');


class UserAdminAppModel extends AppModel {
	
	public function getLastQuery() {
		$dbo = $this->getDatasource();
		$logs = $dbo->getLog();
		$lastLog = end($logs['log']);
		return $lastLog['query'];
	}
	
	public function getQueries() {
		$dbo = $this->getDatasource();
		$logs = $dbo->getLog();
		return $logs;
	}
	
}
