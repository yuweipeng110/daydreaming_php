<?php

class Business_Webpage_Order extends Data_Explain {

	public function AddOrder($storeId, $scriptId, $deskId, $hostId, $orderOperatorId, $remark, $detailList) {
		$result = false;
		$resultCode = 0;
		if (isset ( $storeId ) && isset ( $scriptId ) && isset ( $deskId ) && isset ( $hostId ) && isset ( $orderOperatorId ) && count ( $detailList ) > 0) {
			if ($this->checkAddOrder ( $storeId, $deskId )) {
				$order = new Business_Script_Order ();
				$store = new Business_User_Store ( $storeId );
				$script = new Business_Script_Base ( $scriptId );
				$desk = new Business_Script_Desk ( $deskId );
				$host = new Business_User_Base ( $hostId );
				$orderOperator = new Business_User_Base ( $orderOperatorId );
				
				$createOrder = $order->CreateOrder ( $store, $script, $desk, $host, $orderOperator, $remark, $detailList );
				
				if ($createOrder != null) {
					
					$resultCode = Business_Webpage_Message::SUCCESS;
					$result = true;
				} else {
					$resultCode = Business_Webpage_Message::LOGIC_ERROR;
				}
			} else {
				$resultCode = Business_Webpage_Message::CHECK_ERROR;
			}
		} else {
			$resultCode = Business_Webpage_Message::PARAMETER_ERROR;
		}
		$resultMessage = Business_Webpage_Message::getMessage ( $resultCode );
		
		$this->SetCode ( $resultCode );
		$this->SetMessage ( $resultMessage );
		
		return $result;
	}

	private function checkAddOrder($storeId, $deskId) {
		if (isset ( $storeId ) && isset ( $deskId )) {
			$re1 = Business_Check_Order::CheckStoreOrderDesk ( $storeId, $deskId );
			
			$data = array (
					'checkStoreOrderDesk' => $re1 
			);
			$this->SetData ( $data );
			if ($re1) {
				return false;
			}
		}
		return true;
	}

	public function EditOrder($orderId, $scriptId, $deskId, $hostId, $remark, $detailList) {
		$result = false;
		$resultCode = 0;
		if (isset ( $orderId ) && isset ( $deskId ) && isset ( $hostId ) && isset ( $detailList )) {
			$order = new Business_Script_Order ( $orderId );
			$script = new Business_Script_Base ( $scriptId );
			$desk = new Business_Script_Desk ( $deskId );
			$host = new Business_User_Base ( $hostId );
			
			$changeOrder = $order->ChangeOrder ( $script, $desk, $host, $remark, $detailList );
			
			if ($changeOrder != null) {
				
				$resultCode = Business_Webpage_Message::SUCCESS;
				$result = true;
			} else {
				$resultCode = Business_Webpage_Message::LOGIC_ERROR;
			}
		} else {
			$resultCode = Business_Webpage_Message::PARAMETER_ERROR;
		}
		$resultMessage = Business_Webpage_Message::getMessage ( $resultCode );
		
		$this->SetCode ( $resultCode );
		$this->SetMessage ( $resultMessage );
		return $result;
	}

	public function RemoveOrderDetail(Business_Script_OrderDetail $orderDetail) {
		if (! is_null ( $orderDetail )) {
			$orderDetail->Destroy ();
			
			return true;
		}
		return false;
	}

	public function SetOrderSettlement($orderId, $remark, $settlementOperatorId, $orderDetailList) {
		$result = false;
		$resultCode = 0;
		if (isset ( $orderId ) && isset ( $settlementOperatorId ) && isset ( $orderDetailList )) {
			$order = new Business_Script_Order ( $orderId );
			$settlementOperator = new Business_User_Base ( $settlementOperatorId );
			
			$settlementOrder = $order->SetOrderSettlement ( $remark, $settlementOperator, $orderDetailList );
			
			if ($settlementOrder != null) {
				$resultCode = Business_Webpage_Message::SUCCESS;
				$result = true;
			} else {
				$resultCode = Business_Webpage_Message::LOGIC_ERROR;
			}
		} else {
			$resultCode = Business_Webpage_Message::PARAMETER_ERROR;
		}
		$resultMessage = Business_Webpage_Message::getMessage ( $resultCode );
		
		$this->SetCode ( $resultCode );
		$this->SetMessage ( $resultMessage );
		
		return $result;
	}
}