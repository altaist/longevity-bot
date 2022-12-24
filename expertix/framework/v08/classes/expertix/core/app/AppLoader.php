<?php
namespace Expertix\Core\App;

use Expertix\Core\Config\Config;
use Expertix\Core\Auth\{AuthManager};

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Db\DB;

use Expertix\Core\Exception\AppInitException;

use Expertix\Core\Util\Email\EmailHelper;
use Expertix\Core\Util\Log;

class AppLoader{
	private $app;
	private $config;
	private $router;
	private $authManager;
	private $emailManager;
		
	public function buildApp(){
		$this->app = new App();
		AppContext::setApp($this->app);
		$this->setupApp();
		return $this->app;
	}
	public function buildSimpleApp()
	{
		$this->app = new AppSimple();
		AppContext::setApp($this->app);
		$this->setupAppSimple();
		return $this->app;
	}
	protected function setupApp(){
		$this->setupConfig();
		//echo ("AppBase onCreate<br>");
		//print_r ($this->config->getRouterConfig()->getArray());
		//exit;
		$this->setupLog();
		$this->setupRouter();
		$this->setupDb();
		//$this->setupAuthManager();
		$this->setupEmailManager();

		$this->app->setConfig($this->config);
		$this->app->setRouter($this->router);
		//$this->app->setAuthManager($this->authManager);
		
		$this->app->setupModules();

		AppContext::setConfig($this->config);
		AppContext::setEmailManager($this->emailManager);
		
	}
	protected function setupAppSimple(){
		$this->setupConfig();
		$this->setupLog();
		$this->setupRouter();

		$this->app->setConfig($this->config);
		$this->app->setRouter($this->router);
		$this->app->setupModules();
		
		AppContext::setConfig($this->config);
	}

	protected function setupConfig()
	{
		$this->config = new Config(PATH_CONFIG);
	}


	protected function setupRouter()
	{
		$this->router = new Router();
	}
	protected function setupLog()
	{
		Log::setup($this->config->isDebugMode());
	}
	protected function setupDb()
	{
		$sql_details = $this->config->getDbConfig();
		//MyLog::d($sql_details);

		if ($sql_details == NULL) {
//			throw new AppInitException('App: Database config is empty!', 0);
			return;
		}
		DB::connect($sql_details);
	}
	
	protected function setupEmailManager(){
		$this->emailManager = new EmailHelper($this->config->getSubConfig("email"));
		//$this->emailManager->send("localhost", "subject", "body");
	}
	
	public static function createObject($class, $params = null){
		return new $class($params);
		try {
			
		} catch (\Throwable $th) {
		}
		return null;
	}

}