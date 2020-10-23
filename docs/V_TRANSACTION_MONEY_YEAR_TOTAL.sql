DROP PROCEDURE `V_TRANSACTION_MONEY_YEAR_TOTAL`//
CREATE DEFINER=`root`@`localhost` PROCEDURE `V_TRANSACTION_MONEY_YEAR_TOTAL`(IN DATE_YEAR YEAR)
BEGIN

	DECLARE MONTH INT DEFAULT 1;

	DROP TABLE IF EXISTS DATA_BASE_TMP;
	CREATE TEMPORARY TABLE DATA_BASE_TMP(
		`TMP_ID` int UNSIGNED NOT NULL AUTO_INCREMENT, 
		`MONTH` int NOT NULL,
		PRIMARY KEY (`TMP_ID`)
    )ENGINE=MyISAM DEFAULT CHARSET=utf8;

    WHILE MONTH <= 12 DO
	
		SET @sql = CONCAT('INSERT INTO DATA_BASE_TMP (`MONTH`) VALUES (''',MONTH,''')');
		PREPARE result FROM @sql;
		EXECUTE result;
		
        SET MONTH = MONTH + 1;
    END WHILE;

	SELECT DATA_BASE_TMP.MONTH,
	IFNULL(TABLE0.AllMoney,0.00) AS 'TABLE0_AllMoney',
	IFNULL(TABLE1.AllMoney,0.00) AS 'TABLE1_AllMoney',
	IFNULL(TABLE2.AllMoney,0.00) AS 'TABLE2_AllMoney',
	IFNULL(TABLE3.AllMoney,0.00) AS 'TABLE3_AllMoney',
	IFNULL(TABLE4.AllMoney,0.00) AS 'TABLE4_AllMoney'

	FROM DATA_BASE_TMP
	LEFT JOIN(
		SELECT DATE_FORMAT(TradingDetails.CreateDateTime,'%m') AS 'MONTH',
		SUM( TradingDetails.Money ) AS 'AllMoney'
		FROM TradingDetails
		INNER JOIN TransactionBill ON TransactionBill.Id = TradingDetails.TransactionBillId
		WHERE 1 = 1
		AND DATE_FORMAT(TradingDetails.CreateDateTime,'%Y') = DATE_YEAR
		GROUP BY DATE_FORMAT(TradingDetails.CreateDateTime,'%Y-%m')
	) AS TABLE0
	ON DATA_BASE_TMP.MONTH = TABLE0.MONTH

	LEFT JOIN(
		SELECT DATE_FORMAT(TradingDetails.CreateDateTime,'%m') AS 'MONTH',
		SUM( TradingDetails.Money ) AS 'AllMoney'
		FROM TradingDetails
		INNER JOIN TransactionBill ON TransactionBill.Id = TradingDetails.TransactionBillId
		WHERE 1 = 1
		AND DATE_FORMAT(TradingDetails.CreateDateTime,'%Y') = DATE_YEAR
		AND TradingDetails.PayTypeId = 1
		GROUP BY DATE_FORMAT(TradingDetails.CreateDateTime,'%Y-%m')
	) AS TABLE1
	ON DATA_BASE_TMP.MONTH = TABLE1.MONTH
	
	LEFT JOIN(
		SELECT DATE_FORMAT(TradingDetails.CreateDateTime,'%m') AS 'MONTH',
		SUM( TradingDetails.Money ) AS 'AllMoney'
		FROM TradingDetails
		INNER JOIN TransactionBill ON TransactionBill.Id = TradingDetails.TransactionBillId
		WHERE 1 = 1
		AND DATE_FORMAT(TradingDetails.CreateDateTime,'%Y') = DATE_YEAR
		AND TradingDetails.PayTypeId = 2
		GROUP BY DATE_FORMAT(TradingDetails.CreateDateTime,'%Y-%m')
	) AS TABLE2
	ON DATA_BASE_TMP.MONTH = TABLE2.MONTH
	
	LEFT JOIN(
		SELECT DATE_FORMAT(TradingDetails.CreateDateTime,'%m') AS 'MONTH',
		SUM( TradingDetails.Money ) AS 'AllMoney'
		FROM TradingDetails
		INNER JOIN TransactionBill ON TransactionBill.Id = TradingDetails.TransactionBillId
		WHERE 1 = 1
		AND DATE_FORMAT(TradingDetails.CreateDateTime,'%Y') = DATE_YEAR
		AND TradingDetails.PayTypeId = 3
		GROUP BY DATE_FORMAT(TradingDetails.CreateDateTime,'%Y-%m')
	) AS TABLE3
	ON DATA_BASE_TMP.MONTH = TABLE3.MONTH
	
	LEFT JOIN(
		SELECT DATE_FORMAT(TradingDetails.CreateDateTime,'%m') AS 'MONTH',
		SUM( TradingDetails.Money ) AS 'AllMoney'
		FROM TradingDetails
		INNER JOIN TransactionBill ON TransactionBill.Id = TradingDetails.TransactionBillId
		WHERE 1 = 1
		AND DATE_FORMAT(TradingDetails.CreateDateTime,'%Y') = DATE_YEAR
		AND TradingDetails.PayTypeId = 4
		GROUP BY DATE_FORMAT(TradingDetails.CreateDateTime,'%Y-%m')
	) AS TABLE4
	ON DATA_BASE_TMP.MONTH = TABLE4.MONTH;

	DROP TABLE IF EXISTS DATA_BASE_TMP;

END
