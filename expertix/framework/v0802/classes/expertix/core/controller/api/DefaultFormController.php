<?php
namespace Expertix\Core\Controller\Api;

use Expertix\Core\App\App;
use Expertix\Core\App\AppContext;
use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\DB;
use Expertix\Core\User\UserMessageManager;

class DefaultFormController extends BaseApiController{
	protected function onCreate()
	{
		parent::onCreate();
		$this->addRoute("feedback", "feedback");
	}
	public function feedback($request){
		
		$name = $request->get("name", $request->get("firstName"));
		$name = $request->get("firstName", $name);
		$tel = $request->get("tel");
		$email = $request->required("email");
		$age = $request->get("age");
		$address = $request->get("address");
		$comments = $request->get("comments");
		
		$formId = $request->get("formId");
		$productId = $request->get("productId");
		
		$appKey = AppContext::getConfig()->getAppId();
			
		$params = [$appKey, $formId, $productId, $name, $tel, $email, $age, $address, $comments];
		
		$sql = "insert into store_request (appKey, formId, productId, name, tel, email, age, address, comments) values(?,?,?,?,?,?,?,?,?);";
		$id = DB::add($sql, $params);
		$row = DB::getRow("select * from store_request where requestId=?", $id);

		(new UserMessageManager())->notifyAdminOnFormSubmit($request);
		return $row;
		
	}
}
