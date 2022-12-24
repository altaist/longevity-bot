namespace Expertix\Module\Store;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\Log;


class #CLASSNAME extends BaseApiController
{
	function onCreate()
	{
		$this->addRoute("#DATATYPE_create", "create");
		$this->addRoute("#DATATYPE_update", "update");
		$this->addRoute("#DATATYPE_delete", "delete");
		$this->addRoute("#DATATYPE_get_list", "getCollection");
		$this->addRoute("#DATATYPE_get", "getObject");

		$this->addRoute("#DATATYPE_child_create", "createChild");
		$this->addRoute("#DATATYPE_child_delete", "deleteChild");
		$this->addRoute("#DATATYPE_child_get_list", "getChilds");
	}
	function getModel()
	{
		return new #MODELCLASS();
	}
	function getChildModel()
	{
		return new #CHILDMODELCLASS();
	}


	function getCollection($request)
	{
		$model = $this->getModel();
		$filter = new SqlFilter($request);
		return $model->getCollection($filter);
	}
	function getObject($request)
	{
		return $this->getWithChilds($request);
	}
	function getWithChilds($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");
		$#DATATYPE = $model->getObject($key);
		if (!$#DATATYPE) return null;
		$#DATATYPEId = $#DATATYPE->getId();

		$childModel = $this->getChildModel();
		$childs = $childModel->getServiceListForProduct($#DATATYPEId);

		if (is_array($childs) && count($childs) > 0) {
			$#DATATYPE->set("childId", $childs[0]["childId"]);
		}
		$#DATATYPE->set("childs", $childs);
		//Log::d("getProductWithServices", $#DATATYPE, 0);
		return $#DATATYPE;
	}

	public function create($request)
	{
		$model = $this->getModel();
		return $model->createUpdateProduct($request, "create");
	}
	public function update($request)
	{
		$model = $this->getModel();
		return $model->createUpdateProduct($request, "update");
	}
	public function delete($request)
	{
		$model = $this->getModel();
		$key = $request->get("key");
		return $model->delete($key);
	}

	// Childs
	function getChilds($request)
	{

		if (!$request->get("key")) {
			$request->set("key", $request->get("parentKey"));
		}

		$#DATATYPE = $this->getObject($request);
		if (!$#DATATYPE) {
			return null;
		}

		return $#DATATYPE->get("childs");
	}
	public function createChild($request)
	{
		$model = $this->getModel();
		$modelChild = $this->getChildModel();

		if (!$request->get("#DATATYPEId")) {
			$#DATATYPEKey = $request->getRequired("parentKey");
			$#DATATYPEId = $model->getIdByKey($#DATATYPEKey);
			$request->set("#DATATYPEId", $#DATATYPEId);
		}

		return $modelChild->create($request);
	}
	public function deleteChild($request)
	{
		$model = $this->getChildModel();
		$key = $request->get("key");
		return $model->delete($key);
	}
}
