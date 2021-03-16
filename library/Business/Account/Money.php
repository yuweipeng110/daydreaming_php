<?php

class Business_Account_Money extends Object_Account_Money {

	public function CreateMoney(Business_User_Base $user, $changeIntegral, $remarkIncrease, $remarkReduce, $changeType, Business_Option_PaymentMethod $paymentMethod, Business_Promotions_Base $promotions = null, Business_Script_Order $order = null) {
		if ($this->GetId () == 0) {
			$this->SetUser ( $user );
			$this->SetChangeMoney ( $changeIntegral );
			$this->SetChangeTime ( date ( 'Y-m-d H:i:s' ) );
			$this->SetRemarkIncrease ( $remarkIncrease );
			$this->SetRemarkReduce ( $remarkReduce );
			$this->SetChangeType ( $changeType );
			if ($paymentMethod != null) {
				$this->SetPaymentMethod ( $paymentMethod );
			}
			if ($promotions != null) {
				$this->SetPromotions ( $promotions );
			}
			if ($order != null) {
				$this->SetOrder ( $order );
			}
			$this->Save ();
			
			return $this;
		}
		return null;
	}

	public function DetectPromotionsVoucherProcess(Business_User_Base $user, $rechargeMoney) {
		$nowTime = date ( 'Y-m-d H:i:s' );
		$promotionsList = Business_Promotions_List::GetOpenPromotionsList ();
		foreach ( $promotionsList as $id ) {
			$promotions = new Business_Promotions_Base ( $id );
			if ($promotions->GetStartTime () <= $nowTime && $promotions->GetEndTime () >= $nowTime) {
				if ($rechargeMoney >= $promotions->GetRechargeMoney ()) {
					$voucherMoney = $promotions->GetVoucherMoney ();
					$changeMode = new Business_Enum_Money ( 'PROMOTIONS_IN' );
					$remarkIncrease = "PROMOTIONS_IN";
					$remarkReduce = "";
					$changeType = 2;
					$paymentMethod = new Business_Option_PaymentMethod ( 6 );
					$order = null;
					
					$account = new Business_Account_Money ();
					$account->CreateMoney ( $user, $voucherMoney, $remarkIncrease, $remarkReduce, $changeType, $paymentMethod, $promotions, $order );
					// $user->AddMoney ( $voucherMoney, $changeMode, $changeType, null, $promotions );
					$voucherObject = new Business_Promotions_Voucher ();
					$voucherObject->CreateVoucher ( $user, $voucherMoney, $promotions );
					break;
				}
			}
		}
	}
}