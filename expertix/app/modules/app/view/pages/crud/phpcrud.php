	<pre>
	<?php

	use Expertix\Core\Db\DB;


	function printModel($objectType, $className, $namespace, $tableName, $fields, $idField, $keyField)
	{
		$br = "\n";
		ob_start();
		echo "<?php$br";
		require (__DIR__ . "/inc/model_class_start.php");
		$strInclude = ob_get_contents();
		ob_end_clean();
		$strInclude = str_replace("#DATATYPE", $objectType, $strInclude);
		$strInclude = str_replace("#CLASSNAME", $className, $strInclude);
		$strInclude = str_replace("#NAMESPACE", $namespace, $strInclude);
		$strInclude = str_replace("#TABLENAME", $tableName, $strInclude);
		$strInclude = str_replace("#KEYFIELD", $keyField, $strInclude);

		print($strInclude);	
/*		
		echo ("namespace Expertix\Module\\$namespace;$br");
		echo ("use Expertix\Core\Db\DB;$br");
		echo ("use Expertix\Core\Util\Log;$br");
		echo ("class $className{ $br");
*/
		echo ("public function getObject(\$request){ $br"); //// Start select
		// Select
		echo "$br";
		echo "\t\$key = \$request->get('$keyField', \$request);$br";
		echo ("\t\$sql = \"select 1");
		foreach ($fields as $key => $fieldName) {
			echo ", $fieldName";
		}
		echo (" from $tableName where $keyField=?\";$br");
		echo "\treturn DB::getrow(\$sql, [\$key]);$br";
		echo ("}$br$br"); //// End select

		echo ("public function getCollection(\$request){ $br"); //// Start select
		// Select
		echo "$br";
		echo ("\t\$sql = \"select 1");
		foreach ($fields as $key => $fieldName) {
			echo ", $fieldName";
		}
		echo (" from $tableName\";$br");
		echo "\treturn DB::getAll(\$sql, []);$br";
		echo ("}$br$br"); //// End select

		echo ("public function create(\$request){ $br"); //// Start create 

		foreach ($fields as $key => $fieldName) {
			echo "\t\$$fieldName = \$request->get('$fieldName');$br";
		}
		echo "$br\t\$$keyField = \$this->createKey('$className');$br";
		
		// Params
		echo ("\t\$params = [");
		foreach ($fields as $key => $fieldName) {
			echo "$$fieldName, ";
		}
		echo "\$$keyField"; // Key field
		echo ("];$br");

		// Insert
		echo "$br";
		echo ("\t\$sql = \"insert into $tableName(");
		foreach ($fields as $key => $fieldName) {
//			echo "$fieldName" . ($key == count($fields) - 1 ? "" : ",") . " ";
			echo "$fieldName, ";
		}
		echo "$keyField";
		echo ") values(";
		foreach ($fields as $key => $fieldName) {
			echo "?, ";
		}
		echo "?"; // Key field
		echo (")\";$br");
		echo ("\treturn DB::add(\$sql, \$params);$br");

		echo ("}$br$br"); //// End create

		echo ("public function update(\$request){ $br"); //// Start update 

		foreach ($fields as $key => $fieldName) {
			echo "\t\$$fieldName = \$request->get('$fieldName');$br";
		}
		echo "$br\t\$$keyField = \$request->get('$keyField');$br";

		// Params
		echo ("\t\$params = [");
		foreach ($fields as $key => $fieldName) {
			echo "$$fieldName, ";
		}
		echo "\$$keyField"; // Key field
		echo ("];$br");

		// Insert
		echo "$br";
		echo ("\t\$sql = \"update $tableName set ");
		foreach ($fields as $key => $fieldName) {
			echo "$fieldName=? " . ($key == count($fields) - 1 ? "" : ",") ;
		}
		echo " where $keyField=?";
		echo ("\";$br");
		echo ("\treturn DB::set(\$sql, \$params);$br");

		echo ("\t}$br"); //// End create
		
		echo ("}$br"); //// End class


	}

	function printController($objectType, $className, $namespace, $tableName, $modelClass, $childModelClass)
	{
		$br = "\n";
		ob_start();
		echo "<?php$br";

		require(__DIR__ . "/inc/class_controller.php");
		$strInclude = ob_get_contents();
		ob_end_clean();
		$strInclude = str_replace("#DATATYPE", $objectType, $strInclude);
		$strInclude = str_replace("#CLASSNAME", $className, $strInclude);
		$strInclude = str_replace("#NAMESPACE", $namespace, $strInclude);
		$strInclude = str_replace("#TABLENAME", $tableName, $strInclude);
		$strInclude = str_replace("#KEYFIELD", $keyField, $strInclude);
		$strInclude = str_replace("#MODELCLASS", $modelClass, $strInclude);
		$strInclude = str_replace("#CHILDMODELCLASS", $childModelClass, $strInclude);

		print($strInclude);
		
	}

	$objectType = "order";
	$namespace = "Order";
	$tableName = "store_order";
	
	$idField = "{$objectType}Id";
	$keyField = "{$objectType}Key";
	$fields = DB::getTableColumns($tableName, "'created', 'orderId', 'orderKey', 'updated', 'created'");

	// Model
	$className = "OrderModel";
	$fileName = "$className.php";
	ob_start();
	printModel($objectType, $className, $namespace, $tableName, $fields, $idField, $keyField);
	$strResult = ob_get_contents();
	ob_end_clean();
	file_put_contents(__DIR__ . "\\result\\$fileName", $strResult);
	echo $strResult;
	
	// Controller
	$className = "OrderController";
	$fileName = "$className.php";
	ob_start();
	printController($objectType, $className, $namespace, $tableName, "OrderModel", "");
	$strResult = ob_get_contents();
	ob_end_clean();
	file_put_contents(__DIR__ . "\\result\\$fileName", $strResult);
	echo $strResult;
	
	
	
	// View

	?>
	
	</pre>