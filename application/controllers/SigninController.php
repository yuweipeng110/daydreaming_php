<?php
header ( "Content-type:text/html;charset=utf-8" );

class SigninController extends Zend_Controller_Action {

	public function init() {
		parent::init ();
		$this->_helper->viewRenderer->setNoRender ();
		$this->application = new Zend_Session_Namespace ( "application" );
		$this->application->setExpirationSeconds ( 86400 );
	}
	// ---------------------------------------------------------------------------------------------
	public function loginAction() {
		var_dump(Format::FormatStreamEncrypt("admin123!@#"));
		$userName = "admin";
		$password = "admin";
				$signin = new System_Admin_Signin ();
		$Id = $signin->CheckUser ( $userName, $password );
		var_dump($userName);
		var_dump($password);
		var_dump($Id);
		$this->render ( "login" );
	}

	public function loginCheckProcessAction() {
		if ($this->_getParam ( "act", null ) == "login") {
			$userName = $this->_getParam ( "username", null );
			$password = $this->_getParam ( "password", null );
			$vcode = $this->_getParam ( "vcode", null );
			if (( string ) $vcode == ( string ) $_SESSION ['VCODE']) {
				$signin = new System_Admin_Signin ();
				$Id = $signin->CheckUser ( $userName, $password );
				if ($Id > 0) {
					$user = new System_Admin_User ( $Id );
					$this->application->manager ["Id"] = $user->GetId ();
					$this->application->manager ["theme"] = $user->GetTheme ();
					
					$arrayData = array (
							"code" => 1,
							"msg" => "登录成功" 
					);
					echo JsonData::ArrayToJson ( $arrayData );
					exit ();
				} else {
					$arrayData = array (
							"code" => - 2,
							"msg" => "您输入的帐号不存在或已被禁用，请与管理员联系！" 
					);
					echo JsonData::ArrayToJson ( $arrayData );
					exit ();
				}
			} else {
				$arrayData = array (
						"code" => - 1,
						"msg" => "验证码错误，请重试！" 
				);
				echo JsonData::ArrayToJson ( $arrayData );
				exit ();
			}
		}
	}

	private function getFirstElementByTagName($tagName) {
		if ($this->dom->getElementsByTagName ( $tagName )->length > 0) {
			return $this->dom->getElementsByTagName ( $tagName )->item ( 0 )->nodeValue;
		} else {
			return null;
		}
	}

	public function loginExeAction() {
		$this->alert = new Alert ();
		$stream = file_get_contents ( "php://input" );
		if (strlen ( $stream ) == 0) {
			$stream = $_REQUEST ['data'];
		}
		$this->dom = XmlData::LoadDecryption ( $stream );
		if ($this->dom) {
			$now = sprintf ( "%.0f", Func::GetMillisecond () / 1000 );
			$timestamp = ( int ) $this->getFirstElementByTagName ( "TIMESTAMP" );
			$timeResult = $now - $timestamp;
			if ($timeResult > - 1 * $this->timeout && $timeResult < 1 * $this->timeout) {
				// SUCCESS
				// CONTINUE
			} else {
				$message = array (
						"error" => "TIMESTAMP ERROR",
						"time" => date ( 'Y-m-d H:i:s' ) 
				);
				echo XmlData::ResultEncryption ( $message );
				exit ();
			}
		} else {
			$message = array (
					"error" => "PARAMETER_ERROR",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo XmlData::ResultEncryption ( $message );
			exit ();
		}
		
		$act = $this->getFirstElementByTagName ( "COMMAND" );
		if ($act == "LOGIN") {
			$userName = $this->getFirstElementByTagName ( "USERNAME" );
			$password = $this->getFirstElementByTagName ( "PASSWORD" );
			
			$signin = new System_Admin_Signin ();
			$id = $signin->CheckUser ( $userName, $password );
			if ($id > 0) {
				$user = new System_Admin_User ( $id );
				$this->application->manager ["Id"] = $user->GetId ();
				$this->application->manager ["theme"] = $user->GetTheme ();
				
				$message = array (
						"success" => "LOGIN_SUCCESS",
						"time" => date ( 'Y-m-d H:i:s' ) 
				);
				echo XmlData::ResultEncryption ( $message );
				exit ();
			} else {
				$message = array (
						"error" => "LOAD_NULL",
						"time" => date ( 'Y-m-d H:i:s' ) 
				);
				echo XmlData::ResultEncryption ( $message );
				exit ();
			}
		} else {
			$message = array (
					"error" => $this->alert->Messsage ( 'LOGIN_ERROR' ),
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo XmlData::ResultEncryption ( $message );
			exit ();
		}
	}
}