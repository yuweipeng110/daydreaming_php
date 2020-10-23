<?php

class Business_User_List {

	public static function GetStoreList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_203" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function SearchStoreList($userName, $storeName, $status, $phone) {
		$userNameString1 = $userName == "" ? "" : " AND F5_A203 IN(SELECT ID FROM A_201 WHERE F4_A201 LIKE '%$userName%')";
		$userNameString2 = $userName == "" ? "" : " OR F5_A203 IN(SELECT ID FROM A_201 WHERE F3_A201 IN (SELECT ID FROM A_101 WHERE F1_A101 LIKE '%$userName%'))";
		$userNameString = $userName == "" ? "" : 'AND (' + $userNameString1 + $userNameString2 + ')';
		$storeNameString = $storeName == "" ? "" : " AND F1_A203 LIKE '%$storeName%'";
		$phoneString = $phone == "" ? "" : " AND F3_A203 LIKE '%$phone%'";
		$statusString = $status == "" ? "" : " AND F2_A203=$status";
		
		$sqlString = "SELECT ID FROM A_203 WHERE 1=1
		$userNameString1
		$userNameString2
		$storeNameString
		$phoneString
		$statusString
		ORDER BY OTIME DESC";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sqlString );
		$objectList = array ();
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetStoreFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$store = new Business_User_Store ( $id );
			
			$valueData = array ();
			$valueData ['id'] = $store->GetId ();
			$valueData ['storeName'] = $store->GetName ();
			$valueData ['status'] = $store->GetStatus () == 1 ? true : false;
			$valueData ['phoneNumber'] = $store->GetPhone ();
			$valueData ['address'] = $store->GetAddress ();
			$userName = '';
			$password = '';
			$realName = '';
			if ($store->GetBoss () != null) {
				$systemUser = $store->GetBoss ()->GetSystemUser ();
				$userName = $systemUser->GetUserName ();
				$password = $systemUser->GetPassword ();
				$nickname = $store->GetBoss ()->GetNickname ();
			}
			$valueData ['userName'] = $userName;
			$valueData ['passWord'] = $password;
			$valueData ['realName'] = $realName;
			
			$listCollection [] = $valueData;
		}
		return $listCollection;
	}

	public static function GetPlayerList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_201" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND F1_A201 = 3 ', null );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}
	
	public static function SearchPlayerList($nickname,$phone){
		$nicknameString = $nickname == "" ? "" : " AND F4_A201 LIKE '%$nickname%'";
		$phoneString = $phone == "" ? "" : " AND F6_A201 LIKE '%$phone%'";

		$sqlString = "SELECT ID FROM A_201 WHERE 1=1
		AND F1_A201 = 3
		$nicknameString
		$phoneString
		ORDER BY OTIME DESC";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sqlString );
		$objectList = array ();
		
		foreach ( $data as $value ) {
		$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetPlayerFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$player = new Business_User_Player_Base ( $id );
			
			$valueData = array ();
			$valueData ['id'] = $player->GetId ();
			$valueData ['nickname'] = $player->GetNickname ();
			$valueData ['sex'] = $player->GetSex ();
			$valueData ['phone'] = $player->GetPhone ();
			$valueData ['killerIntegral'] = $player->GetKillerIntegral ();
			$valueData ['detectiveIntegral'] = $player->GetDetectiveIntegral ();
			$valueData ['peopleIntegral'] = $player->GetPeopleIntegral ();
			$valueData ['totalIntegral'] = $player->GetTotalIntegral ();
			$valueData ['activeIntegral'] = $player->GetActiveIntegral ();
			$valueData ['remark'] = $player->GetRemark ();
			$valueData ['otime'] = $player->GetOtime ();
			
			$listCollection [] = $valueData;
		}
		return $listCollection;
	}

	public function GetUserList() {
		return array ();
	}

	public function GetUserFieldData($list) {
	}
}