<?php

class Business_Statistics_Integral {

	public static function GetUserIntegralStatistics($storeId) {
// 		$roleString = $roleId == "1" ? "" : " AND F6_A802 = $roleId";
		$sql = "
			(
				SELECT 
				F1_A802 AS 'USER_ID',
				OTIME,
				SUM(F2_A802) AS 'SUM_INTEGRAL' 
				FROM A_802 
				WHERE 1 = 1
				GROUP BY F1_A802 
				ORDER BY SUM_INTEGRAL DESC,OTIME DESC
				LIMIT 10
			) UNION ALL 
			(
				SELECT 
				F1_A802 AS 'USER_ID',
				OTIME,
				SUM(F2_A802) AS 'SUM_INTEGRAL' 
				FROM A_802 
				WHERE 1 = 1
				AND F6_A802 = 2
				GROUP BY F1_A802 
				ORDER BY SUM_INTEGRAL DESC,OTIME DESC
				LIMIT 10
			) UNION ALL 
			(
				SELECT 
				F1_A802 AS 'USER_ID',
				OTIME,
				SUM(F2_A802) AS 'SUM_INTEGRAL' 
				FROM A_802 
				WHERE 1 = 1
				AND F6_A802 = 3
				GROUP BY F1_A802 
				ORDER BY SUM_INTEGRAL DESC,OTIME DESC
				LIMIT 10
			) UNION ALL 
			(
				SELECT 
				F1_A802 AS 'USER_ID',
				OTIME,
				SUM(F2_A802) AS 'SUM_INTEGRAL' 
				FROM A_802 
				WHERE 1 = 1
				AND F6_A802 = 4
				GROUP BY F1_A802 
				ORDER BY SUM_INTEGRAL DESC,OTIME DESC
				LIMIT 10
			)
		";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sql );
		return $data;
	}

	public static function GetUserIntegralStatisticsFieldDataList($list) {
		$listCollection = array ();
		foreach ( $list as $key => $value ) {
			$dataValue = array ();
			$dataValue ['userId'] = $value ['USER_ID'];
			$dataValue ['userInfo'] = Business_User_Tool::GetUserFieldData ( $value ['USER_ID'] );
			
			$listCollection [] = $dataValue;
		}
		
		$result = array_chunk ( $listCollection, 10 );
		return list ( $killerList, $detectiveList, $peopleList, $totalList ) = $result;
	}
}