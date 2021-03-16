<?php
header ( "Content-type:text/html;charset=utf-8" );

class App_StatisticsController extends Custom_Webpage {

	public function getAccountListAction() {
		$current = isset ( $this->params ['current'] ) ? $this->params ['current'] : 1;
		$pageSize = isset ( $this->params ['pageSize'] ) ? $this->params ['pageSize'] : 10;
		
		$startDate = $this->params ['startDate'];
		$endDate = $this->params ['endDate'];
		$userId = $this->params ['userId'];
		
		$list = Business_Account_List::SearchAccountList ( $startDate, $endDate, $userId );
		$paginate = new Paginate ( $list, $pageSize, $current );
		
		$listCollection = Business_Account_Tool::GetAccountListFieldData ( $paginate->CurrentRecord () );
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'pageCount' => $paginate->PageCount (),
				'total' => $paginate->DataCount () 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function getAccountStatisticsDayListAction() {
		$current = isset ( $this->params ['current'] ) ? $this->params ['current'] : 1;
		$pageSize = isset ( $this->params ['pageSize'] ) ? $this->params ['pageSize'] : 10;
		
		$startDate = $this->params ['startDate'];
		$endDate = $this->params ['endDate'];
		
		$list = Business_Statistics_Account::GetAccountDayStatisticsFromDate ( $startDate, $endDate );
		$paginate = new Paginate ( $list, $pageSize, $current );
		
		$listCollection = $paginate->CurrentRecord ();
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'pageCount' => $paginate->PageCount (),
				'total' => $paginate->DataCount () 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function getUserIntegralRankStatisticsListAction() {
		$storeId = $this->params ['storeId'];
		
		$list = Business_Statistics_Integral::GetUserIntegralStatistics ( $storeId );
		$list = Business_Statistics_Integral::GetUserIntegralStatisticsFieldDataList ( $list );
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $list,
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}
}