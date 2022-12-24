<?php
namespace Expertix\Core\View;

use Expertix\Core\App\AppContext;
use Expertix\Core\App\AppLoader;
use Expertix\Core\Util\Log;
use Expertix\Core\View\Template\TemplateBase;

class ViewPage extends ViewBase{
	function render($response = null){
		$this->includePage($response);
	}
	public function checkUserIsEditor(){
		$user = $this->getPageData()->getUser();
		if(!$user){
			return false;
		}
		if(!$user->isEditor()){
			return false;
		}
		return true;
	}
	
	protected function includePage($response){
//		$controllerConfig = $this->getViewConfig();
		
//		Log::d("WebPageController.includePage", $controllerConfig->getArray(), 1);
//		$view = new View($controllerConfig, "");//AppBase::getConfig()->getSysParam("BASE_URL"));
		

		// Data
		$pageData = $this->getPageData();
		$dataObject = $pageData->getDataObject();
		$dataList = $pageData->getDataCollection();

		// View
		$viewConfig = $this->getViewConfig();
		$view = $this;
		$pageBuilder = $this->getThemeHelper();

		$vh = $pageBuilder;
		$theme = $vh;

		
		$template = $viewConfig->getTemplate();
		if(!$template){
			$template = "template.php";
		}
		
//		Log::d("View config", $viewConfig->getArray());
//		Log::d("ViewAsIncludedPage $autoPage", $pageData->getDataCollection());

		//		$templateObject = new TemplateBase($view, $pageData);
		//		$templateObject->render($response);

		$pathTemplate = PATH_PROJECT_TEMPLATES .$template;
//		Log::d("Including template: $pathTemplate");
		if(file_exists($pathTemplate)){
			require_once $pathTemplate;
		}else{
			$pathTemplate = PATH_APP_TEMPLATES . $template;
			if (file_exists($pathTemplate)) {
				require_once $pathTemplate;
			}else{
				$pathTemplate = PATH_PROJECT_TEMPLATE_DEFAULT . $template;
				require_once $pathTemplate;
			}
		}
	}
}
?>