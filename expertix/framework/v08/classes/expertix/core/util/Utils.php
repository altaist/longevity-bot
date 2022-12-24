<?php
namespace Expertix\Core\Util;

class Utils
{
	static function isEmpty($paramsArr, $key)
	{
		if (!isset($paramsArr[$key])) {
			return true;
		}
		$val = $paramsArr[$key];
		if (is_array($val)) return false;
		if (is_numeric($val) && $val == 0) return false;
		//		if ($val == null || $val . "" == "") return true;
		if (empty($val)) return true;
		return false;
	}
	static function getParam($paramsArr, $key, $defaultValue)
	{
		if (self::isEmpty($paramsArr, $key)) {
			return $defaultValue;
		}
		return $paramsArr[$key];
	}
	static function getParamStrong($paramsArr, $key, $message = null)
	{
		$param =  self::getParam($paramsArr, $key, null);
		if ($param === null) {
			$message = $message ? $message : "Отсутствует параметр $key";
			throw new \Exception($message, 1);
		}
		return $param;
	}
	static function checkRequest($request, $fieldsArr, $message = "")
	{
		if (!is_array($fieldsArr)) {
			$field = $fieldsArr;
			if (self::isEmpty($request, $field)) {
				throw new \Exception($message ? $message : "Empty request field $field", 1);
			}
			return;
		}
		foreach ($fieldsArr as $field) {
			if (self::isEmpty($request, $field)) {
				throw new \Exception($message ? $message : "Empty request field $field", 1);
			}
		}
	}


	static function arrayWrapperClass($arr)
	{
		return new ArrayWrapper($arr);
	}

	static function getValue($val, $default = null)
	{
		if (empty($val)) {
			return $default;
		}
		return $val;
	}
	static function getArrValue($arr, $key, $default = null)
	{
		if (empty($arr) || !is_array($arr)) {
			return $arr;
		}

		if (empty($arr[$key])) {
			return $default;
		}
		return $arr[$key];
	}
	static function getArrValue2($arr, $key, $key2,  $default = null)
	{
		if (empty($arr) || !is_array($arr)) {
			return $arr;
		}

		if (empty($arr[$key])) {
			if (empty($arr[$key2])) {
				return $default;
			} else {
				return $arr[$key2];
			}
		}
		return $arr[$key];
	}
	static function subArray($src, $fields, $default = "", $ignoreEmpty = false)
	{
		return self::fillArray($src, $fields, $default, $ignoreEmpty);
	}
	static function fillArray($src, $fields, $default = "", $ignoreEmpty = false)
	{
		$arr = [];
		foreach ($fields as $field) {
			if (!empty($src[$field])) {
				$arr[$field] = 	$src[$field];
			} else {
				if (!$ignoreEmpty && $default != null) {
					$arr[$field] = $default;
				}
			}
		}
		return $arr;
	}

	static function arrayWrapper($arr)
	{
		$arr = $arr;
		return function ($name) use ($arr) {
			return isset($arr[$name]) ? $arr[$name] : null;
		};
	}
	
	static function mergeArrays($array1, $array2, $isRecursive = false){
		if(!is_array($array1) || !is_array($array2)){
			return [];
		}
		$result = [];
		foreach ($array1 as $key1 => $value1) {
			$result[$key1] = $value1;
		}
		
		foreach ($array2 as $key2 => $value2) {
			$value1 = empty($array1[$key2]) ? null: $array1[$key2];

			if (is_array($value1) && is_array($value2) && $isRecursive) {
				$result[$key2] = self::mergeArrays($value1, $value2, $isRecursive);
			} else {
				$result[$key2] = $value2;
			}
		}
		return $result;
	}
	static function testSpeed(){
		// Create an array of arrays
		$chars = [];
		for ($i = 0; $i < 1500; $i++) {
			$chars[] = array_fill(0, 10, 'a');
		}
		// test foreach
		$new = [];
		$start = microtime(TRUE);
		foreach ($chars as $splitArray) {
			foreach ($splitArray as $value) {
				$new[] = $value;
			}
		}
		echo microtime(true) - $start . "<br>"; // => 0.00900101 sec

		// test array_merge
		$new = [];
		$start = microtime(TRUE);
		foreach ($chars as $splitArray) {
			//			$new = array_merge($new, $splitArray);
			Utils::mergeArrays($new, $splitArray);
		}
		echo microtime(true) - $start . "<br>"; // => 14.61776 sec
		echo "<br>";
		// ==> 1600 times faster
		// test array_merge
		$new = [];
		$start = microtime(TRUE);
		foreach ($chars as $splitArray) {
			$new = array_merge($new, $splitArray);
		}
		echo microtime(true) - $start; // => 14.61776 sec
		echo "<br>";
		// ==> 1600 times faster
	}
	static function elipsis($string, $length, $stopanywhere = false)
	{
		//truncates a string to a certain char length, stopping on a word if not specified otherwise.
		if (strlen($string) > $length) {
			//limit hit!
			$string = substr($string, 0, ($length - 3));
			if ($stopanywhere) {
				//stop anywhere
				$string .= '...';
			} else {
				//stop on a word.
				$string = substr($string, 0, strrpos($string, ' ')) . '...';
			}
		}
		return $string;
	}

	/**
	 *    Return an elipsis given a string and a number of words
	 */
	static function elipsisByWords($text, $words = 30)
	{
		return $text;
		// Check if string has more than X words
		if (str_word_count($text) > $words) {

			// Extract first X words from string
			preg_match("/(?:[^\s,\.;\?\!]+(?:[\s,\.;\?\!]+|$)){0,$words}/", $text, $matches);
			$text = trim($matches[0]);

			// Let's check if it ends in a comma or a dot.
			if (substr($text, -1) == ',') {
				// If it's a comma, let's remove it and add a ellipsis
				$text = rtrim($text, ',');
				$text .= '...';
			} else if (substr($text, -1) == '.') {
				// If it's a dot, let's remove it and add a ellipsis (optional)
				$text = rtrim($text, '.');
				$text .= '...';
			} else {
				// Doesn't end in dot or comma, just adding ellipsis here
				$text .= '...';
			}
		}
		// Returns "ellipsed" text, or just the string, if it's less than X words wide.
		return $text;
	}
	
	static function text2html($text, $autoBr="<br>"){
		$result = $text;
		if ($autoBr == "<br>") {
			$result = str_replace("\n", $autoBr, $text);
		} else if ($autoBr == "<p>") {
			$result = "<p>" . str_replace("\n", "</p>" . $autoBr, $text) . "</p>";
		}
		return $result;
	}
	
	
	static function getIncludedContent($filename)
	{
		if (is_file($filename)) {
			ob_start();
			include $filename;
			return ob_get_clean();
		}
		return false;
	}

	// DateTime
	static function now()
	{
		return date('Y-m-d H:i:s');
		//		$result = (new DateTime())->format('Y-m-d');
		//		return $result;
	}
}