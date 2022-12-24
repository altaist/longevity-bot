<?php
namespace Expertix\Core\View;

use Expertix\Core\App\AppContext;
use Expertix\Core\App\AppLoader;
use Expertix\Core\Util\Log;

use Expertix\Core\View\Theme\ThemeBootstrap;

class View{
	protected $controllerParams = [];
	protected $themeHelper = null;
	protected $pageTitle = "";
	protected $baseSiteUrl = "";
	protected $templatePath = "";
	protected $parentTemplatePath = "";

	protected $moduleKey = null;
	protected $pathPages = PATH_PAGES;
	
	function __construct($controllerParams)
	{
		$this->baseSiteUrl = AppContext::getConfig()->getBaseSiteUrl();
		$this->controllerParams = $controllerParams;

		// Other settings
		$this->template = $this->getParam( "template", "default/template.php");
		$this->pageTitle = $this->getParam( "title", "Страница приложения");
		$viewHelperClass = $this->getParam("theme_class", ThemeBootstrap::class);
		if($viewHelperClass){
			$this->themeHelper = AppLoader::createObject($viewHelperClass);
		}
	}
	function getThemeHelper(){
		return $this->themeHelper;
	}
	function getIncludePath($param, $default = "")
	{
		$path = $this->getParam($param, $default);
		if (empty($path)) return "";

		$templatePath = $this->getTemplatePath();
		$resultPath = $templatePath . $path;
		//MyLog::d("getIncludePath", $path);
		return $resultPath;
	}
	function getIncludePathWithParent($param, $default = "")
	{
		$path = $this->getParam($param, $default);
		if (empty($path)) return "";
		$templatePath = $this->getTemplatePath();
		$resultPath = $templatePath . $path;
		if (file_exists($resultPath)){
			return $resultPath;
		}

		$parentTemplatePath = $this->getParentTemplatePath();
		$resultPath = $parentTemplatePath . $path;
		//MyLog::d("getIncludePathWithParent", $resultPath);

		if (file_exists($resultPath)) {
			return $resultPath;
		}
		

		return "";
	}
	function component($key, $componentData = [])
	{
		$view = $this;
		$params = $componentData;

		include $key;
	}

	public function getTitle()
	{
		return $this->pageTitle;
	}
	public function calculatePagePath(){
		
	}
	
	public function getPagePath()
	{
		$pageName = $this->getParam( "page", "");
		if (!$pageName) return null;
		
		return $this->pathPages . $pageName;
	}
	public function getPageJsPath()
	{
		$pageJs = $this->getParam("js", "");
		if(!$pageJs) return null;
		return $this->pathPages . $pageJs;
	}


	function getBaseSiteUrl()
	{
		return $this->baseSiteUrl;
	}
	function getBaseUrl()
	{
		return $this->getBaseSiteUrl();
	}
	
	function getTemplatePath()
	{
		return $this->templatePath;
	}
	function setTemplatePath($path)
	{
		$this->templatePath = $path;
	}
	function getParentTemplatePath()
	{
		return $this->parentTemplatePath;
	}
	function setParentTemplatePath($path)
	{
		$this->parentTemplatePath = $path;
	}

	public function checkParam($key)
	{
		if(empty($this->getParam($key))){
			return false;
		}
		return $this->getParam($key)=="no"?false:true;
	}
	public function getParam($key, $value = "")
	{
		return $this->get($key, $value);
	}
	public function get($key, $value = "")
	{
		return $this->controllerParams->get($key, $value);
	}
	public function set($key, $value)
	{
		return $this->controllerParams->set($key, $value);
	}
	public function setIfEmpty($key, $value)
	{
		if($this->checkParam($key)) return;
		
		return $this->controllerParams->set($key, $value);
	}
}

?>