namespace #NAMESPACE;

use Expertix\Core\Db\DB;
use Expertix\Core\Data\BaseModel;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class #CLASSNAME extends BaseModel
{	
	function __construct()
	{
		$this->tableName = "#TABLENAME";
		$this->dataType = "#DATATYPE";
		$this->keyField = "#KEYFIELD";
	}
	
	
	public function getCrudObject($key, $user=null)
	{
		return $this->getObject($key);
	}
	public function getCrudCollection($query, $user=null)
	{
		return $this->getCollection($query);
	}
