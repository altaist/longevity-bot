<?php
namespace Expertix\Bot;
use Expertix\Core\Util\ArrayWrapper;

class ChatInstance extends ArrayWrapper{
	
	public function getLinkKey()
	{
		return $this->get("affKey");
	}
	

}