<?php

namespace Expertix\Core\Util\Upload;

use Expertix\Core\Data\BaseModel;
use Expertix\Core\Db\DB;
use Expertix\Core\Util\UUID;

class FileModel extends BaseModel{
	function addFile($user, $uploader)
	{
		$name = $uploader->getUploadName();
		if(!$name){
			throw new \Exception("FileModel.addFile: wrong name", 0);
		}
		$ext = $uploader->getExtention() or "";
		$fileId = UUID::gen_uuid();
		$sql = "insert into file(fileId, name, ext) values(?,?,?)";
		DB::add($sql, [$fileId, $name, $ext]);
	}
	function deleteFile($user, $request)
	{
	}
	function getFile()
	{
	}

}