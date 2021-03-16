<?php

class Business_Statistics_Integral {

	public static function GetUserIntegralStatistics($storeId, $roleId) {
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

	public static function GetUserIntegralStatisticsFieldDataList($list) {
		$listCollection = array ();
		foreach ( $list as $value ) {
			$listCollection [] = Business_User_Tool::GetUserFieldData ( $value['USER_ID'] );
		}
		
		return $listCollection;
	}
}