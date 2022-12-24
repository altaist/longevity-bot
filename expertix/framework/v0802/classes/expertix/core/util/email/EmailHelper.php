<?php
namespace Expertix\Core\Util\Email;

use Expertix\Core\App\AppContext;
use Expertix\Core\Util\Log;

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

		$subject = str_replace("#APP_ID", AppContext::getAppId(), $subject);
		$body = str_replace("#APP_ID", AppContext::getAppId(), $body);

		$emailSender->from($from, $fromName);
		$emailSender->to($to);
		$emailSender->subject($subject);
		$emailSender->body($this->createBody($body));
		//Log::d("EmailHelper sending. Dump:".$config->get("email_dump", false));

		if ($config->get("email_dump", false)) {
			$emailSender->dump(PATH_DUMP);
		}
		return $emailSender->send($config->get("email_test_mode", false));		
	}
	public function createBody($text){
		$config = $this->config;
		$header = $config->get("email_header");
		$footer = $config->get("email_footer");
		
		return $header.$text.$footer;		
	}
}