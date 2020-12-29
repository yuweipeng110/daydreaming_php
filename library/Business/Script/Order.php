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
				
				// 添加订单明细列表
				$this->addOrderDetailList ( $this, $detailList );
				
				return $this;
			}
		}
		return null;
	}

	/**
	 * 变更应收金额
	 *
	 * @param decimal(10,2) $receivableMoney        	
	 */
	private function changeReceivableMoney($receivableMoney) {
		if ($this->GetId () > 0) {
			$this->SetReceivableMoney ( $receivableMoney );
			$this->Save ();
		}
	}

	/**
	 * 变更实收金额
	 *
	 * @param decimal(10,2) $realMoney        	
	 */
	private function changeRealMoney($realMoney) {
		if ($this->GetId () > 0) {
			$this->SetRealMoney ( $realMoney );
			$this->Save ();
		}
	}

	/**
	 * 销毁订单明细列表
	 *
	 * @param number $orderId        	
	 */
	private function destroyOrderDetailList($orderId) {
		$orderDetailList = Business_Script_List::GetOrderDetailListByOrder ( $orderId );
		foreach ( $orderDetailList as $orderDetailId ) {
			$orderDetail = new Business_Script_OrderDetail ( $orderDetailId );
			$orderDetail->Destroy ();
		}
	}

	/**
	 * 添加订单明细列表
	 *
	 * @param Business_Script_Order $order        	
	 * @param array $detailList        	
	 */
	public function addOrderDetailList(Business_Script_Order $order, $detailList) {
		if ($this->GetId () > 0 && count ( $detailList ) > 0) {
			$receivableMoney = 0;
			
			foreach ( $detailList as $value ) {
				$userId = $value ['userId'];
				$isPay = 1;
				
				$orderDetail = new Business_Script_OrderDetail ();
				$user = new Business_User_Base ( $userId );
				
				$orderDetailIntegral = $orderDetail->CreateOrderDetail ( $order, $user, $isPay );
				
				$receivableMoney += $order->GetScript ()->GetFormatPrice ();
			}
			// 更改应收金额
			$this->changeReceivableMoney ( $receivableMoney );
		}
	}

	/**
	 * 更改订单
	 *
	 * @param Business_Script_Desk $desk        	
	 * @param Business_User_Base $host        	
	 * @param string $remark        	
	 * @param array $detailList        	
	 * @return Business_Script_Order NULL
	 */
	public function ChangeOrder(Business_Script_Desk $desk, Business_User_Base $host, $remark, $detailList) {
		if ($this->GetId () > 0) {
			if (! is_null ( $desk ) && ! is_null ( $host )) {
				$this->SetDesk ( $desk );
				$this->SetHost ( $host );
				$this->SetRemark ( $remark );
				$this->Save ();
				
				// 销毁订单明细列表
				$this->destroyOrderDetailList ( $this->GetId () );
				// 添加订单明细列表
				$this->addOrderDetailList ( $this, $detailList );
				
				return $this;
			}
		}
		return null;
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
			// $this->SetPaymentMethod ( $paymentMethod );
			$this->SetRemark ( $remark );
			$this->Save ();
			
			$this->changeOrderDetailList ( $this->GetId (), $orderDetailList );
			
			return $this;
		}
		return null;
	}

	/**
	 * 更改订单明细列表
	 *
	 * @param unknown $orderId        	
	 * @param unknown $newOrderDetailList        	
	 */
	private function changeOrderDetailList($orderId, $newOrderDetailList) {
		$realMoney = 0;
		foreach ( $newOrderDetailList as $value ) {
			$orderDetailId = $value ['id'];
			$isPay = $value ['isPay'];
			$discount = $value ['discount'];
			$discountPrice = $value ['discountPrice'];
			
			$orderDetail = new Business_Script_OrderDetail ( $orderDetailId );
			$orderDetail->ChangeOrderDetail ( $isPay, $discount, $discountPrice );
			$realMoney += $discountPrice;
			
			if (array_key_exists ( 'orderDetailIntegralList', $value )) {
				$orderDetailIntegralList = $value ['orderDetailIntegralList'];
				$this->addDetailIntegralList ( $orderDetailId, $orderDetailIntegralList );
			}
		}
		$this->changeRealMoney ( $realMoney );
	}

	/**
	 * 订单明细用户变更积分
	 *
	 * @param Business_Script_OrderDetail $orderDetail        	
	 * @param Business_User_Role $role        	
	 * @param number $changeIntegral        	
	 */
	private function addDetailIntegral(Business_Script_OrderDetail $orderDetail, Business_User_Role $role, $changeIntegral) {
		$detailIntegral = new Business_Script_OrderDetailIntegral ();
		
		$detailIntegralInstance = $detailIntegral->CreateOrderDetailIntegral ( $orderDetail, $role, $changeIntegral );
		
		if ($detailIntegralInstance != null && $detailIntegralInstance->GetOrderDetail () && $detailIntegralInstance->GetOrderDetail ()->GetUser ()) {
			$user = new Business_User_Base ( $detailIntegralInstance->GetOrderDetail ()->GetUser ()->GetId () );
			$changeMode = new Business_Enum_Integral ( 'GAME_IN' );
			
			$user->AddIntegral ( $changeIntegral, $changeMode, $role );
		}
	}

	/**
	 * 根据订单明细更改用户积分列表
	 *
	 * @param number $orderDetailId
	 *        	订单明细ID
	 * @param array $orderDetailIntegralList
	 *        	订单明细积分列表
	 */
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