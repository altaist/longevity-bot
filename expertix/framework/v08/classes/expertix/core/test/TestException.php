<?php
namespace Expertix\Core\Test;

class TestException extends \Exception
{
	public function __construct($object, $value, $comments)
	{
		$message = ($comments ? $comments . ". " : "") . "Test failed for test value= '$value'";
		parent::__construct($message, 0);
	}
}
