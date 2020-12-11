<?php

class Business_Script_Order extends Object_Script_Order {

	public function CreateOrder(Business_User_Store $store, Business_Script_Base $script, Business_Script_Desk $desk, Business_User_Base $host, Business_User_Base $orderOperator, $remark, $detailList) {
		if ($this->GetId () == 0) {
			if (! is_null ( $script ) && ! is_null ( $orderOperator )) {
				$orderNo = Func::GetMillisecond ();
				
				$this->SetOrderNo ( $orderNo );
				$this->SetScript ( $script );
				$this->SetStore ( $store );
				$this->SetDesk ( $desk );
				$this->SetHost ( $host );
				// $this->SetReceivableMoney($receivableMoney);
				// $this->SetRealMoney($realMoney);
				$this->SetOrderOperator ( $orderOperator );
				$this->SetOrderTime ( date ( 'Y-m-d H:i:s' ) );
				$this->SetStatus ( 10 );
				$this->SetRemark ( $remark );
				$this->Save ();
				
				$this->addOrderDetail ( $this, $detailList );
				
				return $this;
			}
		}
		return null;
	}

	private function changeReceivableMoney($receivableMoney) {
		if ($this->GetId () > 0) {
			$this->SetReceivableMoney ( $receivableMoney );
			$this->Save ();
		}
	}

	private function changeRealMoney($realMoney) {
		if ($this->GetId () > 0) {
			$this->SetRealMoney ( $realMoney );
			$this->Save ();
		}
	}

	public function addOrderDetail(Business_Script_Order $order, $detailList) {
		if ($this->GetId () > 0 && count ( $detailList ) > 0) {
			$receivableMoney = 0;
			
			foreach ( $detailList as $value ) {
				$userId = $value ['userId'];
				$isPay = $value ['isPay'];
				// $detailIntegralList = $value ['detailIntegralList'];
				
				$orderDetail = new Business_Script_OrderDetail ();
				$user = new Business_User_Base ( $userId );
				
				$orderDetailIntegral = $orderDetail->CreateOrderDetail ( $order, $user, $isPay );
				
				if (! $isPay) {
					$receivableMoney += $order->GetScript ()->GetFormatPrice ();
				}
			}
			$this->changeReceivableMoney ( $receivableMoney );
		}
	}

	/**
	 * 设置订单结算
	 *
	 * @param decimal(10,2) $realMoney
	 *        	实收金额
	 * @param Business_User_Base $settlementOperator
	 *        	结算操作员
	 * @param unknown $paymentMethod
	 *        	结算方式
	 * @param array $orderDetailList
	 *        	明细列表
	 * @return Business_Script_Order NULL
	 */
	public function SetOrderSettlement($remark, Business_User_Base $settlementOperator, $orderDetailList) {
		if ($this->GetId () > 0 && $this->GetStatus () == 10) {
			$this->SetSettlementOperator ( $settlementOperator );
			$this->SetSettlementTime ( date ( 'Y-m-d H:i:s' ) );
			$this->SetStatus ( 20 );
// 			$this->SetPaymentMethod ( $paymentMethod );
			$this->SetRemark ( $remark );
			$this->Save ();
			
			$this->changeOrderDetailList ( $orderDetailList );
			
			return $this;
		}
		return null;
	}

	private function changeOrderDetailList($orderDetailList) {
		$realMoney = 0;
		foreach ( $orderDetailList as $value ) {
			$orderDetailId = $value ['orderDetailId'];
			$isPay = $value ['isPay'];
			$discount = $value ['discount'];
			
			$orderDetail = new Business_Script_OrderDetail ( $orderDetailId );
			$orderDetail->ChangeOrderDetail ( $isPay, $discount );
			if($isPay){
				$realMoney += $orderDetail->GetUnitPrice () * $discount;
			
				if (array_key_exists ( 'orderDetailIntegralList', $orderDetailList )) {
					$orderDetailIntegralList = $value ['orderDetailIntegralList'];
					$this->addDetailIntegralList ( $orderDetailId, $orderDetailIntegralList );
				}
			}
		}
		$this->changeRealMoney ( $realMoney );
	}

	private function addDetailIntegral(Business_Script_OrderDetail $orderDetail, Business_User_Role $role, $changeIntegral) {
		$detailIntegral = new Business_Script_OrderDetailIntegral ();
		
		$detailIntegralInstance = $detailIntegral->CreateOrderDetailIntegral ( $orderDetail, $role, $changeIntegral );
		
		if ($detailIntegralInstance != null && $detailIntegralInstance->GetOrderDetail () && $detailIntegralInstance->GetOrderDetail ()->GetUser ()) {
			$user = new Business_User_Base ( $detailIntegralInstance->GetOrderDetail ()->GetUser ()->GetId () );
			$changeMode = new Business_Enum_Integral ( 'GAME_IN' );
			
			$user->AddIntegral ( $changeIntegral, $changeMode, $role );
		}
	}

	private function addDetailIntegralList($orderDetailId, $orderDetailIntegralList) {
		foreach ( $orderDetailIntegralList as $value ) {
			$roleId = $value ['roleId'];
			$integral = $value ['integral'];
			
			$orderDetail = new Business_Script_OrderDetail ( $orderDetailId );
			$role = new Business_User_Role ( $roleId );
			
			$this->addDetailIntegral ( $orderDetail, $role, $integral );
		}
	}
}