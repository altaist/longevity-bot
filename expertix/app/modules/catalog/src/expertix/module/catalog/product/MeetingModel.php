<?php

namespace Expertix\Module\Catalog\Product;


use Expertix\Core\Data\BaseModel;
use Expertix\Core\Db\DB;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;


class MeetingModel extends BaseModel
{
	function setup()
	{
		$this->tableName = "srv_meeting";
		$this->dataType = "meeting";
		$this->keyField = "meetingKey";
	}
	

}