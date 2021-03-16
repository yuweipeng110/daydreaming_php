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

	public static function SearchUserList($storeId, $nickname, $phone, $roleId, $isHost) {
		$storeIdString = $storeId == "" ? "" : " AND F2_A201 = $storeId";
		$nicknameString = $nickname == "" ? "" : " AND F4_A201 LIKE '%$nickname%'";
		$phoneString = $phone == "" ? "" : " AND F6_A201 LIKE '%$phone%'";
		$roleString = $roleId == "" ? "" : " AND F1_A201 = $roleId";
		$isHostString = $isHost == "" ? "" : " AND F1_A201 != 3";
		
		$sqlString = "SELECT ID FROM A_201 WHERE 1=1
		$storeIdString
		$nicknameString
		$phoneString
		$roleString
		$isHostString
		ORDER BY F1_A201 ASC,OTIME DESC";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sqlString );
		$objectList = array ();
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function SearchHostList($storeId, $nickname, $phone) {
		$storeIdString = $storeId == "" ? "" : " AND F2_A201 = $storeId";
		$nicknameString = $nickname == "" ? "" : " AND F4_A201 LIKE '%$nickname%'";
		$phoneString = $phone == "" ? "" : " AND F6_A201 LIKE '%$phone%'";
		
		$sqlString = "SELECT ID FROM A_201 WHERE 1=1
		AND F1_A201 != 3
		$storeIdString
		$nicknameString
		$phoneString
		ORDER BY F1_A201 ASC,OTIME DESC";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sqlString );
		$objectList = array ();
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
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

	public static function SearchPlayerList($storeId, $nickname, $phone) {
		$storeIdString = $storeId == "" ? "" : " AND F2_A201 = $storeId";
		$nicknameString = $nickname == "" ? "" : " AND F4_A201 LIKE '%$nickname%'";
		$phoneString = $phone == "" ? "" : " AND (F6_A201 LIKE '%$phone%' OR F4_A201 LIKE '%$phone%')";
		
		$sqlString = "SELECT ID FROM A_201 WHERE 1=1
		AND F1_A201 = 3
		$storeIdString
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

	public function GetUserList() {
		return array ();
	}

	public function GetUserFieldData($list) {
	}

	public static function GetRoleList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_210" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND ID > ?', 1 );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetRankListByRole($roleId) {
		// $roleIdString = $roleId == 0 ? "" : " AND F2_A211 = $roleId";
		
		// $sqlString = "
		// SELECT ID FROM A_211 WHERE 1=1
		// $roleIdString
		// ORDER BY F3_A211,OTIME DESC
		// ";
		
		// $table = new Custom_Adapter ();
		// $db = $table->getAdapter ();
		// $data = $db->fetchAll ( $sqlString );
		// $objectList = array ();
		
		// foreach ( $data as $value ) {
		// $objectList [] = $value ['ID'];
		// }
		// return $objectList;
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_211" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND F2_A211 = ? ', $roleId );
		$order = array (
				"F1_A211",
				"OTIME" 
		);
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}
}