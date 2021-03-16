<?php
header ( "Content-type:text/html;charset=utf-8" );

class App_OrderController extends Custom_Webpage {

	/**
	 * 获取订单列表
	 */
	public function getOrderListAction() {
		$current = isset ( $this->params ['current'] ) ? $this->params ['current'] : 1;
		$pageSize = isset ( $this->params ['pageSize'] ) ? $this->params ['pageSize'] : 10;
		
		$storeId = $this->params ['storeId'];
		$statusId = $this->params ['status'];
		$orderTime = Zend_Json::decode ( $this->params ['orderTime'] );
		$startDate = $orderTime ['dateRange'] [0];
		$endDate = $orderTime ['dateRange'] [1];
		
		$storeList = Business_Script_List::SearchOrderList ( $storeId, $statusId, $startDate, $endDate );
		$paginate = new Paginate ( $storeList, $pageSize, $current );
		
		$listCollection = Business_Script_Tool::GetOrderListFieldData ( $paginate->CurrentRecord () );
		
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
		$scriptId = $this->data ['scriptId'];
		$deskId = $this->data ['deskId'];
		$hostId = $this->data ['hostId'];
		$remark = $this->data ['remark'];
		$detailList = $this->data ['detailList'];
		
		$order = new Business_Webpage_Order ();
		$order->EditOrder ( $orderId, $scriptId, $deskId, $hostId, $remark, $detailList );
		
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
}