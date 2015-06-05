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
	
	function unbindAll($params = array()) {
		foreach($this->__associations as $ass) {
			if(!empty($this->{$ass})) {
				$this->__backAssociation[$ass] = $this->{$ass};
				if(isset($params[$ass])) {
					foreach($this->{$ass} as $model => $detail) {
						if(!in_array($model,$params[$ass])) {
							$this->__backAssociation = array_merge($this->__backAssociation, $this->{$ass});
							unset($this->{$ass}[$model]);
						}
					}
				}
				else {
					$this->__backAssociation = array_merge($this->__backAssociation, $this->{$ass});
					$this->{$ass} = array();
				}
			
			}
		}
		return true;
	}
	
}
