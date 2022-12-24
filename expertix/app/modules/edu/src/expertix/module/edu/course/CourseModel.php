<?php
namespace Expertix\Module\Edu;

use Expertix\Core\Data\BaseModel;

class CourseModel extends BaseModel{
	public function getCrudObject($productId, $user = null)
	{
		return $this->getProductWithServices($productId);
	}
	public function getCrudCollection($query, $user = null)
	{
		return $this->getProductsList($query);
	}
}