<?php

class Business_Account_List {

	public static function SearchAccountList($startDate, $endDate, $userId) {
		$startDateString = $startDate == "" ? "" : " AND DATE_FORMAT(OTIME,'%Y-%m-%d') >= '$startDate'";
		$endDateString = $endDate == "" ? "" : " AND DATE_FORMAT(OTIME,'%Y-%m-%d') <= '$endDate'";
		$userIdString = $userId == "" ? "" : " AND F1_A801=$userId";
		
		$sqlString = "SELECT ID FROM A_801 WHERE 1=1
		$startDateString
		$endDateString
		$userIdString
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

	public static function SearchRevenueList($storeId, $startDate, $endDate) {
		$storeString = $storeId == "" ? "" : " AND F7_A803 = $storeId";
		$startDateString = $startDate == "" ? "" : " AND DATE_FORMAT(F3_A803,'%Y-%m-%d') >= '$startDate'";
		$endDateString = $endDate == "" ? "" : " AND DATE_FORMAT(F3_A803,'%Y-%m-%d') <= '$endDate'";
		
		$sqlString = "SELECT ID FROM A_803 WHERE 1=1
		$storeString
		$startDateString
		$endDateString
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

	public static function SearchIntegralList($storeId, $roleId) {
		$roleString = $roleId == "1" ? "" : " AND F6_A802 = $roleId";
		$sql = "
			SELECT
			F1_A802 AS 'USER_ID',
			OTIME,
			SUM(F2_A802) AS 'SUM_INTEGRAL'
			FROM A_802
			WHERE 1 = 1
			$roleString
			GROUP BY F1_A802
			ORDER BY SUM_INTEGRAL DESC,OTIME DESC
		";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sql );
		return $data;
	}
}