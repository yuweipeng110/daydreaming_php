<?php

/**
 * 字典表索引
 * 
 * @author xy
 */
class System_Admin_Indexing {

	/**
	 * 通过系统用户TOKEN获取系统用户对象
	 *
	 * @param string $index        	
	 * @return System_Admin_User
	 */
	public static function GetTokenObejctFromAdminUserToken($index = null) {
		$indexing = new Data_Index ( PROJECT . "_101", "F5_A101", $index );
		if ($indexing->GetId () == 0) {
			return null;
		} else {
			return new System_Admin_User ( $indexing->GetId () );
		}
	}
}