<?php
namespace Expertix\Core\Controller\File;

use Expertix\Core\Controller\Base\BaseController;
use Expertix\Core\App\Request;
use Expertix\Core\Db\DB;

class GetFileController extends BaseController{
	public function process(){
		$includePath = null;
		try {
			$path = Request::getRequestParam("key");
			if (!$path) {
				$path = $this->getPageData()->getObjectId();
			}

			$fileArr = $this->getFile($path, $this->getControllerConfig()->get("param_mime"));
			$fileName = $fileArr["fileName"];
			$mime = $fileArr["mime"];

			$includePath = PATH_UPLOADS . $fileName;
			//	echo ($includePath);
			if (!file_exists($includePath)) {
				//		http_response_code(404);
				//		exit;
				throw new \Exception("File not founded", 1);
			}
			header('Content-Type: ' . $mime . '; charset=utf-8');
			include $includePath;
			exit;
		
		} catch (\Throwable $th) {
			//throw $th;
			header("HTTP/1.0 404 Not Found");
			die();
		}

	}

	protected function getFile($key, $mimeType = null)
	{
		if (!$key) {
			throw new \Exception("Wrong file key", 1);
		}

		$row = DB::getRow("select * from app_file where fileKey=?", [$key]);

		if (!$row) {
			throw new \Exception("File not founded for key $key", 1);
		}

		$fileName = $row["fileName"];
		$mime = $row["mime"];
		if($mimeType && $mime!=$mimeType){
			throw new \Exception("Wrong mime type for a key=$key", 1);
		}
		
		return $row;
	}
}





