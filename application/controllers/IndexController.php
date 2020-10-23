<?php

class IndexController extends Zend_Controller_Action {

	public function init() {
		$this->_helper->viewRenderer->setNoRender ();
		/* Initialize action controller here */
	}

	private function getMenuList(System_Admin_User $user) {
		$selfMenu = array ();
		
		if ($user->GetId () > 1) {
			// 用户所属分组所有权限
			$groupCongregation = new System_Admin_Congregation ( $user );
			foreach ( $groupCongregation->GetItems () as $valueCongregation ) {
				$groupRelation = new System_Admin_Purview ( $valueCongregation->GetOrganize () );
				foreach ( $groupRelation->GetMenus () as $valueMenu ) {
					$selfMenu [] = $valueMenu->GetId ();
				}
			}
			
			$userRelation = new System_Admin_Relation ( $user );
			foreach ( $userRelation->GetMenus () as $valueMenu ) {
				$selfMenu [] = $valueMenu->GetId ();
			}
			
			print_r ( $selfMenu );
		} else {
			
			$group = new System_Admin_Group ();
			foreach ( $group->GetItems () as $value ) {
				$selfMenu [] = $this->GetMenuField ( $value,$value->GetChildren() );
			}
		}
		
		print_r ( $selfMenu );
	}

	public function indexAction() {
		$user = new Business_User_Boss_Base(1);
		print_r($user->GetMenuList());
		die ( 'x' );
		
		$storeId = 2;
		$storeName = '白日梦';
		$status = true;
		$address = '回龙观';
		
		$store = new Business_Webpage_Store ();
		$re = $store->EditStore ( $storeId, $storeName, $status, $address );
		var_dump ( $re );
		$message = array (
				"code" => $store->GetCode (),
				"msg" => $store->GetMessage (),
				"data" => $store->GetData (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
		
		$this->render ();
	}

	public function testAction() {
		$t1 = microtime ( true );
		// ... 执行代码 ...

		$nickname = "";
		$phone = "80";
		
		$playerList = Business_User_List::SearchPlayerList ( $nickname, $phone );
		print_r($playerList);
		
		$t2 = microtime ( true );
		echo '耗时' . round ( $t2 - $t1, 10 ) . '秒<br>';
		echo 'Now memory_get_usage: ' . memory_get_usage () . '<br />';
	}

	protected function curl($url, $postFields = null) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_FAILONERROR, false );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		
		$postBodyString = "";
		$encodeArray = Array ();
		$postMultipart = false;
		
		if (is_array ( $postFields ) && 0 < count ( $postFields )) {
			
			foreach ( $postFields as $k => $v ) {
				if ("@" != substr ( $v, 0, 1 )) 				// 判断是不是文件上传
				{
					
					$postBodyString .= "$k=" . urlencode ( $this->characet ( $v, $this->postCharset ) ) . "&";
					$encodeArray [$k] = $this->characet ( $v, $this->postCharset );
				} else 				// 文件上传用multipart/form-data，否则用www-form-urlencoded
				{
					$postMultipart = true;
					$encodeArray [$k] = new \CURLFile ( substr ( $v, 1 ) );
				}
			}
			unset ( $k, $v );
			curl_setopt ( $ch, CURLOPT_POST, true );
			if ($postMultipart) {
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $encodeArray );
			} else {
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, substr ( $postBodyString, 0, - 1 ) );
			}
		}
		
		if (! $postMultipart) {
			$headers = array (
					'content-type: application/x-www-form-urlencoded;charset=' . $this->postCharset 
			);
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		}
		
		$reponse = curl_exec ( $ch );
		
		if (curl_errno ( $ch )) {
			
			throw new Exception ( curl_error ( $ch ), 0 );
		} else {
			$httpStatusCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
			if (200 !== $httpStatusCode) {
				throw new Exception ( $reponse, $httpStatusCode );
			}
		}
		
		curl_close ( $ch );
		return $reponse;
	}
}