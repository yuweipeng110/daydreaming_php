<?php

/**
 * 字典表索引
 * 
 * @author xy
 */
class Object_User_Indexing {

	/**
	 * 通过ADMIN用户ID获取USER对象
	 *
	 * @param string $index        	
	 * @return Object_Token_User
	 */
	public static function GetUserObejctFromAdminUserId($index = null) {
		$indexing = new Data_Index ( PROJECT . "_201", "F3_A201", $index );
		if ($indexing->GetId () == 0) {
			return null;
		} else {
			return new Object_User_Base ( $indexing->GetId () );
		}
	}
}