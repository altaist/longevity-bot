<?php
namespace Expertix\Core\Data;

use Expertix\Core\Util\ArrayWrapper;

abstract class DataObject extends ArrayWrapper{
	abstract public function getId();
}