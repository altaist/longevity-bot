<?php
namespace Expertix\Module\Catalog\Meeting;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;


class ApiMeetingController extends BaseApiController
{
	function onCreate()
	{
		$this->addRoute("meeting_get_all", "getMeetingList", 0);
		$this->addRoute("meeting_get", "getMeeting", 0);
		$this->addRoute("meeting_create", "createMeeting", 5);
		$this->addRoute("meeting_update", "updateMeeting", 5);
		$this->addRoute("meeting_delete", "deleteMeeting", 10);
	}
}