<?php

class Business_Promotions_Tool {

	public static function GetPromotionsFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_Promotions_Base ( $id );
		$nowTime = date ( 'Y-m-d H:i:s' );
		$isActive = $instance->GetStartTime () <= $nowTime && $instance->GetEndTime () >= $nowTime ? true : false;
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['title'] = $instance->GetTitle ();
		$valueData ['startTime'] = $instance->GetStartTime ();
		$valueData ['endTime'] = $instance->GetEndTime ();
		$valueData ['rechargeMoney'] = $instance->GetRechargeMoney ();
		$valueData ['voucherMoney'] = $instance->GetVoucherMoney ();
		$valueData ['isActive'] = $isActive;
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetPromotionsListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetPromotionsFieldData ( $id );
		}
		return $listCollection;
	}
}