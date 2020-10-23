<?php
class Business_Webpage_Signin {
	
	/**
	 * 登陸驗證
	 *
	 * @param string $userName        	
	 * @param string $password        	
	 * @return boolean
	 */
	public function LoginCheck($userName, $password) {
		$signin = new System_Admin_Signin ();
		$id = $signin->CheckUser ( $userName, $password );
		if ($id > 0) {
			return true;
		}
		return false;
	}
}