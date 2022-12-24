<?php
namespace Expertix\Core\Controller;

use Expertix\Core\App\App;
use Expertix\Core\Controller\Base\BaseSiteController;
use Expertix\Core\User\AffHelper;
use Expertix\Core\User\CompanyHelper;
use Expertix\Core\User\UserModel;
use Expertix\Core\Util\Log;
use Expertix\Core\View\View;
use Expertix\Core\View\ViewAsIncludedPage;

class WebPageController extends WebPageController
{
	/**
	 * Определяет AffKey из запроса (первый параметр) и фиксирует этот факт
	 */	
	public function prepareData(){
		$pageData = $this->getPageData();
		$affKey = $pageData->getObjectId();
		$pageData->set("affKey", $affKey);
		$user = $this->getUser();
		if ($user) {
			$affHelper = new AffHelper();
			$affHelper->processAffByKey($user, $affKey);

			$userId = $user->getId();
			$helper = new CompanyHelper();
			$agencyId = $helper->getUserAgencyId($userId);

			$user->set("agencyId", $agencyId);
		}		
	}
	
}
