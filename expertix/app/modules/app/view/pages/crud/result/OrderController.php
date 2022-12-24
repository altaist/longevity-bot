<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined variable: keyField in C:\xampp\htdocs\programaster.ru\app\project\modules\app\view\pages\crud\phpcrud.php on line <i>129</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.4094</td><td bgcolor='#eeeeec' align='right'>417256</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\xampp\htdocs\programaster.ru\web\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.4116</td><td bgcolor='#eeeeec' align='right'>421112</td><td bgcolor='#eeeeec'>require_once( <font color='#00bb00'>'C:\xampp\htdocs\programaster.ru\app\startup.php'</font> )</td><td title='C:\xampp\htdocs\programaster.ru\web\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>19</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.4858</td><td bgcolor='#eeeeec' align='right'>932280</td><td bgcolor='#eeeeec'>Expertix\Core\App\App->process(  )</td><td title='C:\xampp\htdocs\programaster.ru\app\startup.php' bgcolor='#eeeeec'>...\startup.php<b>:</b>13</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.5465</td><td bgcolor='#eeeeec' align='right'>1337008</td><td bgcolor='#eeeeec'>Expertix\Core\View\ViewAsIncludedPage->render(  )</td><td title='C:\xampp\htdocs\applib\v07\classes\expertix\core\app\App.php' bgcolor='#eeeeec'>...\App.php<b>:</b>55</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.5465</td><td bgcolor='#eeeeec' align='right'>1337008</td><td bgcolor='#eeeeec'>Expertix\Core\View\ViewAsIncludedPage->includePage(  )</td><td title='C:\xampp\htdocs\applib\v07\classes\expertix\core\view\ViewAsIncludedPage.php' bgcolor='#eeeeec'>...\ViewAsIncludedPage.php<b>:</b>11</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.5486</td><td bgcolor='#eeeeec' align='right'>1338360</td><td bgcolor='#eeeeec'>require_once( <font color='#00bb00'>'C:\xampp\htdocs\programaster.ru\app\project\projects\travel04\view\templates\default\quasar.php'</font> )</td><td title='C:\xampp\htdocs\applib\v07\classes\expertix\core\view\ViewAsIncludedPage.php' bgcolor='#eeeeec'>...\ViewAsIncludedPage.php<b>:</b>39</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.5494</td><td bgcolor='#eeeeec' align='right'>1345840</td><td bgcolor='#eeeeec'>include( <font color='#00bb00'>'C:\xampp\htdocs\programaster.ru\app\project\projects\travel04\view\templates\default\template.php'</font> )</td><td title='C:\xampp\htdocs\programaster.ru\app\project\projects\travel04\view\templates\default\quasar.php' bgcolor='#eeeeec'>...\quasar.php<b>:</b>4</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.5513</td><td bgcolor='#eeeeec' align='right'>1348408</td><td bgcolor='#eeeeec'>require_once( <font color='#00bb00'>'C:\xampp\htdocs\applib\v07\templates\base\template.php'</font> )</td><td title='C:\xampp\htdocs\programaster.ru\app\project\projects\travel04\view\templates\default\template.php' bgcolor='#eeeeec'>...\template.php<b>:</b>20</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.5562</td><td bgcolor='#eeeeec' align='right'>1357080</td><td bgcolor='#eeeeec'>require( <font color='#00bb00'>'C:\xampp\htdocs\applib\v07\templates\base\page\layout\default.php'</font> )</td><td title='C:\xampp\htdocs\applib\v07\templates\base\template.php' bgcolor='#eeeeec'>...\template.php<b>:</b>9</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.5630</td><td bgcolor='#eeeeec' align='right'>1392176</td><td bgcolor='#eeeeec'>require( <font color='#00bb00'>'C:\xampp\htdocs\programaster.ru\app\project\modules\app\view\pages\crud\phpcrud.php'</font> )</td><td title='C:\xampp\htdocs\applib\v07\templates\base\page\layout\default.php' bgcolor='#eeeeec'>...\default.php<b>:</b>19</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.5686</td><td bgcolor='#eeeeec' align='right'>1420320</td><td bgcolor='#eeeeec'>printController(  )</td><td title='C:\xampp\htdocs\programaster.ru\app\project\modules\app\view\pages\crud\phpcrud.php' bgcolor='#eeeeec'>...\phpcrud.php<b>:</b>159</td></tr>
</table></font>
<?php
namespace Expertix\Module\Store;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\Log;


class OrderController extends BaseApiController
{
	function onCreate()
	{
		$this->addRoute("order_create", "create");
		$this->addRoute("order_update", "update");
		$this->addRoute("order_delete", "delete");
		$this->addRoute("order_get_list", "getCollection");
		$this->addRoute("order_get", "getObject");

		$this->addRoute("order_child_create", "createChild");
		$this->addRoute("order_child_delete", "deleteChild");
		$this->addRoute("order_child_get_list", "getChilds");
	}
	function getModel()
	{
		return new OrderModel();
	}
	function getChildModel()
	{
		return new ();
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
		$order = $model->getObject($key);
		if (!$order) return null;
		$orderId = $order->getId();

		$childModel = $this->getChildModel();
		$childs = $childModel->getServiceListForProduct($orderId);

		if (is_array($childs) && count($childs) > 0) {
			$order->set("childId", $childs[0]["childId"]);
		}
		$order->set("childs", $childs);
		//Log::d("getProductWithServices", $order, 0);
		return $order;
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

		$order = $this->getObject($request);
		if (!$order) {
			return null;
		}

		return $order->get("childs");
	}
	public function createChild($request)
	{
		$model = $this->getModel();
		$modelChild = $this->getChildModel();

		if (!$request->get("orderId")) {
			$orderKey = $request->getRequired("parentKey");
			$orderId = $model->getIdByKey($orderKey);
			$request->set("orderId", $orderId);
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
