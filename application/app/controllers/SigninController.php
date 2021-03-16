<?php
header ( "Content-type:text/html;charset=utf-8" );

class App_SigninController extends Custom_Webpage {

	/**
	 * 登陆验证
	 */
	public function loginCheckAction() {
		$userName = $this->data ['userName'];
		$password = $this->data ['password'];
		
		$signin = new Business_Webpage_Signin ();
		$signin->LoginCheck ( $userName, $password );
		
		$message = array (
				"code" => $signin->GetCode (),
				"msg" => $signin->GetMessage (),
				"data" => $signin->GetData (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function loginTokenCheckAction() {
		$token = $this->data ['token'];
		
		$signin = new Business_Webpage_Signin ();
		$signin->LoginTokenCheck ( $token );
		
		$message = array (
				"code" => $signin->GetCode (),
				"msg" => $signin->GetMessage (),
				"data" => $signin->GetData (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}
}