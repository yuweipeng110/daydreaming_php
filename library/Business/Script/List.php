<?php

class Business_Script_List {

	public static function GetScriptList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_301" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function SearchScriptList($storeId, $title, $type, $applicableNumber, $isAdapt) {
		$storeString = $storeId == "" ? "" : " AND F2_A301=$storeId";
		$titleString = $title == "" ? "" : " AND F1_A301 LIKE '%$title%'";
		$typeString = $type == "" ? "" : " AND F3_A301 LIKE '%$type%'";
		$applicableNumberString = $applicableNumber == "" ? "" : " AND F8_A301=$applicableNumber";
		$isAdaptString = $isAdapt == "" ? "" : " AND F10_A301=$isAdapt";
		
		$sqlString = "SELECT ID FROM A_301 WHERE 1=1
			$storeString
			$titleString
			$typeString
			$applicableNumberString
			$isAdaptString
			ORDER BY OTIME DESC
		";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sqlString );
		$objectList = array ();
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetOrderList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_302" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function SearchOrderList($storeId, $statusId, $startDate, $endDate) {
		$storeString = $storeId == "" ? "" : " AND F3_A302=$storeId";
		$statusString = $statusId == "" ? "" : " AND F12_A302=$statusId";
		$startDateString = $startDate == "" ? "" : " AND DATE_FORMAT(F9_A302,'%Y-%m-%d') >= '$startDate'";
		$endDateString = $endDate == "" ? "" : " AND DATE_FORMAT(F9_A302,'%Y-%m-%d') <= '$endDate'";
		
		$sqlString = "SELECT ID FROM A_302 WHERE 1=1
			$storeString
			$statusString
			$startDateString
			$endDateString
			ORDER BY OTIME DESC
		";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sqlString );
		$objectList = array ();
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetOrderDetailListByOrder($orderId) {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_303" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND F1_A303 = ? ', $orderId );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetOrderDetailIntegralByDetailList($detailId) {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_304" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND F1_A304 = ? ', $detailId );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetDeskList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_305" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetEnabledDeskList($storeId, $activate) {
		$activateString = $activate == "" ? "" : " AND TABLE1.F11_A302 = $activate";
		
		$sqlString = "
			SELECT A_305.ID,
			IFNULL(TABLE1.ID,0) AS 'ORDER_ID',
			IFNULL(TABLE1.F12_A302,0) AS 'ORDER_STATE'
			FROM A_305
			
			LEFT JOIN (
				SELECT ID,F4_A302,F12_A302
				FROM A_302
				WHERE F12_A302 = 10
				AND F3_A302 = $storeId
			) AS TABLE1 
			ON A_305.ID = TABLE1.F4_A302
			
			WHERE F2_A305 = 1
			AND F3_A305 = $storeId
			$activateString
			ORDER BY ID DESC
		";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sqlString );
		return $data;
	}
}