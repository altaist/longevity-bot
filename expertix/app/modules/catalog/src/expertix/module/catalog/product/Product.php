<?php
namespace Expertix\Module\Catalog\Product;

use Expertix\Core\Data\DataObject;

class Product extends DataObject{
	public function getId(){
		return $this->get("productId");
	}
	
	public function getKey()
	{
		return $this->get("productKey");
	}

	public function getTitle()
	{
		return $this->get("title");
	}
	public function getSubTitle()
	{
		return $this->get("subTitle");
	}
	public function getImg()
	{
		return $this->get("img");
	}
	public function getVideo()
	{
		return $this->get("video");
	}
	
} 