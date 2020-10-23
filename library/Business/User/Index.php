<?php
class Business_User_Index{


	/**
	 * 通过门店ID获取用户对象
	 *
	 * @param string $deviceMAC
	 * @return Business_Device_Base
	 */
	public static function GetStoreIdFromUser($store) {
		$indexing = new Data_Index ( PROJECT .  "_201", "F2_A201", $store->GetId() );
		if ($indexing->GetId () == 0) {
			return null;
		} else {
			return new Business_User_Base ( $indexing->GetId () );
		}
	}
}