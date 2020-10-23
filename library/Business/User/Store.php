<?php

class Business_User_Store extends Object_User_Store {

	/**
	 * 新的门店
	 *
	 * @param string $name        	
	 * @param string $status        	
	 * @param string $phone        	
	 * @param string $address        	
	 * @return boolean
	 */
	public function CreateStore($name, $status, $phone, $address) {
		if ($this->GetId () == 0) {
			$this->SetName ( $name );
			$this->SetStatus ( $status );
			$this->SetPhone ( $phone );
			$this->SetAddress ( $address );
			$this->Save ();
			
			return $this;
		}
		return null;
	}
	
	public function SetStoreBoss(Business_User_Boss_Base $boss){
		if($this->GetId() > 0){
			$this->SetBoss($boss);
			$this->Save();
			
			return true;
		}
		return false;
	}
}