<?php

namespace Expertix\Core\Util\Upload;

use Exception;
use Expertix\Core\Db\DB;
use Expertix\Core\Exception\AppException;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\User\UserModel;
use Expertix\Core\User\UserModelAdmin;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\UUID;
use PDO;

class UploadManager
{

	function uploadImgForObject($userId, $objectTable, $objectId, $objectIdField)
	{
		$this->uploadFiles($userId, $objectTable, $objectId, $objectIdField);
	}


	function uploadFiles($userId, $objectTable = null, $objectId = null, $objectIdField = null)
	{
		//print_r($_SERVER); exit;
		$uploadedKeys = [];
		try {
			foreach ($_FILES as $fileName => $value) {
				//echo "Start uploading ${fileName} <br>";
				$key = $this->uploadFile($fileName, $userId);
				$uploadedKeys[] = $key;

				if ($objectTable) {
					$this->updateImgForRow($objectTable, $objectId, $objectIdField, $key);
				}
			}
		} catch (\RuntimeException $e) {
			$this->sendError($e);
		}

		header('Content-Type: text/plain; charset=utf-8');
		echo json_encode(["error" => "", "keys" => $uploadedKeys]);
		exit;
	}
	protected function sendError($e)
	{
		header('Content-Type: text/plain; charset=utf-8');
		http_response_code(400);
		echo json_encode(["error" => $e->getMessage()]);
		exit;
	}

	function uploadFile($fileName, $userId)
	{

		// Undefined | Multiple Files | $_FILES Corruption Attack
		// If this request falls under any of them, treat it invalid.
		if (
			!isset($_FILES[$fileName]['error']) ||
			is_array($_FILES[$fileName]['error'])
		) {
			throw new \RuntimeException('Invalid parameters.');
		}

		// Check $_FILES[$fileName]['error'] value.
		switch ($_FILES[$fileName]['error']) {
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_NO_FILE:
				throw new \RuntimeException('No file sent.');
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				throw new \RuntimeException('Exceeded filesize limit.');
			default:
				throw new \RuntimeException('Unknown errors.');
		}

		// You should also check filesize here.
		if ($_FILES[$fileName]['size'] > 1000000) {
			throw new \RuntimeException('Exceeded filesize limit.');
		}

		// DO NOT TRUST $_FILES[$fileName]['mime'] VALUE !!
		// Check MIME Type by yourself.
		$finfo = new \finfo(FILEINFO_MIME_TYPE);
		//print_r($finfo->file($_FILES[$fileName]['tmp_name']));
		if (false === $ext = array_search(
			$finfo->file($_FILES[$fileName]['tmp_name']),
			array(
				'jpg' => 'image/jpeg',
				'png' => 'image/png',
				'gif' => 'image/gif',
				'pdf' => 'application/pdf',
				'txt' => 'text/plain'
			),
			true
		)) {
			throw new \RuntimeException('Invalid file format.');
		}

		// You should name it uniquely.
		// DO NOT USE $_FILES[$fileName]['name'] WITHOUT ANY VALIDATION !!
		// On this example, obtain safe unique name from its binary data.
		$destDir = PATH_UPLOADS;
		$fileKey = UUID::gen_uuid();
		$userId = $userId;
		$fileNameNew = $userId . "_" . $fileKey . "." . $ext;
		$fileNameSrc = htmlspecialchars(strip_tags($_FILES[$fileName]['name']));
		$mime = mime_content_type($_FILES[$fileName]['tmp_name']);

		// Moving file
		if (!move_uploaded_file(
			$_FILES[$fileName]['tmp_name'],
			sprintf(
				$destDir . '%s',
				$fileNameNew
			)
		)) {
			throw new \RuntimeException('Failed to move uploaded file.');
		}

		$sql = "insert into app_file (fileKey, userId, fileName, ext, mime, fileNameSrc) values(?,?,?,?,?,?)";
		$fileId = DB::add($sql, [$fileKey, $userId, $fileNameNew,  $ext, $mime,  $fileNameSrc]);

		return $fileKey;
	}

	public function removeResource($key)
	{
		//Log::d("Remove resource: $key");
		
		$fileInfo = $this->getFileInfo($key);
		if (!$fileInfo) {
			throw new AppException("Неверный идентификатор файла", 1, "Ошибка получения информации о файле по ключу $key");
		}

		if(!$fileInfo->get("fileName")){
			return false;
		}

		$uploadDir = PATH_UPLOADS;
		$filePath = $uploadDir . $fileInfo->get("fileName");
		if (!file_exists($filePath)) {
			throw new AppException("Неверный идентификатор файла", 1, "Неверный пусть к файлу по ключу $key");
		}
		//Log::d("Unlinking file: $filePath");

		if (!unlink($filePath)) {
			throw new AppException("Ошибка удаления файла", 1, "Ошибка удаления файла по ключу $key");
		}
		
		$res = DB::set("delete from app_file where fileKey=?", [$key]);
	
		return true;
	}

	protected function getFileInfo($key)
	{
		$sql = "select * from app_file where fileKey=?";
		$result = DB::getRow($sql, [$key]);
		return new ArrayWrapper($result);
	}

	public function updateImgForRow($objectTable, $objectId, $objectIdField, $fileKey)
	{
		//$oldKey = DB::getValue("select img from ? where ?=?", [$objectTable, $objectIdField, $objectId]);
		$oldKey = DB::getValue("select img from $objectTable where $objectIdField=?", [$objectId]);
		if($oldKey){
			$this->removeResource($oldKey);
		}
				
		$sql = "update $objectTable set img=? where $objectIdField=?";
		//Log::d($sql);
		return DB::set($sql, [$fileKey, $objectId]);
	}
}
