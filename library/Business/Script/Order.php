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
			$receivableMoney = $order->GetScript()->GetFormatPrice() * count ( $detailList );
			
			foreach ( $detailList as $value ) {
				$userId = $value ['userId'];
				$isPay = 1;
				
				$orderDetail = new Business_Script_OrderDetail ();
				$user = new Business_User_Base ( $userId );
				
				$orderDetailIntegral = $orderDetail->CreateOrderDetail ( $order, $user, $isPay );
			}
			// 更改应收金额
			$this->changeReceivableMoney ( $receivableMoney );
		}
	}

	/**
	 * 更改订单
	 *
	 * @param Business_Script_Base $scirpt        	
	 * @param Business_Script_Desk $desk        	
	 * @param Business_User_Base $host        	
	 * @param string $remark        	
	 * @param array $detailList        	
	 * @return Business_Script_Order NULL
	 */
	public function ChangeOrder(Business_Script_Base $script, Business_Script_Desk $desk, Business_User_Base $host, $remark, $detailList) {
		if ($this->GetId () > 0) {
			if (! is_null ( $desk ) && ! is_null ( $host )) {
				$this->SetDesk ( $desk );
				$this->SetScript ( $script );
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
	 * @param array $orderDetailList
	 *        	明细列表
	 * @return Business_Script_Order NULL
	 */
	public function SetOrderSettlement($remark, Business_User_Base $settlementOperator, $orderDetailList) {
		if ($this->GetId () > 0 && $this->GetStatus () == 10) {
			// if ($this->checkOrderDetailUserBalance ( $orderDetailList )) {
			$this->SetSettlementOperator ( $settlementOperator );
			$this->SetSettlementTime ( date ( 'Y-m-d H:i:s' ) );
			$this->SetStatus ( 20 );
			// $this->SetPaymentMethod ( $paymentMethod );
			$this->SetRemark ( $remark );
			$this->Save ();
			
			$this->changeOrderDetailList ( $this, $orderDetailList );
			
			return $this;
			// }
		}
		return null;
	}

	/**
	 * 验证订单明细账户余额
	 *
	 * @return boolean
	 */
	private function checkOrderDetailUserBalance($orderDetailList) {
		$result = false;
		foreach ( $orderDetailList as $value ) {
			$userId = $value ['userId'];
			$discount = $value ['discount'];
			$discountPrice = $value ['discountPrice'];
			$user = new Business_User_Base ( $userId );
			$userTotalBalance = ($user->GetBalance () + $user->GetVoucherBalance ());
			
			if ($userTotalBalance >= $discountPrice) {
				$result = true;
			} else {
				$result = false;
				break;
			}
		}
		return $result;
	}

	/**
	 * 更改订单明细列表
	 *
	 * @param Business_Script_Order $order        	
	 * @param array $newOrderDetailList
	 *        	@use SetOrderSettlement(设置订单结算)
	 */
	private function changeOrderDetailList(Business_Script_Order $order, $newOrderDetailList) {
		$orderRealMoney = 0;
		foreach ( $newOrderDetailList as $value ) {
			$orderDetailId = $value ['id'];
			$userId = $value ['userId'];
			$isPay = $value ['isPay'];
			$discount = $value ['discountPercentage'] / 100;
			$discountPrice = $value ['unitPrice'] * $discount;
			$paymentMethodId = isset ( $value ['paymentMethodId'] ) ? 1 : $value ['paymentMethodId'];
			$gameRole = $value ['gameRole'];
			$integral = $value ['integral'];
			
			// 更改订单明细
			$user = new Business_User_Base ( $userId );
			$orderDetail = new Business_Script_OrderDetail ( $orderDetailId );
			$paymentMethod = new Business_Option_PaymentMethod ( $paymentMethodId );
			$orderDetail->ChangeOrderDetail ( $isPay, $discount, $discountPrice, $paymentMethod, $gameRole, $integral );
			$orderRealMoney += $discountPrice;
			
			// 余额支付相关流程
			if ($paymentMethodId == 5) {
				$this->orderDetailPaymentProcess ( $user, $order, $discountPrice, $paymentMethod );
			}
			// 更改用户积分
			// if (array_key_exists ( 'orderDetailIntegralList', $value )) {
			// $orderDetailIntegralList = $value ['orderDetailIntegralList'];
			// $this->addDetailIntegralList ( $orderDetailId, $orderDetailIntegralList );
			// }
			if (in_array ( $paymentMethodId, array (
					1,
					2,
					3 
			) )) {
				$revenue = new Business_Account_Revenue ();
				$store = new Business_User_Store ( $this->GetStore ()->GetId () );
				$revenueChangeType = 1;
				$remarkIncrease = "ORDER";
				$remarkReduce = "";
				$revenue->CreateRevenue ( $user, abs ( $discountPrice ), $remarkIncrease, $remarkReduce, $revenueChangeType, $store, $order, $paymentMethod );
			}
		}
		$this->changeRealMoney ( $orderRealMoney );
	}

	/**
	 * 订单明细账户流水Process
	 *
	 * @param Business_User_Base $user        	
	 * @param Business_Script_Order $order        	
	 * @param unknown $realMoney        	
	 */
	private function orderDetailPaymentProcess(Business_User_Base $user, Business_Script_Order $order, $discountPrice, Business_Option_PaymentMethod $paymentMethod) {
		$userTotalBalance = $user->GetBalance () + $user->GetVoucherBalance ();
		if ($userTotalBalance >= $discountPrice) {
			if ($user->GetBalance () >= $discountPrice) {
				$user->AddMoney ( ($discountPrice * - 1), new Business_Enum_Money ( 'ORDER_OUT' ), 1, $paymentMethod, null, $order );
			}
			
			if ($discountPrice > $user->GetBalance ()) {
				$paymentVoucherMoney = $discountPrice - $user->GetBalance ();
				$user->AddMoney ( ($user->GetBalance () * - 1), new Business_Enum_Money ( 'ORDER_OUT' ), 1, $paymentMethod, null, $order );
				$user->AddMoney ( ($paymentVoucherMoney * - 1), new Business_Enum_Money ( 'ORDER_OUT' ), 1, $paymentMethod, null, $order );
			}
		}
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