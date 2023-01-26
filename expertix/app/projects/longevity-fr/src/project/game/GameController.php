<?php
namespace Project\Game;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\DB;
use Expertix\Core\Util\Log;

class GameController extends BaseApiController{
	
	function onCreate()
	{
		$this->addRoute("energy_get", "energyGet", 1);
		$this->addRoute("energy_set", "energySet", 1);
		$this->addRoute("energy_change", "energyChange", 1);
		$this->addRoute("refill", "energyRefill", 0);
		
		$this->addRoute("user_activity_update", "userActivityUpdate", 1);
		$this->addRoute("user_report", "getMedData", 1);
		
		
	}

	public function energyGet($request)
	{
		$user = $this->getUser();
		$personId = $user->get("personId");
		return $this->getUserEnergy($personId);
	}

	public function energySet($request){
		return $this->energyUpdate($request, 0);
	}
	public function energyChange($request)
	{
		return $this->energyUpdate($request, 1);
	}
	
	public function energyRefill($request){
		DB::set("update app_person set energy=energy+25");
		DB::set("update app_person set energy=100 where energy>100");
	}
	
	protected function getUserEnergy($personId)
	{
		return DB::getValue("select energy from app_person where personId=?", [$personId]);
	}
	protected function getUserRatingAndEnergy($personId)
	{
		return DB::getRow("select energy, rating1, rating2, rating3 from app_person where personId=?", [$personId]);
	}
	protected function energyUpdate($request, $action=0){
		$energy = $request->get("energy");
		$energyVal = abs($energy);
		
		$user = $this->getUser();
		$personId = $user->get("personId");
		$params = [$energyVal, $personId];
		if($action){
			DB::set("update app_person set energy=energy-(?) where personId=?", $params);
		}else{
			DB::set("update app_person set energy=? where personId=?", $params);			
		}
		DB::set("update app_person set energy=0 where energy<0");
		return $this->getUserRatingAndEnergy($personId);
	}

	protected function userActivityUpdate($request, $action = 0)
	{
		Log::d("userActivityUpdate", $request->getArray());
		$user = $this->getUser();
		$userRating = $user->get("rating", 0);
		$personId = $user->get("personId");
		$userId = $user->get("userId");
		
		$rating1 = $request->get("rating", 0);
		$userRating += $rating1;

		$medData = $request->getWrapper("medData");
		if($medData->getArray()){
			$this->saveMedData1($userId, $medData);
		}
		
		$sql= "update app_person set rating1=rating1+? where personId=?";
		DB::set($sql, [$rating1, $personId], "userActivityUpdate");
		return $this->energyChange($request);
	}
	
	
	private function saveMedData1($userId,$request){
		$temperature = $request->getAndCheckInRange("temperature", 35, 41, null, "Wrong temperature");
		$pressure1 = $request->getAndCheckInRange("pressure1", 70, 200, null, "Wrong pressure");
		$pressure2 = $request->getAndCheckInRange("pressure2", 30, 150, null, "Wrong pressure");
		$glucose = $request->getAndCheckInRange("glucose", 1, 50, null, "Wrong glucose");
		$saturation = $request->getAndCheckInRange("saturation", 60, 100, null, "Wrong saturation");
		
		$params = [$userId, $temperature, $pressure1, $pressure2, $glucose, $saturation];
		
		$sql = "insert into form_med_1 (userId, temperature, pressure1, pressure2, glucose, saturation) values(?,?,?,?,?,?)";
		return DB::set($sql, $params);
	}
	
	public function getMedData($request){
		$userId = $this->getUserId();
		$sql = "select * from form_med_1 where userId=?";
		return DB::getAll($sql, [$userId]);
	}
	
	
}