<?php

class Business_User_Staff_Base extends Business_User_Base {

	/**
	 * 新的店員
	 * 
	 * @param Business_User_Store $store        	
	 * @param string $userName        	
	 * @param string $password        	
	 * @return boolean
	 */
	public function CreatePlayer(Business_User_Store $store, $userName, $password) {
		if ($this->GetId () == 0) {
			$systemUser = $this->addSystemUser ( $userName, $password );
			if ($systemUser->GetId () > 0) {
				$role = 2;
				
				$this->SetRole ( $role );
				$this->SetStore ( $store );
				$this->SetSystemUser ( $systemUser );
				$this->Save ();
				
				return true;
			} else {
				// LOGIC_ERROR
				return false;
			}
		}
		// PARAMETER_ERROR
		return false;
	}


	/**
	 * 获取menu列表
	 *
	 * @return multitype:
	 */
	public function GetMenuList() {
		return $this->getMenuList();
	}
}