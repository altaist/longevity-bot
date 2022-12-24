<?php
namespace Expertix\Core\Data;

interface IModelCrudRead
{

	public function getCrudObject($params);
	public function getCrudCollection($sqlFilter, $orderBy);

}