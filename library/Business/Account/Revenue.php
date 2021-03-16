<?php

class Business_Account_Revenue extends Object_Account_Revenue {

	public function CreateRevenue(Business_User_Base $user, $changeMoney, $remarkIncrease, $remarkReduce, $changeType, Business_User_Store $store, Business_Script_Order $order = null, Business_Option_PaymentMethod $paymentMethod) {
		if ($this->GetId () == 0) {
			$this->SetUser ( $user );
			$this->SetChangeMoney ( $changeMoney );
			$this->SetChangeTime ( date ( 'Y-m-d H:i:s' ) );
			$this->SetRemarkIncrease ( $remarkIncrease );
			$this->SetRemarkReduce ( $remarkReduce );
			$this->SetChangeType ( $changeType );
			$this->SetStore ( $store );
			if ($order != null) {
				$this->SetOrder ( $order );
			}
			$this->SetPaymentMethod ( $paymentMethod );
			$this->Save ();
			
			return $this;
		}
		return null;
	}
}