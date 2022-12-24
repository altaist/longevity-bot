<?php

namespace Expertix\Core\User;

use Expertix\Core\Db\DB;

class CompanyHelper
{
	const AGENCY_KEY_PARAM_NAME = "agencyId";
	public $affKeyParamName = self::AGENCY_KEY_PARAM_NAME;
	
	// Agency
	public function getUserAgencyId($userId)
	{
		$sql = "select agencyId from app_user_agency where userId=? order by created desc, updated desc";
		$agencyId = DB::getValue($sql, [$userId]);
		return $agencyId;
	}
	
	public function setUserAgencyId($userId, $agencyId){
		$sql = "REPLACE into app_user_agency (userId, companyId, updated) values(?, ?, NOW())";
		return DB::set($sql, [$userId, $agencyId]);
	}
	
	public function getAgencyListForUser($userId){
		$selectFields = " app_company.*, a_u_a.userId ";
		$sql = "select $selectFields from app_company inner join app_user_agency a_u_a where a_u_a.companyId=app_company.companyId and a_u_a.userId=? order by companyId desc";
		return DB::getRow($sql, [$userId]); 		
	}
	
	// Company
	public function getCompanyById($id){
		$selectFields = " * ";
		$sql = "select $selectFields from app_company where companyId=? order by companyId desc";
		return DB::getRow($sql, [$id]); 
	}
	
	public function getCompanyByKey($key)
	{
		$selectFields = " * ";
		$sql = "select $selectFields from app_company where companyKey=? order by companyId desc";
		return DB::getRow($sql, [$key]); 
	}

	public function getCompanyListFor($key)
	{
		$selectFields = " * ";
		$sql = "select $selectFields from app_company where companyKey=? order by companyId desc";
		return DB::getRow($sql, [$key]);
	}
	
	

}
