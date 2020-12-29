<?php

class Business_Signin_UserLogin {

	public function CheckUserLogin($userName, $password) {
		$signin = new System_Admin_Signin ();
		$adminUserId = $signin->CheckUser ( $userName, $password );
		if ($adminUserId > 0) {
			$token = Func::RandomCode ( 36 );
			$adminUser = new System_Admin_User ( $adminUserId );
			if (! is_null ( $adminUser )) {
				$adminUser->SetToken ( $token );
			}
			$adminUser->Save ();

			$userObject = Object_User_Indexing::GetUserObejctFromAdminUserId ( $adminUserId );
			
			return $userObject;
		}
		return null;
	}
}