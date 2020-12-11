<?php

class Business_Script_OrderDetailIntegral extends Object_Script_OrderDetailIntegral {

	public function CreateOrderDetailIntegral(Business_Script_OrderDetail $orderDetail, Business_User_Role $role, $integral) {
		if ($this->GetId () == 0) {
			$this->SetOrderDetail ( $orderDetail );
			$this->SetRole ( $role );
			$this->SetIntegral ( $integral );
			$this->Save ();
			
			return $this;
		}
		return null;
	}
}