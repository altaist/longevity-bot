<?php
namespace Expertix\Core\View\Theme;

use Expertix\Core\App\AppContext;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Utils;

class ThemeBase {
	protected $autoPrint = false;
	protected $rowColsClass = null;
	protected $viewConfig = null;
	
	function __construct($viewConfig)
	{
		$this->viewConfig = $viewConfig;
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

	
	function setAutoPrint($autoPrint){
		$this->autoPrint = $autoPrint;
	}

	function startRow(){
		return $this->process("<div class='row'>",false);
	}
	function startCol($class="")
	{
		return $this->process("<div class='$class'>",false);
	}
	function endCol($cols = 1)
	{
		return $this->process("</div>",false);
	}
	function endRow()
	{
		$this->rowColsClass = null;
		return $this->process("</div>",false);
	}

	function startGrid($colsClass = "col")
	{
		$this->rowColsClass = $colsClass;
		return $this->process("<div class='row'>",false);
	}
	function endGrid()
	{
		$this->rowColsClass = null;
		return $this->process("</div><!-- //row-->",false);
	}

	
	function process($str, $autoPrePost=true){
		$result = $str;
		if ($autoPrePost) {
			$result = $this->preProcess($str) . $str . $this->postProcess($str);
		}
		
		if($this->autoPrint){
			echo $result;
			return $this;
		}

		return $result;
	}
	
	function preProcess($str){
		// Start col div
		if($this->rowColsClass){
			return "<div class='".$this->rowColsClass."'>";
		}
		return "";
	}
	function postProcess($str)
	{
		// End col div
		if ($this->rowColsClass) {
			return "</div><!-- //div col--> ";
		}
		return "";
	}

	function getArrValue($arr, $name, $default = "")
	{
		return !empty($arr[$name]) ? $arr[$name] : $default;
	}
	
}