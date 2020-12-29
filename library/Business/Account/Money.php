<?php

class Business_Account_Money extends Object_Account_Money {

	public function CreateMoney(Business_User_Base $user, $changeIntegral, $remarkIncrease, $remarkReduce, $changeType, Business_Promotions_Base $promotions = null, Business_Script_Order $order = null) {
		if ($this->GetId () == 0) {
			$this->SetUser ( $user );
			$this->SetChangeMoney ( $changeIntegral );
			$this->SetChangeTime ( date ( 'Y-m-d H:i:s' ) );
			$this->SetRemarkIncrease ( $remarkIncrease );
			$this->SetRemarkReduce ( $remarkReduce );
			$this->SetChangeType ( $changeType );
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
		$promotionsList = Business_Promotions_List::GetPromotionsList ();
		foreach ( $promotionsList as $id ) {
			$promotions = new Business_Promotions_Base ( $id );
			if ($promotions->GetStartTime () <= $nowTime && $promotions->GetEndTime () >= $nowTime) {
				if ($rechargeMoney >= $promotions->GetRechargeMoney ()) {
					$voucherMoney = $promotions->GetVoucherMoney ();
					$changeMode = new Business_Enum_Money ( 'PROMOTIONS_IN' );
					$changeType = 2;
					
					$user->AddMoney ( $voucherMoney, $changeMode, $changeType, $promotions );
					$voucherObject = new Business_Promotions_Voucher ();
					$voucherObject->CreateVoucher ( $user, $voucherMoney, $promotions );
					break;
				}
			}
		}
	}
}