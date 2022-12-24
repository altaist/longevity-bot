<?php
namespace Expertix\Core\App\Response;

interface IResponse{
	function print($content);
	function includeFile($path);
	function sendBuffered($content);
}