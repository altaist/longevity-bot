<?php
namespace Expertix\Core\View\Theme;

use Expertix\Core\App\AppContext;
use Expertix\Core\Util\Utils;

class ThemeHtml extends ThemeBase{

	function text($text, $autoBr = "<br>")
	{
		return $this->html(Utils::text2html($text, $autoBr));
	}
	function html($html){
		return $this->process($html);
	}
	function a($title, $href, $tagParams=""){
		$html = "<a href='$href' $tagParams>$title</a>";
		return $this->process($html);
	}	

}