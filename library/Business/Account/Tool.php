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

	public static function GetRevenueListFieldData($list) {
		$listCollection = array ();
		
		$changeMoney = 0;
		$orderCount = 0;
		foreach ( $list as $id ) {
			$valueData = self::GetRevenueFieldData ( $id );
			$listCollection ['dataList'] [] = $valueData;
			$changeMoney += $valueData ['changeMoney'];
			$orderCount += $valueData ['orderId'] > 0 ? 1 : 0;
		}
		$totalData = array (
				'totalChangeMoney' => sprintf ( "%.2f", $changeMoney ),
				'totalDataCount' => count ( $list ),
				'totalOrderCount' => $orderCount 
		);
		$listCollection ['statisticsData'] = $totalData;
		
		return $listCollection;
	}

	public static function GetRevenueFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_Account_Revenue ( $id );
		
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
		$storeId = 0;
		$storeInfo = array ();
		if ($instance->GetStore () != null) {
			$storeId = $instance->GetStore ()->GetId ();
			$storeInfo = Business_User_Tool::GetStoreFieldData ( $instance->GetStore ()->GetId () );
		}
		$valueData ['storeId'] = $storeId;
		$valueData ['storeInfo'] = $storeInfo;
		$orderId = 0;
		$orderInfo = array ();
		if ($instance->GetOrder () != null) {
			$orderId = $instance->GetOrder ()->GetId ();
			$orderInfo = Business_Script_Tool::GetOrderFieldData ( $instance->GetOrder ()->GetId () );
		}
		$valueData ['orderId'] = $orderId;
		$valueData ['orderInfo'] = $orderInfo;
		$paymentMethodId = 0;
		$paymentMethodInfo = array ();
		if ($instance->GetPaymentMethod () != null) {
			$paymentMethodId = $instance->GetPaymentMethod ()->GetId ();
			$paymentMethodInfo = Business_Option_Tool::GetPaymentMethodFieldData ( $instance->GetPaymentMethod ()->GetId () );
		}
		$valueData ['paymentMethodId'] = $paymentMethodId;
		$valueData ['paymentMethodInfo'] = $paymentMethodInfo;
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetUserIntegralFieldDataList($list) {
		$listCollection = array ();
		foreach ( $list as $value ) {
			$listCollection [] = Business_User_Tool::GetUserFieldData ( $value ['USER_ID'] );
		}
		
		return $listCollection;
	}
}