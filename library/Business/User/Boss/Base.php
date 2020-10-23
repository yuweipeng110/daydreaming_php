<?php
class Business_User_Boss_Base extends Business_User_Base {
	
	/**
	 * 新的BOSS
	 *
	 * @param Business_User_Store $store        	
	 * @param string $userName        	
	 * @param string $password        	
	 * @param string $realName        	
	 * @return boolean
	 */
	public function CreateBoss(Business_User_Store $store, $userName, $password,$realName) {
		if ($this->GetId () == 0) {
			$systemUser = $this->addSystemUser($userName, $password);
			if ($systemUser->GetId () > 0) {
				$role = 1;
				
				$this->SetRole ( $role );
				$this->SetStore ( $store );
				$this->SetSystemUser ( $systemUser );
				$this->SetRealName($realName);
				$this->Save ();
				
				return $this;
			} else {
				// LOGIC_ERROR
				return null;
			}
		}
		// PARAMETER_ERROR
		return null;
	}
	
	/**
	 * 获取menu列表
	 *
	 * @return array
	 */
	public function GetMenuList() {
		return $this->getSystemMenuList();
	}
}