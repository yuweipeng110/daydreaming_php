<?php
header ( "Content-type:text/html;charset=utf-8" );

class Service_OrderController extends Custom_Webpage {

	/**
	 * 获取订单列表
	 */
	public function getOrderListAction() {
		$currentPage = isset ( $this->params ['currentPage'] ) ? $this->params ['currentPage'] : 1;
		$pageRecords = isset ( $this->params ['pageRecords'] ) ? $this->params ['pageRecords'] : 10;
		
		$storeId = $this->params ['storeId'];
		$statusId = $this->params ['statusId'];
		$startDate = $this->params ['startDate'];
		$endDate = $this->params ['endDate'];
		
		$storeList = Business_Script_List::SearchOrderList ( $storeId, $statusId, $startDate, $endDate );
		$paginate = new Paginate ( $storeList, $pageRecords, $currentPage );
		
		$listCollection = Business_Script_Tool::GetOrderListFieldData ( $paginate->CurrentRecord () );
		
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

	/**
	 * 添加订单
	 */
	public function addOrderAction() {
		$storeId = $this->data ['storeId'];
		$scriptId = $this->data ['scriptId'];
		$deskId = $this->data ['deskId'];
		$hostId = $this->data ['hostId'];
		$orderOperatorId = $this->data ['orderOperatorId'];
		$remark = $this->data ['remark'];
		$detailList = $this->data ['detailList'];
		
		// $detailList = array (
		// array (
		// 'user' => 1,
		// 'isPay' => 0
		// )
		// );
		
		$order = new Business_Webpage_Order ();
		$result = $order->AddOrder ( $storeId, $scriptId, $deskId, $hostId, $orderOperatorId, $remark, $detailList );
		
		$message = array (
				"code" => $order->GetCode (),
				"msg" => $order->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($order->GetData ()) {
			$message ['data'] = $order->GetData ();
		}
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function editOrderAction() {
		$orderId = $this->data ['orderId'];
		$deskId = $this->data ['deskId'];
		$hostId = $this->data ['hostId'];
		$remark = $this->data ['remark'];
		$detailList = $this->data ['detailList'];
		
		$order = new Business_Webpage_Order ();
		$order->EditOrder ( $orderId, $deskId, $hostId, $remark, $detailList );
		
		$message = array (
				"code" => $order->GetCode (),
				"msg" => $order->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($order->GetData ()) {
			$message ['data'] = $order->GetData ();
		}
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function setOrderSettlementAction() {
		$orderId = $this->data ['orderId'];
		$remark = $this->data ['remark'];
		$settlementOperatorId = $this->data ['settlementOperatorId'];
		$orderDetailList = $this->data ['orderDetailList'];
		
		$order = new Business_Webpage_Order ();
		$result = $order->SetOrderSettlement ( $orderId, $remark, $settlementOperatorId, $orderDetailList );
		
		$message = array (
				"code" => $order->GetCode (),
				"msg" => $order->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($order->GetData ()) {
			$message ['data'] = $order->GetData ();
		}
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function getOrderDetailListByOrderAction() {
		$currentPage = isset ( $this->params ['currentPage'] ) ? $this->params ['currentPage'] : 1;
		$pageRecords = isset ( $this->params ['pageRecords'] ) ? $this->params ['pageRecords'] : 10;
		
		$orderId = $this->params ['orderId'];
		
		$orderDetailList = Business_Script_List::GetOrderDetailListByOrder ( $orderId );
		$paginate = new Paginate ( $orderDetailList, $pageRecords, $currentPage );
		
		$listCollection = Business_Script_List::GetOrderDetailFieldData ( $paginate->CurrentRecord () );
		
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
	
	// public function addOrderDetailAction() {
	// $orderId = $this->data ['orderId'];
	// $userId = $this->data ['userId'];
	// $isMakeUp = $this->data ['isMakeUp'];
	
	// $orderDetail = new Business_Webpage_OrderDetail ();
	// $result = $orderDetail->AddOrderDetail ( $orderId, $userId, $isMakeUp );
	
	// $message = array (
	// "code" => $orderDetail->GetCode (),
	// "msg" => $orderDetail->GetMessage (),
	// "time" => date ( 'Y-m-d H:i:s' )
	// );
	// if ($orderDetail->GetData ()) {
	// $message ['data'] = $orderDetail->GetData ();
	// }
	// echo JsonData::ResultNotEncrypt ( $message );
	// exit ();
	// }
}