<?php
header ( "Content-type:text/html;charset=utf-8" );

class Service_AccountController extends Custom_Webpage {

	public function getAccountListAction() {
		$currentPage = isset ( $this->params ['currentPage'] ) ? $this->params ['currentPage'] : 1;
		$pageRecords = isset ( $this->params ['pageRecords'] ) ? $this->params ['pageRecords'] : 10;
		
		$startDate = $this->params ['startDate'];
		$endDate = $this->params ['endDate'];
		$userId = $this->params ['userId'];
		
		$list = Business_Account_List::SearchAccountList ( $startDate, $endDate, $userId );
		$paginate = new Paginate ( $list, $pageRecords, $currentPage );
		
		$listCollection = Business_Account_Tool::GetAccountListFieldData ( $paginate->CurrentRecord () );
		
// 		print_r($listCollection);
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'pageCount' => $paginate->PageCount () 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function getAccountStatisticsDayListAction() {
		$currentPage = isset ( $this->params ['currentPage'] ) ? $this->params ['currentPage'] : 1;
		$pageRecords = isset ( $this->params ['pageRecords'] ) ? $this->params ['pageRecords'] : 10;
		
		$startDate = $this->params ['startDate'];
		$endDate = $this->params ['endDate'];
		
		$list = Business_Statistics_Account::GetAccountDayStatisticsFromDate ( $startDate, $endDate );
		$paginate = new Paginate ( $list, $pageRecords, $currentPage );
		
		$listCollection = $paginate->CurrentRecord ();

// 		print_r($listCollection);
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'pageCount' => $paginate->PageCount () 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}
}