<?php
header ( "Content-type:text/html;charset=utf-8" );
class Service_SigninController extends Zend_Controller_Action {
	private $json = "";
	private $data = array ();
	public function init() {
		parent::init ();
		$this->json = JsonData::LoadNotDecrypt ( file_get_contents ( "php://input" ) );
		if ($this->json) {
			$this->data = Zend_Json::decode ( $this->json );
			// SESSION OK
		}
		// else {
		// $message = array (
		// "code" => 10400,
		// "msg" => 'PARAMETER_ERROR' ,
		// "time" => date ( 'Y-m-d H:i:s' )
		// );
		// echo JsonData::ResultNotEncrypt ( $message );
		// exit ();
		// }
	}
	
	/**
	 * 登陆验证
	 */
	public function loginAction() {
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
}