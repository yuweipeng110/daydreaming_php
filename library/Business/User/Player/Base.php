<?php

class Business_User_Player_Base extends Business_User_Base {

	/**
	 * 新的玩家
	 *
	 * @param Business_User_Store $store        	
	 * @return boolean
	 */
	public function CreatePlayer(Business_User_Store $store, $nickname, $sex, $phone, $remark) {
		if ($this->GetId () == 0) {
			$role = 3;
			
			$this->SetRole ( $role );
			$this->SetStore ( $store );
			$this->SetNickname ( $nickname );
			$this->SetSex ( $sex );
			$this->SetPhone ( $phone );
			$this->SetRemark ( $remark );
			$this->Save ();
			
			return $this;
		}
		// PARAMETER_ERROR
		return null;
	}

	/**
	 * 总积分
	 *
	 * @return number
	 */
	public function GetTotalIntegral() {
		return 0;
	}

	/**
	 * 可用积分
	 *
	 * @return number
	 */
	public function GetActiveIntegral() {
		return 0;
	}
}