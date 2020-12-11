<?php

class Business_Webpage_OrderDetail extends Data_Explain {

	public function AddOrderDetail($orderId, $userId, $roleId, $isMakeUp) {
		$result = false;
		$resultCode = 0;
		if (isset ( $orderId ) && isset ( $userId ) && isset ( $isMakeUp )) {
			$order = new Business_Script_Order ( $orderId );
			$storeId = $order->GetStore () == null ? 0 : $order->GetStore ()->GetId ();
			$deskId = $order->GetDesk () == null ? 0 : $order->GetDesk ()->GetId ();
			
			if ($this->checkAddOrderDetail ( $storeId, $deskId )) {
				$orderDetail = new Business_Script_OrderDetail ();
				$user = new Business_User_Base ( $userId );
				$role = new Business_User_Role ( $roleId );
				
				$createOrderDetail = $orderDetail->CreateOrderDetail ( $order, $user, $role, $isMakeUp );
				
				if ($createOrderDetail != null) {
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

	private function checkAddOrderDetail($storeId, $deskId) {
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
}