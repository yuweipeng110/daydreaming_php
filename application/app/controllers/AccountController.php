<?php
header ( "Content-type:text/html;charset=utf-8" );

class App_AccountController extends Custom_Webpage {

	public function getRevenueListAction() {
		$current = isset ( $this->params ['current'] ) ? $this->params ['current'] : 1;
		$pageSize = isset ( $this->params ['pageSize'] ) ? $this->params ['pageSize'] : 10;
		
		$storeId = $this->params ['storeId'];
		$changeTime = Zend_Json::decode ( $this->params ['changeTime'] );
		$startDate = $changeTime ['dateRange'] [0];
		$endDate = $changeTime ['dateRange'] [1];
		
		$accountList = Business_Account_List::SearchRevenueList ( $storeId, $startDate, $endDate );
		$paginate = new Paginate ( $accountList, $pageSize, $current );
		
		$listCollection = Business_Account_Tool::GetRevenueListFieldData ( $paginate->CurrentRecord () );
		$dataList = $listCollection ['dataList'];
		$statisticsData = $listCollection ['statisticsData'];
		
		// print_r($listCollection);
		// print_r(array_column ( $listCollection, 'changeMoney' ));
		// die();
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $dataList,
				"time" => date ( 'Y-m-d H:i:s' ),
				'total' => $paginate->DataCount (),
				'statisticsData' => $statisticsData 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function getUserIntegralRankListAction() {
		$current = isset ( $this->params ['current'] ) ? $this->params ['current'] : 1;
		$pageSize = isset ( $this->params ['pageSize'] ) ? $this->params ['pageSize'] : 10;
		
		$storeId = $this->params ['storeId'];
		$roleId = $this->params ['roleId'];
		
		$list = Business_Account_List::SearchIntegralList ( $storeId, $roleId );
		$paginate = new Paginate ( $list, $pageSize, $current );
		$listCollection = Business_Account_Tool::GetUserIntegralFieldDataList ( $paginate->CurrentRecord () );
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'total' => $paginate->DataCount () 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}
}