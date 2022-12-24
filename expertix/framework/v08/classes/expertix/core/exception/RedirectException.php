<?php

namespace Expertix\Core\Exception;

class RedirectException extends AppException
{
	protected $url = null;
	protected $path = null;
	
	function __construct($message, $code=0)
	{
		$this->setRedirectPath($message);
	}

	function setRedirectUrl($url)
	{
		$this->url = $url;
	}
	function setRedirectPath($path)
	{
		$this->path = $path;
	}
	function getRedirectUrl(){
		return $this->url;
	}
	function getRedirectPath()
	{
		return $this->path;
	}

}