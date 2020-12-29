<?php

class Business_Promotions_Voucher extends Object_Promotions_Voucher {

	public function CreateVoucher(Business_User_Base $user, $voucherMoney, Business_Promotions_Base $promotions) {
		if ($this->GetId () == 0) {
			$activationMode = 1;
			
			$this->SetUser ( $user );
			$this->SetVoucherMoney ( $voucherMoney );
			$this->SetActivationTime ( date ( 'Y-m-d H:i:s' ) );
			$this->SetActivationMode ( $activationMode );
			$this->SetPromotions ( $promotions );
			$this->Save ();
			
			return $this;
		}
		return null;
	}
}