<?php

use Expertix\Core\Db\DB;
use Expertix\Core\Util\UUID;

$user = $pageData->getUser();
$userId = $user?$user->getId():null;
uploadFiles($userId);
function uploadFiles($userId)
{
	//print_r($_FILES);
	$uploadedKeys = [];
	try {
		foreach ($_FILES as $fileName => $value) {
			//echo "Start uploading ${fileName} <br>";
			$uploadedKeys[] = uploadFile($fileName, $userId);
		}
	} catch (RuntimeException $e) {
		header('Content-Type: text/plain; charset=utf-8');
		http_response_code(400);
		echo json_encode(["error" => $e->getMessage()]);
		exit;
	}

	header('Content-Type: text/plain; charset=utf-8');
	echo json_encode(["error"=>"", "keys"=> $uploadedKeys]);
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
		throw new RuntimeException('Invalid parameters.');
	}

	// Check $_FILES[$fileName]['error'] value.
	switch ($_FILES[$fileName]['error']) {
		case UPLOAD_ERR_OK:
			break;
		case UPLOAD_ERR_NO_FILE:
			throw new RuntimeException('No file sent.');
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
			throw new RuntimeException('Exceeded filesize limit.');
		default:
			throw new RuntimeException('Unknown errors.');
	}

	// You should also check filesize here.
	if ($_FILES[$fileName]['size'] > 1000000) {
		throw new RuntimeException('Exceeded filesize limit.');
	}

	// DO NOT TRUST $_FILES[$fileName]['mime'] VALUE !!
	// Check MIME Type by yourself.
	$finfo = new finfo(FILEINFO_MIME_TYPE);
	if (false === $ext = array_search(
		$finfo->file($_FILES[$fileName]['tmp_name']),
		array(
			'jpg' => 'image/jpeg',
			'png' => 'image/png',
			'gif' => 'image/gif',
		),
		true
	)) {
		throw new RuntimeException('Invalid file format.');
	}

	// You should name it uniquely.
	// DO NOT USE $_FILES[$fileName]['name'] WITHOUT ANY VALIDATION !!
	// On this example, obtain safe unique name from its binary data.
	$destDir = PATH_UPLOADS;
	$fileKey = UUID::gen_uuid();
	$userId = $userId;
	$fileNameNew = $fileKey.".".$ext;
	$fileNameSrc = htmlspecialchars(strip_tags($_FILES[$fileName]['name']));
	$mime = mime_content_type($_FILES[$fileName]['tmp_name']);
	
	if (!move_uploaded_file(
		$_FILES[$fileName]['tmp_name'],
		sprintf(
			$destDir.'%s',
			$fileNameNew
		)
	)) {
		throw new RuntimeException('Failed to move uploaded file.');
	}
	
	$sql = "insert into app_file (fileKey, userId, fileName, ext, mime, fileNameSrc) values(?,?,?,?,?,?)";
	$fileId = DB::add($sql, [$fileKey, $userId, $fileNameNew,  $ext,$mime,  $fileNameSrc]);
	
	return $fileKey;


}
