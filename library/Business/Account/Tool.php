<?php

class Business_Account_Tool {

	public static function GetAccountListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetAccountFieldData ( $id );
		}
		return $listCollection;
	}

	public static function GetAccountFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_Account_Money ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$userId = 0;
		$userInfo = array ();
		if ($instance->GetUser () != null) {
			$userId = $instance->GetUser ()->GetId ();
			$userInfo = Business_User_Tool::GetUserFieldData ( $instance->GetUser ()->GetId () );
		}
		$valueData ['userId'] = $userId;
		$valueData ['userInfo'] = $userInfo;
		$valueData ['changeMoney'] = $instance->GetChangeMoney ();
		$valueData ['changeTime'] = $instance->GetChangeTime ();
		$valueData ['remarkIncrease'] = $instance->GetRemarkIncrease ();
		$valueData ['remarkReduce'] = $instance->GetRemarkReduce ();
		$valueData ['changeType'] = $instance->GetChangeType ();
		$promotionsId = 0;
		$promotionsInfo = array ();
		if ($instance->GetPromotions () != null) {
			$promotionsId = $instance->GetPromotions ()->GetId ();
			$promotionsInfo = Business_Promotions_Tool::GetPromotionsFieldData ( $instance->GetPromotions ()->GetId () );
		}
		$valueData ['promotionsId'] = $promotionsId;
		$valueData ['promotionsInfo'] = $promotionsInfo;
		$orderId = 0;
		$orderInfo = array ();
		if ($instance->GetOrder () != null) {
			$orderId = $instance->GetOrder ()->GetId ();
			$orderInfo = Business_Script_Tool::GetOrderFieldData ( $instance->GetOrder ()->GetId () );
		}
		$valueData ['orderId'] = $orderId;
		$valueData ['orderInfo'] = $orderInfo;
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}
}