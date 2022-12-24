<?php

namespace Expertix\Core\Exception;

class AppException extends \Exception
{
	private $data = null;
	private $messageForLog = null;
	
	function __construct($message, $code, $messageForLog=null, $data=null)
	{
		$this->setData($data);
		$this->setMessageForLog($messageForLog? $messageForLog: $message);
		parent::__construct($message, $code);
	}

	function getData()
	{
		return $this->data;
	}
	function setData($data)
	{
		$this->data = $data;
	}

	function getLogMessage()
	{
		return $this->messageForLog;
	}
	function setMessageForLog($messageForLog)
	{
		$this->messageForLog = $messageForLog;
	}

}