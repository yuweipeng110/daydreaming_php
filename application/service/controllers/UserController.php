<?php
header ( "Content-type:text/html;charset=utf-8" );

class Service_UserController extends Zend_Controller_Action {
	private $json = "";
	private $param = null;
	private $data = array ();

	public function init() {
		parent::init ();
		$this->json = JsonData::LoadNotDecrypt ( file_get_contents ( "php://input" ) );
		$this->params = $this->getAllParams ();
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
	 * 获取门店列表
	 */
	public function getStoreListAction() {
		$currentPage = isset ( $this->params ['currentPage'] ) ? $this->params ['currentPage'] : 1;
		$pageRecords = isset ( $this->params ['pageRecords'] ) ? $this->params ['pageRecords'] : 10;
		
		$userName = $this->params ['userName'];
		$storeName = $this->params ['storeName'];
		$status = $this->params ['status'];
		$phone = $this->params ['phoneNumber'];
		
		$storeList = Business_User_List::SearchStoreList ( $userName, $storeName, $status, $phone );
		$paginate = new Paginate ( $storeList, $pageRecords, $currentPage );
		
		$listCollection = Business_User_List::GetStoreFieldData ( $paginate->CurrentRecord () );
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'pageCount' => $paginate->PageCount () 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	/**
	 * 验证添加门店
	 */
	public function checkAddStoreAction() {
		$storeName = $this->data ['storeName'];
		$userName = $this->data ['userName'];
		
		$store = new Business_Webpage_Store ();
		$store->CheckAddStore ( $storeName, $userName );
		
		$message = array (
				"code" => $store->GetCode (),
				"msg" => $store->GetMessage (),
				"data" => $store->GetData (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	/**
	 * 添加门店
	 */
	public function addStoreAction() {
		$userName = $this->data ['userName'];
		$password = $this->data ['password'];
		$realName = $this->data ['realName'];
		$storeName = $this->data ['storeName'];
		$status = $this->data ['status'];
		$phone = $this->data ['phoneNumber'];
		$address = $this->data ['address'];
		
		$store = new Business_Webpage_Store ();
		$result = $store->AddStore ( $userName, $password, $realName, $storeName, $status, $phone, $address );
		
		$message = array (
				"code" => $store->GetCode (),
				"msg" => $store->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($store->GetData ()) {
			$message ['data'] = $store->GetData ();
		}
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	/**
	 * 修改门店
	 */
	public function editStoreAction() {
		$storeId = $this->data ['storeId'];
		$storeName = $this->data ['storeName'];
		$status = $this->data ['status'];
		$address = $this->data ['address'];
		
		$store = new Business_Webpage_Store ();
		$result = $store->EditStore ( $storeId, $storeName, $status, $address );
		
		$message = array (
				"code" => $store->GetCode (),
				"msg" => $store->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($store->GetData ()) {
			$message ['data'] = $store->GetData ();
		}
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	/**
	 * 获取玩家列表
	 */
	public function getPlayerListAction() {
		$currentPage = isset ( $this->params ['currentPage'] ) ? $this->params ['currentPage'] : 1;
		$pageRecords = isset ( $this->params ['pageRecords'] ) ? $this->params ['pageRecords'] : 10;
		
		$nickname = $this->params ['nickname'];
		$phone = $this->params ['phone'];
		
		$playerList = Business_User_List::SearchPlayerList ( $nickname, $phone );
		$paginate = new Paginate ( $playerList, $pageRecords, $currentPage );
		
		$listCollection = Business_User_List::GetPlayerFieldData ( $paginate->CurrentRecord () );
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'pageCount' => $paginate->PageCount () 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	/**
	 * 添加玩家
	 */
	public function addPlayerAction() {
		$storeId = $this->data ['storeId'];
		$nickname = $this->data ['nickname'];
		$sex = isset ( $this->data ['sex'] ) ? $this->data ['sex'] : 0;
		$phone = $this->data ['phone'];
		$remark = $this->data ['remark'];
		
		$player = new Business_Webpage_User ();
		$player->AddPlayer ( $storeId, $nickname, $sex, $phone, $remark );
		
		$message = array (
				"code" => $player->GetCode (),
				"msg" => $player->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($player->GetData ()) {
			$message ['data'] = $player->GetData ();
		}
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	/**
	 * 修改玩家
	 */
	public function editPlayerAction() {
		$playerId = $this->data ['playerId'];
		$nickname = $this->data ['nickname'];
		$sex = isset ( $this->data ['sex'] ) ? $this->data ['sex'] : 0;
		$phone = $this->data ['phone'];
		$remark = $this->data ['remark'];
		
		$store = new Business_Webpage_User ();
		$result = $store->EditPlayer ( $playerId, $nickname, $sex, $phone, $remark );
		
		$message = array (
				"code" => $store->GetCode (),
				"msg" => $store->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($store->GetData ()) {
			$message ['data'] = $store->GetData ();
		}
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}
}