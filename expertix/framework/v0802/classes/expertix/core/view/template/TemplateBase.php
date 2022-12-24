<?php

namespace Expertix\Core\View\Template;

class TemplateBase
{
	protected $viewConfig;
	protected $pageData;
	public function __construct($view, $pageData)
	{
		$this->viewConfig = $view;
		$this->pageData = $pageData;
	}
	public function render($response)
	{
		$view = $this->getViewConfig();
		$this->header($view);

		$response->print("</head>");
		$response->print("<body>");

		$this->page($view);
		$this->footer($view);

		$response->print("</body>");
		$response->print("</html>");
	}

	protected function header($view)
	{
		$this->headerMeta($view);
		if ($view->checkParam("view_js_framework")) {
			$this->headerFramework($view);
		}
		$this->headerCustom($view);
?>

		<style>
			[v-cloak] {
				display: none;
			}
		</style>
		<script src="js/expertix.js"></script>

	<?php

	}
	protected function headerMeta($view)
	{
	?>
		<!doctype html>
		<!--[if IE 9]><html class="ie ie9"><![endif]-->
		<html lang="ru">

		<head>
			<title><?= $view->getParam("title", "Страница проекта") ?></title>

			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta charset="utf-8">
			<meta name="description" content="<?= $view->getParam("view_description", "Страница проекта") ?>">

			<meta property="og:title" content="<?= $view->getParam("title", "Страница проекта") ?>">
			<meta property="og:type" content="<?= $view->getParam("view_meta_type", "") ?>">
			<meta property="og:url" content="<?= $view->getParam("view_meta_url", "") ?>">
			<meta property="og:image" content="<?= $view->getParam("view_meta_image", "") ?>">

			<base href="<?= $view->getBaseUrl() ?>" />
	<?php


	}

	protected function headerFramework($view)
	{
	}

	protected function headerCustom()
	{
	}


	protected function page($view)
	{
	}

	protected function footer($view)
	{
		if ($view->checkParam("view_js_framework")) {
			$this->footerFramework($this->getViewConfig()->get("view_js_framework"));
		}
		$this->footerCustom();
	}

	protected function footerFramework($framework)
	{
	}
	protected function footerCustom()
	{
	}

	// Getters
	function getViewConfig()
	{
		return $this->viewConfig;
	}

	function getPageData()
	{
		return $this->pageData;
	}
}
