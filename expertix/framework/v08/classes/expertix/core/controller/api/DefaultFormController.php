<?php
namespace Expertix\Core\Controller\Api;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\DB;

class DefaultFormController extends BaseApiController{
	protected function onCreate()
	{
		parent::onCreate();
		$this->addRoute("feedback", "feedback");
	}
	public function feedback($request){
		
		$name = $request->required("name");
		$tel = $request->get("tel");
		$email = $request->required("email");
		$age = $request->get("age");
		$address = $request->get("address");
		$comments = $request->get("comments");
		
			
		$params = [$name, $tel, $email, $age, $address, $comments];
		
		$sql = "insert into store_request (name, tel, email, age, address, comments) values(?,?,?,?,?,?);";
		$id = DB::add($sql, $params);
		$row = DB::getRow("select * from store_request where requestId=?", $id);
		return $row;
		
	}
}
