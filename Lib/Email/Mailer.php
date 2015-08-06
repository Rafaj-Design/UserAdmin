<?php

App::uses('CakeEmail', 'Network/Email');


class Mailer {
		
	protected $email;
	
	protected $recipient;
	protected $subject;
	private $vars;
	
	function __construct() {
		if (!$this->email) {
			$this->email = new CakeEmail('gmail');
		}
	}
	
	protected function setVars($vars) {
		$vars['servername'] = 'LiveUI';
		$vars['url'] = Router::url('/', true);
		$this->vars = $vars;
	}
	
	protected function send() {
		$this->email->from(array('robot@liveui.io' => 'LiveUI'));
		$this->email->to($this->recipient);
		$this->email->subject($this->subject);
		$this->email->viewVars($this->vars);
		$this->email->emailFormat('html');
		/*
		$path = APP.'webroot/Userfiles/Settings/Images/'.md5(Me::teamId()).'/Logo';
		if (!file_exists($path)) {
			$path = APP.'webroot/Userfiles/Settings/Images/'.md5(1).'/Logo';
		}
		$mime = image_type_to_mime_type(exif_imagetype($path));
		$ext = explode('/', $mime);
		$key = 'logo.'.$ext[1];
		$this->email->attachments(array(
			$key => array(
		        'file' => $path,
		        'mimetype' => $mime,
		        'contentId' => 'logoImg123',
		        'contentDisposition' => false
			)
		));
		*/
		$ret = $this->email->send();
		return $ret;
	} 
		
}
