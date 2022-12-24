<?php
namespace Expertix\Core\Controller;

use Expertix\Core\Controller\Base\BaseSiteController;
use Expertix\Core\View\ViewPage;
use Expertix\Core\Util\Log;

class WebPageController extends BaseSiteController
{
	public function prepareData(){		
	}
	
	public function createView()
	{
		$pageData = $this->getPageData();		
		$viewClass = $this->getControllerConfig()->get("view_class", ViewPage::class);
		$view = new $viewClass($this->getViewConfig(), $pageData);
		return $view;
	}
}
