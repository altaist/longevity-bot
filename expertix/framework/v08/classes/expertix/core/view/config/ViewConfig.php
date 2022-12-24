<?php
namespace Expertix\Core\View\Config;

use Expertix\Core\App\AppContext;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class ViewConfig extends ArrayWrapper{
	
	protected $templatePath = "";
	protected $parentTemplatePath = "";

	protected $moduleKey = null;
	protected $pathPages = PATH_PAGES;
	
	function __construct($array){
		parent::__construct($array);
		$this->template = $this->getParam( "template", "default/template.php");
		
		// Module and pages path
		$this->moduleKey = $this->getParam("module", null);

		$this->pathPages = PATH_PAGES;
		if ($this->moduleKey) {
			$module = AppContext::getApp()->getModule($this->moduleKey);
			$this->pathPages = $module["path"] . "view/pages/"  ;
		}
		
		$this->pathPages = $this->pathPages . $this->get("page_root");

	}
	private $user;

	function getUser()
	{
		return $this->user;
	}
	function setUser($user)
	{
		$this->user = $user;
	}

	
	public function getTitle()
	{
		return $this->getParam( "title", "Страница приложения");
	}
	public function getTemplate()
	{
		return $this->getParam( "template");
	}
	public function getPage()
	{
		return $this->getParam( "page");
	}
	public function getJs()
	{
		return $this->getParam( "js");
	}

	function getBaseSiteUrl()
	{
		return AppContext::getConfig()->getBaseSiteUrl();
	}
	function getBaseUrl()
	{
		return $this->getBaseSiteUrl();
	}
	function getApiEndpoints(){
		return $this->get("api_endpoints");
	}
	

	public function getPagePath()
	{
		$pageName = $this->getPage();
		// Includes auto detected page view (for example list details)
		$pageName = $this->get("page_auto_detected", $pageName);

		//Log::d("ViewConfig", $this->pathPages . $pageName);
		if (!$pageName) return null;
		return $this->pathPages . $pageName;
	}
	public function getPageJsPath()
	{
		$pageJs = $this->getJs();
		$pageJs = $this->get("page_js_auto_detected", $pageJs);
		
		if(!$pageJs) return null;
		
		return $this->pathPages . $pageJs;
	}
	
	function getEmptyFilePath(){
		return PATH_BASE_TEMPLATE . "empty_for_include.php";
	}

	function getParamWithIncludePath($param, $default)
	{
		$path = $this->getParam($param, $default);
		if (empty($path)) return "";

		$templatePath = $this->getTemplatePath();
		$resultPath = $templatePath . $path;
		//MyLog::d("getIncludePath", $path);
		return $resultPath;
	}
	function prepareIncludePath($path){
		if(!file_exists($path)){
			$this->getEmptyFilePath();
		}
		return $path;
	}
	
	function getTemplateIncPath($param, $default="", $subPath="")
	{
		$defaultResultPath = $this->getEmptyFilePath();
		
		$path = $this->getParam($param, $default);
		if (empty($path)) return $defaultResultPath;

		$templatePath = $this->getTemplatePath();
		$resultPath = $templatePath . $subPath . "/". $path;
//		Log::d("getTemplateIncPath", $resultPath);

		if (file_exists($resultPath)){
			return $resultPath;
		}

		$parentTemplatePath = $this->getParentTemplatePath();
		$resultPath = $parentTemplatePath . $subPath ."/" . $path;
//		Log::d("getIncludePathWithParent", $resultPath);

		if (file_exists($resultPath)) {
			return $resultPath;
		}
		return	$defaultResultPath;
	}
	
	function getTemplateFrameworkPath($param, $default, $postfix){
		$defaultResultPath = $this->getEmptyFilePath();

		$key = $this->getParam($param, $default);
		if (empty($key)) return $defaultResultPath;
		$templatePath = $this->getTemplatePath();
		$parentTemplatePath = $this->getParentTemplatePath();
		
		$resultPath = $templatePath . "framework/" . $key . "_" . $postfix . ".php";
		if (file_exists($resultPath)) {
			return $resultPath;
		}
		$resultPath = $parentTemplatePath . "framework/" . $key . "_" . $postfix . ".php";
		//Log::d("FrameWork path:", $resultPath);
		if (file_exists($resultPath)) {
			return $resultPath;
		}
		return	$defaultResultPath;		
	}
	function getTemplatePageLayoutPath($param, $default)
	{
		$defaultResultPath = $this->getEmptyFilePath();

		$key = $this->getParam($param, $default);
		if (empty($key)) return $defaultResultPath;
		$templatePath = $this->getTemplatePath();
		$parentTemplatePath = $this->getParentTemplatePath();

		$resultPath = $templatePath . "page/layout/" . $key . ".php";
		if (file_exists($resultPath)) {
			return $resultPath;
		}
		$resultPath = $parentTemplatePath . "page/layout/" . $key . ".php";
		if (file_exists($resultPath)) {
			return $resultPath;
		}
		return	$defaultResultPath;
	}

	function getTemplateIncPathWithoutParent($param, $default, $subPath = "")
	{
		$defaultResultPath = $this->getEmptyFilePath();

		$path = $this->getParam($param, $default);
//		Log::d("getIncludePath", $path);
		if (empty($path)) return $defaultResultPath;

		$templatePath = $this->getTemplatePath();
		$resultPath = $templatePath . $subPath . $path;
		return $resultPath;
	}
	
	function includeJsMixin($name){
		$path = PATH_APP_LIB . "web/js/mixins/vue_mixins_$name.php"; 
		include $path;
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
	public function setIfEmpty($key, $value)
	{
		if($this->checkParam($key)) return;
		
		return $this->set($key, $value);
	}
}
