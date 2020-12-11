<?php

class Business_Account_Money extends Object_Account_Money {

	public function CreateMoney(Business_User_Base $user, $changeIntegral, $remarkIncrease, $remarkReduce) {
		if ($this->GetId () == 0) {
			$this->SetUser ( $user );
			$this->SetChangeMoney ( $changeIntegral );
			$this->SetChangeTime ( date ( 'Y-m-d H:i:s' ) );
			$this->SetRemarkIncrease ( $remarkIncrease );
			$this->SetRemarkReduce ( $remarkReduce );
			$this->Save ();
			
			return $this;
		}
		return null;
	}
}