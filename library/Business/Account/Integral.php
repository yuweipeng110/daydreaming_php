<?php

class Business_Account_Integral extends Object_Account_Integral {

	public function CreateIntegral(Business_User_Base $user, $changeIntegral, $remarkIncrease, $remarkReduce, Business_User_Role $role) {
		if ($this->GetId () == 0) {
			$this->SetUser ( $user );
			$this->SetChangeIntegral ( $changeIntegral );
			$this->SetChangeTime ( date ( 'Y-m-d H:i:s' ) );
			$this->SetRemarkIncrease ( $remarkIncrease );
			$this->SetRemarkReduce ( $remarkReduce );
			$this->SetRole ( $role );
			$this->Save ();
			
			return $this;
		}
		return null;
	}
}