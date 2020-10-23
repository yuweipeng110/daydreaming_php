DROP PROCEDURE `P_STATISTICS_TRANSACTION_CREATE`//
CREATE DEFINER=`root`@`localhost` PROCEDURE `P_STATISTICS_TRANSACTION_CREATE`(IN DATE_DAYS DATE)
BEGIN
	DECLARE SQL_STRING_PROCESS VARCHAR(4000);

	DECLARE RESULT_CODE INT DEFAULT 0;
	DECLARE RESULT_INFO VARCHAR(128) DEFAULT '操作失败';

	DECLARE DAYS DATE;
	DECLARE ALL_PAY FLOAT;
	DECLARE ALL_REFUND FLOAT;
	DECLARE ALL_FEE_MONEY FLOAT;

	DECLARE ORDER_BUS_ID INT;
	DECLARE AREA_MANAGE_ID INT;
	DECLARE DONE INT DEFAULT 0;

	DECLARE CUR_1 CURSOR FOR 
		SELECT DATE_FORMAT(TradingDetails.CreateDateTime,'%Y-%m-%d') AS 'DAYS',
		SUM(CASE WHEN Money >= 0 THEN Money ELSE 0 END) AS 'ALL_PAY',
		SUM(CASE WHEN Money < 0 THEN Money ELSE 0 END) AS 'ALL_REFUND',
		SUM(FeeMoney) AS 'ALL_FEE_MONEY',
		OrderBusId,
		AreaId
		FROM TradingDetails INNER JOIN TransactionBill ON TransactionBill.Id=TradingDetails.TransactionBillId
		WHERE 1=1
		AND DATE_FORMAT(TradingDetails.CreateDateTime,'%Y-%m-%d') = DATE_DAYS
		GROUP BY DATE_FORMAT(TradingDetails.CreateDateTime,'%Y-%m-%d'),OrderBusId,AreaId;
	DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET DONE = 1;
	OPEN CUR_1;
	
	DELETE FROM TradingDayTotal WHERE TotalDate = DATE_DAYS;
	DELETE FROM TradingDayTotalDetails WHERE TotalDate = DATE_DAYS;

	REPEAT
	FETCH CUR_1 INTO DAYS,ALL_PAY,ALL_REFUND,ALL_FEE_MONEY,ORDER_BUS_ID, AREA_MANAGE_ID;
	IF NOT DONE THEN
		SET @EXISTSTRANSID = 0;
		INSERT INTO TradingDayTotal(TotalDate,OrderBusId,AreaId,AllPayMoney,AllRefundMoney,AllFeeMoney,CreateDateTime)
		VALUES(DAYS,ORDER_BUS_ID,AREA_MANAGE_ID,ALL_PAY,ALL_REFUND,ALL_FEE_MONEY,NOW());
		SET @EXISTSTRANSID = LAST_INSERT_ID();

		SET SQL_STRING_PROCESS = CONCAT('
			INSERT INTO TradingDayTotalDetails(TotalDate,TradingDayTotalId,PayTypeId,AllPayMoney,AllRefundMoney,AllFeeMoney,CreateDateTime)
			SELECT DATE_FORMAT(TradingDetails.CreateDateTime,''%Y-%m-%d''),
			',@EXISTSTRANSID,',
			TradingDetails.PayTypeId,
			SUM(CASE WHEN TradingDetails.Money >= 0 THEN TradingDetails.Money ELSE 0 END),
			SUM(CASE WHEN TradingDetails.Money < 0 THEN TradingDetails.Money ELSE 0 END),
			SUM(TradingDetails.FeeMoney),
			NOW()
			FROM TradingDetails INNER JOIN TransactionBill ON TransactionBill.Id=TradingDetails.TransactionBillId
			WHERE 1=1
			AND TransactionBill.OrderBusId = ',ORDER_BUS_ID,'
			AND TransactionBill.AreaId = ',AREA_MANAGE_ID,'
			AND DATE_FORMAT(TradingDetails.CreateDateTime,''%Y-%m-%d'') = ''',DAYS,'''
			GROUP BY DATE_FORMAT(TradingDetails.CreateDateTime,''%Y-%m-%d''),TradingDetails.PayTypeId;
		');
		SET @sql = SQL_STRING_PROCESS;
		PREPARE result FROM @sql;
		EXECUTE result;
		DEALLOCATE PREPARE result;

		SET RESULT_CODE = 1;
		SET RESULT_INFO = CONCAT('操作成功');
	END IF;
	UNTIL DONE END REPEAT;

	SELECT RESULT_CODE,RESULT_INFO;
END