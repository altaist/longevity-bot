<?php

namespace Expertix\Core\View;

use Expertix\Core\Util\Utils;

class CrudBuilder
{
//	public $controller;
	static public function getInstance($controller = null)
	{
		return new CrudBuilder();
	}

	public function __construct()
	{
//		$this->controller = $controller;
	}

	public function getJsCrudConfig()
	{
		$crudConfig = $this->controller->getCrudConfig();
		$table = $this->getTableConfig($crudConfig);
		$crudConfigJs = [
			"table" => $table
		];
		return json_encode($crudConfig);
	}
	
	public function getFieldByKey($fields, $key)
	{
		if (empty($key)) return null;
		//MyLog::debug($fields);
		if (!empty($fields[$key])) {
			return $fields[$key];
		}
		foreach ($fields as $index => $field) {

			if (!empty($field["key"]) && $field["key"] == $key) {

				return $field;
			}
		}
		return null;
	}
	function get123($field, $key)
	{
		return Utils::getArrValue($field, $key, "");
	}
	public function getFormParam($field, $paramName, $defaultVal = "")
	{

		$value = Utils::getArrValue($field, $paramName, $defaultVal);
		if (!empty($value)) {
			return $value;
		}
		$res = $this->getFieldParam($field, $paramName, "form");

		return empty($res) ? $defaultVal : $res;
	}
	public function getTableParam($field, $paramName, $subParamArrName)
	{
		$value = Utils::getArrValue($field, $paramName, "");
		if (!empty($value)) {
			return $value;
		}
		return $this->getFieldParam($field, $paramName, "table");
	}


	public function getFieldParam($field, $paramName, $subParamArrName)
	{
		if (empty($field)) return "";
		if (!empty($field[$subParamArrName]) && !empty($field[$subParamArrName][$paramName])) {
			return $field[$subParamArrName][$paramName];
		}
		return empty($field[$paramName]) ? "" : $field[$paramName];
	}


	public function getTableConfig($crudConfig)
	{
		$objFields = $crudConfig["fields"];
		$title = Utils::getArrValue($objFields, "title", "");

		$table = $crudConfig["table"];
		$resultFields = [];
		if (is_array($table)) {
			$title = Utils::getArrValue($table, "title", $title);

			$fields = empty($table["fields"]) ? $table : $table["fields"];
			$counter = 0;
			foreach ($fields as $index => $item) {
				$key = $item;
				if (is_string($item) && !empty($this->getFieldByKey($objFields, $key))) {

					$field = $this->getFieldByKey($objFields, $key); // Ищем подробную информацию в списке полей
					//MyLog::d("found field with key $key", $field);
					//if (empty($field["key"])) continue;
					$label = $this->getFieldParam($field, "label", "table");
					$resultFields[] = ["key" => $key, "label" => $label];
				} else if (is_array($item)) {
					$resultFields[] = $item;
				} else {
					$resultFields[] = $item;
				}

				//$label = "";
			}
		}
		$resultTable = ["filterVal" => 0, "sortBy" => "", "sortDesc" => "", "title" => $title];
		$resultTable["fields"] = $resultFields;
		return $resultTable;

		$fields = $crudConfig["fields"];
		$counter = 0;
		foreach ($fields as $index => $item) {
			if (empty($item["key"]) || empty($item["table"]) || !is_array($item["table"])) {
				continue;
			}
			$key = $item["key"];
			$field = $item["form"];
			$fieldId = $key . $counter;
		}
	}

	public function createFormElements($formName = null, $jsFormPrefix)
	{

		$crud = $this->controller->getCrudConfig();
		$fields = $crud["fields"];

		if (empty($crud["form"]) || empty($crud["form"]["fields"])) {
			throw new \Exception("CRUD ERROR Wrong form config 'form'", 0);
		}

		$formFields = $crud["form"]["fields"];
		$defaultCols = Utils::getParam($crud["form"], "cols", "col-12 col-md-3");

		if (!empty($formName)) {
			$formFields = $crud["form"]["formName"];
			if (empty($formFields)) {
				throw new \Exception("Wrong form config '$formName'", 0);
			}
		}
		//		MyLog::d("form fields", $formFields);

		$counter = 0;
		foreach ($formFields as $index => $item) {
			//			if (empty($item["key"]) || empty($item["form"]) || !is_array($item["form"])) {
			//				continue;
			//			}
			$formField = [];
			$label = "";
			$sectionHeader = "";
			$key = null;
			//			MyLog::d("form", $item);
			if (is_array($item)) {
				if (empty($item["key"])) {
					$key = $index;
				} else {
					$key = $item["key"];
				}
				$field = $this->getFieldByKey($fields, $key); // Ищем подробную информацию в списке полей
				if (!empty($field)) {
					$formField = array_merge($field, $item);
				} else {
					$formField = $item;
				}

				//MyLog::d("Array");

			}

			if (is_string($item)) {
				if (!is_numeric($index) && !empty($this->getFieldByKey($fields, $index))) {
					$key = $index;
					$label = $item;
				} else {
					$key = $item;
				}

				$field = $this->getFieldByKey($fields, $key); // Ищем подробную информацию в списке полей
				if (!empty($field)) {
					$formField = $field; //["form"];
				} else {
					$k = is_numeric($index) ? "f" . $index : $index;
					$formField = ["key" => $k, "label" => $item];
					$sectionHeader = $item;
				}

				//MyLog::d("String");
			} else {
				//MyLog::d("No string");

			}

			if (!is_array($formField)) {
				$formField = ["key" => $key, "label" => $formField];
			}

			//MyLog::d($formField);

			if (empty($key)) {
				continue;
			}


			//			$field = $item["form"];
			$fieldId = $key . $counter;
			$dataList = $this->getFormParam($formField, "datalist");
			$controlType = 	$this->getFormParam($formField, "control", "textarea");
			if (!empty($sectionHeader)) {
?>
				<div class="col-12 title3 my-3"><?= $sectionHeader ?>
					<hr>
				</div>
				<?php
			} else {

				if (!empty($dataList)) {
					if (is_string($dataList)) {
						$dataListSrc = ":options=\"datalist['$dataList']\"";
					} else {
						$dataList = json_encode($dataList);
						$dataListSrc = " :options='$dataList'";
					}


					//MyLog::d($dataList);
				?>
					<div class="<?= $this->getFormParam($formField, "cols", $defaultCols) ?>">
						<b-form-group id="f<?= $fieldId ?>" description="<?= $this->getFormParam($formField, "description") ?>" label="<?= $label ? $label : $this->getFormParam($formField, "label") ?>" label-for="<?= $fieldId ?>" valid-feedback="<?= $this->getFormParam($formField, "success") ?>" invalid-feedback="<?= $this->getFormParam($formField, "error") ?>">
							<b-form-select id="<?= $fieldId ?>" v-model="<?= $jsFormPrefix ?>.<?= $key ?>" <?= $dataListSrc ?>></b-form-select>
						</b-form-group>
					</div>
					<?php
				} else {
					if ($controlType == 'textarea') {
					?>
						<div class="<?= $this->getFormParam($formField, "cols", $defaultCols) ?>">
							<b-form-group id="f<?= $fieldId ?>" description="<?= $this->getFormParam($formField, "description") ?>" label="<?= $label ? $label : $this->getFormParam($formField, "label") ?>" label-for="<?= $fieldId ?>" valid-feedback="<?= $this->getFormParam($formField, "success") ?>" invalid-feedback="<?= $this->getFormParam($formField, "error") ?>">
								<b-form-textarea id="<?= $fieldId ?>" v-model="<?= $jsFormPrefix ?>.<?= $key ?>" rows="3" max-rows="5">
									</b-form-input>
							</b-form-group>
						</div>
					<?php
					} else if ($controlType == 'input') {
					?>
						<div class="<?= $this->getFormParam($formField, "cols", $defaultCols) ?>">
							<b-form-group id="f<?= $fieldId ?>" description="<?= $this->getFormParam($formField, "description") ?>" label="<?= $label ? $label : $this->getFormParam($formField, "label") ?>" label-for="<?= $fieldId ?>" valid-feedback="<?= $this->getFormParam($formField, "success") ?>" invalid-feedback="<?= $this->getFormParam($formField, "error") ?>">
								<b-form-input id="<?= $fieldId ?>" v-model="<?= $jsFormPrefix ?>.<?= $key ?>"></b-form-input>
							</b-form-group>
						</div>
<?php
					} // Control type
				}
			} // if section or field



			$counter++;
		} // foreach
	}
}
