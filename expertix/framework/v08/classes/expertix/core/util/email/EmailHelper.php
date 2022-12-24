<?php
namespace Expertix\Core\Util\Email;

class EmailHelper{
	private $config = null;
	private $emailSender = null;
	
	function __construct($config)
	{
		$this->setEmailConfig($config);

		$this->emailSender = new EmailSender();

		
	}
	function setEmailConfig($config){
		$this->config = $config;
	}
	function getEmailConfig(){
		return $this->config;
	}
	
	public function send($to, $subject, $body, $cc="", $bcc=""){
		$config = $this->config;
		$from = $config->get("email_from");
		$fromName = $config->get("email_from_name");
	
		$emailSender = $this->emailSender;
		if($config->get("email_dump", false)){
			$emailSender->dump(PATH_DUMP);
		}

		$emailSender->from($from, $fromName);
		$emailSender->to($to);
		$emailSender->subject($subject);
		$emailSender->body($this->createBody($body));
		return $emailSender->send($config->get("email_test_mode", false));		
	}
	public function createBody($text){
		$config = $this->config;
		$header = $config->get("email_header");
		$footer = $config->get("email_footer");
		
		return $header.$text.$footer;		
	}
}