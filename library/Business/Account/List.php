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
}