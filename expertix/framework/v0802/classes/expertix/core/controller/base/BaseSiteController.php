<?php
namespace Expertix\Core\Controller\Base;

abstract class BaseSiteController extends BaseController
{
	abstract public function prepareData();
	abstract public function createView();
	
	public function process()
	{
		$this->prepareData();
		return $this->createView();		
	}
}
