<?php

class Business_Statistics_Account {
	
	// ------------------START--------------------
	public static function GetAccountDayStatisticsFromDate($startDate, $endDate) {
		$sql = "
			SELECT DATE_FORMAT(OTIME,'%Y-%m-%d') AS 'days',
			SUM(F2_A801) AS 'totalBalance',
			IFNULL(TABLE1.accountBalance,0.00) AS 'accountBalance',
			IFNULL(TABLE2.voucherBalance,0.00) AS 'voucherBalance'
			FROM A_801
			
			LEFT JOIN (
				SELECT DATE_FORMAT(OTIME,'%Y-%m-%d') AS 'days',
				SUM(F2_A801) AS 'accountBalance'
				FROM A_801
				WHERE F6_A801 = 1
				GROUP BY days
			) AS TABLE1
		    ON DATE_FORMAT(OTIME,'%Y-%m-%d ') = TABLE1.days 
		    
			LEFT JOIN (
				SELECT DATE_FORMAT(OTIME,'%Y-%m-%d') AS 'days',
				SUM(F2_A801) AS 'voucherBalance'
				FROM A_801
				WHERE F6_A801 = 2
				GROUP BY days
			) AS TABLE2
		    ON DATE_FORMAT(OTIME,'%Y-%m-%d ') = TABLE2.days 
		    
			WHERE DATE_FORMAT(OTIME,'%Y-%m-%d') >= '$startDate'
			AND DATE_FORMAT(OTIME,'%Y-%m-%d') <= '$endDate'
			GROUP BY days
		";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sql );
		return $data;
	}
}