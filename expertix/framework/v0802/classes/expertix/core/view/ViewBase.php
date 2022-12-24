<?php
namespace Expertix\Core\View;

use Expertix\Core\App\AppContext;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;
use Expertix\Core\View\Theme\ThemeBootstrap;

abstract class ViewBase{
	protected $viewConfig;
	protected $pageData;
	protected $themeHelper = null;
	
	abstract function render($response = null);
	
	public function __construct($viewConfig, $pageData)
	{
		$this->viewConfig = $viewConfig;
		$this->pageData = $pageData;
		
		//Log::d("ViewBase params: ", $viewConfig->getArray());

		$viewHelperClass = $viewConfig->getParam("view_theme_class", ThemeBootstrap::class);
		if($viewHelperClass){
			$this->themeHelper = new $viewHelperClass($this->viewConfig);//AppLoader::createObject($viewHelperClass, $this->viewConfig);
		}		
	}
	

	public function component($name, $params = [])
	{
		$module = "";
		$component = $name;
		if($name[0]=="@"){
			$pos = strpos($name, "/");
			$module = substr($name, 1, $pos-1);
			$component = substr($name, $pos+1, strlen($name)-$pos);
		}
		
		//		$componentPath = $this->viewConfig->getComponentsRoot() . $name;
		if($module){
			return $this->moduleComponent($module, $component, $params);
		}else{
			$componentPath = PATH_VIEW_COMPONENTS . $component . ".php";
			return $this->showComponent($componentPath, $params);
		}
		
	}
	public function moduleComponent($moduleName, $name, $_params = [])
	{
		$module = AppContext::getApp()->getModule($moduleName);
		if (!$module) {
			//			return $this->component($name, $_params);
		}

		//$componentPath = $this->viewConfig->getComponentsRoot() . $name;
		$componentPath = $module["path"] . "view/components/" . $name . ".php";
		$params = $_params;
		return $this->showComponent($componentPath, $_params);
	}
	
	public function componentDialog($formComponent, $dialogId, $params){
		return $this->componentDialogCustom("@app/form/dialog", $formComponent, $dialogId, $params);
	}
	public function componentDialogCustom($dialogComponent, $formComponent, $dialogId, $params){
		$params = is_array($params) ? new ArrayWrapper($params) : $params;
		$params->setIfEmpty("dialogId", $dialogId);
		$params->setIfEmpty("vue_model", $dialogId);
		$params->setIfEmpty("view_dialog", true);
		$params->setIfEmpty("component", $formComponent);
		
		return $this->component($dialogComponent, $params);
	}
	public function componentDialogEdit($formComponent, $action, $params)
	{
		$params = is_array($params) ? new ArrayWrapper($params) : $params;
		$params->setIfEmpty("btn_ok_action", $action);
		$params->setIfEmpty("component", $formComponent);

		return $this->component("@app/form/dialog-edit", $params);
	}
	public function componentDialogNew($formComponent, $action, $params)
	{
		$params = is_array($params) ? new ArrayWrapper($params) : $params;
		$params->setIfEmpty("btn_ok_action", $action);
		$params->setIfEmpty("component", $formComponent);

		return $this->component("@app/form/dialog-new", $params);
	}
	
	public function section($title, $h=2){
		$this->component("title", ["title"=>$title, "h"=>$h]);
	}

	private function showComponent($path, $_params)
	{
		$params = is_array($_params) ? new ArrayWrapper($_params) : $_params;
		$props = $params;
		$view = $this;
		$user = $this->getUser();
		//echo $this->preProcess("");
		include($path);
		//echo $this->postProcess("");
	}

	function sendAsJson($result)
	{
		//		echo '<meta charset="utf-8">';

		$jsonResult = json_encode(["error" => "Error in json_encode while sending results"]);
		try {
			$jsonResult = json_encode($result);
		} catch (\Throwable $th) {
			//			exit;
			$jsonResult = json_encode(["error" => "Ошибка при формировании ответа в формате json: " . $th->getMessage()]);
		}

		print_r($jsonResult);
		return null;
	}
	static function sendAsText($result)
	{
		echo ('<html><head><meta charset="utf-8"><head><body>');
		print_r($result);
		echo ("<br><br></body>");
		return null;
	}

	function sendAsHtml($result)
	{
		print_r($result);
		return null;
	}

	function getViewConfig()
	{
		return $this->viewConfig;
	}

	function getPageData()
	{
		return $this->pageData;
	}
	
	function getUser(){
		return $this->getPageData()->getUser();
	}
	
	
	function getThemeHelper(){
		return $this->themeHelper;
	}


}

?>