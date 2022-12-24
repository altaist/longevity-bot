<?php

namespace Expertix\Module\Store\Order;

use Expertix\Core\Data\DataObject;

class Order extends DataObject{
	function getId(){
		return $this->get("id");
	}
	function getKey()
	{
		return $this->get("key", $this->get("orderKey"));
	}

}