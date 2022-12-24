<?php

namespace Expertix\Core\View;

class ViewJson extends ViewBase{
	
	public function render($response = null){
		$output = $this->getPageData()->getOutput();
		$this->sendAsJson($output);
	}
	
	
}