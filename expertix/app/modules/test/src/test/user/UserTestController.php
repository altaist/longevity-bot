<?php
namespace Test\User;


use Expertix\Core\Test\BaseTestController;
use Expertix\Core\User\AuthPolicy;
use Expertix\Core\User\BaseUserFactory;
use Expertix\Core\User\UserManager;
use Expertix\Core\User\UserManagerAdmin;
use Expertix\Core\Util\ArrayWrapper;

class UserTestController extends BaseTestController{
	private $userManager = null;
	private $userManagerAdmin = null;
	
	public function prepare(){
		$this->userManager = new UserManager(new BaseUserFactory(), new AuthPolicy());
		$this->userManagerAdmin = new UserManagerAdmin(new BaseUserFactory(), new AuthPolicy());
		
	}
	
	public function run(){
		$userManager = $this->userManager;
		$adminManager = $this->userManagerAdmin;
		
		// Create
		//$user1 = $adminManager->createUser("User1");
		$user2 = $adminManager->createUser(new ArrayWrapper(["name"=>"User2", "login"=>"@user2", "password"=>"123", "email"=>"@user2"]));
		$user3 = $adminManager->createUser(new ArrayWrapper(["name"=>"User3", "login"=>"@user2", "email"=>"@user2"]));
		return;
				
		$adminManager->createUserWithPassword();
		$adminManager->createUserWith();

		// Update
		$adminManager->changeEmail($user3, "email");
		$adminManager->changeEmailWithLogin($user1, "email");

		$adminManager->updateUser($user2, []);

		// Auth
		$userManager->authBySession();
		
		$userManager->authByEmailCodeStep1("@user2");
		$userManager->authByEmailCodeStep2("123");

		$userManager->authByPassword("@user2", "1234");
		$userManager->authByPassword("@user2", "123");
		$userManager->authByLink("nimbda");
		//$userManager->authByVk();

		
	}
	

	
	
	
	public function run2(){
		$userHelper = new UserHelper();
		$userArray = $this->createTestUser("Имя", "Фамилия", "email", "tel", "user1", "password1", "oauth1", null);

		$this->deleteUsers();
		$user = $userHelper->signUp($userArray, 0, 0);
		$this->deleteUsers();
		$user = $userHelper->signUpByOAuth($userArray, 0, 0);
		$this->deleteUsers();
		$user = $userHelper->signUpByLogin($userArray, 0, 0);

		$this->print("Имя", $user["firstName"]);
		$this->assertEquals($user["firstName"], "Имя");
		
	}
	private function deleteUsers(){
		DB::set("delete from users");
		DB::set("delete from auth");
	}
	
	private function createTestUser($firstName, $lastName, $email, $tel, $login, $password, $oauthId, $authLink){
		$user = [];
		$user["firstName"] = $firstName;
		$user["lastName"] = $lastName;
		$user["email"] = $email;
		$user["tel"] = $tel;
		$user["login"] = $login;
		$user["password"] = $password;
		$user["oauthId"] = $oauthId;
		$user["authLink"] = $authLink;
		return $user;
	}
	private function createFullTestUserArray()
	{
		$user = [];
		$user["firstName"] = "FirstName";
		$user["lastName"] = "LastName";
		$user["middleName"] = "MiddleName";
		$user["firstName"] = "FirstName";
		return $user;
	}
	
	
}