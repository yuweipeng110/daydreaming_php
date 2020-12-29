<?php

class Business_Script_OrderDetail extends Object_Script_OrderDetail {

	public function CreateOrderDetail(Business_Script_Order $order, Business_User_Base $user, $isPay) {
		if ($this->GetId () == 0) {
			$formatPrice = $order->GetScript ()->GetFormatPrice ();
			
			$this->SetOrder ( $order );
			$this->SetUser ( $user );
			$this->SetUnitPrice ( $formatPrice );
			$this->SetIsPay ( $isPay );
			$this->SetDiscount ( 1 );
			$this->Save ();
			
			return $this;
		}
		return null;
	}

	public function ChangeOrderDetail($isPay, $discount, $settlementPrice) {
		if ($this->GetId () > 0) {
			$this->SetIsPay ( $isPay );
			$this->SetDiscount ( $discount );
			$this->SetSettlementPrice ( $settlementPrice );
			$this->Save ();
			
			return true;
		}
		return false;
	}
}