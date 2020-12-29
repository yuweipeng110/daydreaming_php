<?php

class Business_Webpage_Signin extends Data_Explain {

	/**
	 * 登陆验证
	 *
	 * @param string $userName        	
	 * @param string $password        	
	 * @return boolean
	 */
	public function LoginCheck($userName, $password) {
		$result = false;
		$resultCode = 0;
		$data = array ();
		
		if (isset ( $userName ) && isset ( $password )) {
			$signin = new Business_Signin_UserLogin ();
			$userObject = $signin->CheckUserLogin ( $userName, $password );
			if (! is_null ( $userObject )) {
				$userId = $userObject->GetId ();
				$userToken = $userObject->GetSystemUser ()->GetToken ();
				
				$userData = Business_User_Tool::GetUserFieldData ( $userId );
				$tokenData = array (
						'userToken' => $userToken 
				);
				$data = array_merge ( $userData, $tokenData );
				
				$resultCode = Business_Webpage_Message::SUCCESS;
				$result = true;
			} else {
				$resultCode = Business_Webpage_Message::CHECK_ERROR;
			}
		} else {
			$resultCode = Business_Webpage_Message::PARAMETER_ERROR;
		}
		$resultMessage = Business_Webpage_Message::getMessage ( $resultCode );
		
		$this->SetCode ( $resultCode );
		$this->SetMessage ( $resultMessage );
		$this->SetData ( $data );
		
		return $result;
	}

	/**
	 * 登陆TOKEN验证
	 *
	 * @param string $token        	
	 * @return boolean
	 */
	public function LoginTokenCheck($token) {
		$result = false;
		$resultCode = 0;
		$data = array ();
		if (isset ( $token )) {
			$adminUserObject = System_Admin_Indexing::GetTokenObejctFromAdminUserToken ( $token );
			if (! is_null ( $adminUserObject )) {
				$userObject = Object_User_Indexing::GetUserObejctFromAdminUserId ( $adminUserObject->GetId () );
				
				if (! is_null ( $userObject )) {
					$userId = $userObject->GetId ();
					$userToken = $userObject->GetSystemUser ()->GetToken ();
					
					$userData = Business_User_Tool::GetUserFieldData ( $userId );
					$tokenData = array (
							'userToken' => $userToken 
					);
					$data = array_merge ( $userData, $tokenData );
					
					$resultCode = Business_Webpage_Message::SUCCESS;
					$result = true;
				} else {
					$resultCode = Business_Webpage_Message::CHECK_ERROR;
				}
			} else {
				$resultCode = Business_Webpage_Message::CHECK_ERROR;
			}
		} else {
			$resultCode = Business_Webpage_Message::PARAMETER_ERROR;
		}
		$resultMessage = Business_Webpage_Message::getMessage ( $resultCode );
		
		$this->SetCode ( $resultCode );
		$this->SetMessage ( $resultMessage );
		$this->SetData ( $data );
		
		return $result;
	}
}