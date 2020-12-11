<?php

class Business_Script_Tool {

	public static function GetScriptFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_Script_Base ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['title'] = $instance->GetTitle ();
		$valueData ['storeId'] = $instance->GetStore ()->GetId ();
		$valueData ['type'] = $instance->GetType ();
		$valueData ['amount'] = $instance->GetAmount ();
		$valueData ['image'] = $instance->GetImage ();
		$valueData ['costPrice'] = $instance->GetCostPrice ();
		$valueData ['formatPrice'] = $instance->GetFormatPrice ();
		$valueData ['description'] = $instance->GetDescription ();
		$valueData ['applicableNumber'] = $instance->GetApplicableNumber ();
		$valueData ['gameTime'] = $instance->GetGameTime ();
		$valueData ['isAdapt'] = $instance->GetIsAdapt ();
		$valueData ['adaptContent'] = $instance->GetAdaptContent ();
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetScriptListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetScriptFieldData ( $id );
		}
		return $listCollection;
	}

	public static function GetOrderFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_Script_Order ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['orderNo'] = $instance->GetOrderNo ();
		if (! is_null ( $instance->GetScript () )) {
			$valueData ['scriptId'] = $instance->GetScript ()->GetId ();
			$valueData ['scriptInfo'] = Business_Script_Tool::GetScriptFieldData ( $instance->GetScript ()->GetId () );
		}
		$valueData ['scriptTitle'] = $instance->GetScript ()->GetTitle ();
		$valueData ['storeId'] = $instance->GetStore ()->GetId ();
		if (! is_null ( $instance->GetDesk () )) {
			$valueData ['deskId'] = $instance->GetDesk ()->GetId ();
			$valueData ['deskInfo'] = Business_Script_Tool::GetDeskFieldData ( $instance->GetDesk ()->GetId () );
		}
		if (! is_null ( $instance->GetHost () )) {
			$valueData ['hostId'] = $instance->GetHost ()->GetId ();
			$valueData ['hostInfo'] = Business_User_Tool::GetUserFieldData ( $instance->GetHost ()->GetId () );
		}
		$valueData ['receivableMoney'] = $instance->GetReceivableMoney ();
		$valueData ['realMoney'] = $instance->GetRealMoney ();
		if (! is_null ( $instance->GetOrderOperator () )) {
			$valueData ['orderOperatorId'] = $instance->GetOrderOperator ()->GetId ();
			$valueData ['orderOperatorInfo'] = Business_User_Tool::GetUserFieldData ( $instance->GetOrderOperator ()->GetId () );
		}
		$valueData ['orderTime'] = $instance->GetOrderTime ();
		if (! is_null ( $instance->GetSettlementOperator () )) {
			$valueData ['settlementOperatorId'] = $instance->GetSettlementOperator ()->GetId ();
			$valueData ['settlementOperatorInfo'] = Business_User_Tool::GetUserFieldData ( $instance->GetSettlementOperator ()->GetId () );
		}
		$valueData ['settlementTime'] = $instance->GetSettlementTime ();
		$valueData ['status'] = $instance->GetStatus ();
		$valueData ['statusDescription'] = Business_Enum_OrderStatus::GetDescription ( $instance->GetStatus () );
		$valueData ['remark'] = $instance->GetRemark ();
		// $valueData ['paymentMethodId'] = $instance->GetPaymentMethod ()->GetId ();
		// if (! is_null ( $instance->GetPaymentMethod () )) {
		// // $valueData ['paymentMethodInfo'] = $instance->GetPaymentMethod ()->GetTitle ();
		// }
		$valueData ['otime'] = $instance->GetOtime ();
		
		$detailList = array ();
		foreach ( Business_Script_List::GetOrderDetailListByOrder ( $id ) as $detailId ) {
			$detailList [] = self::GetOrderDetailFieldData ( $detailId );
		}
		$valueData ['detailList'] = $detailList;
		
		return $valueData;
	}

	public static function GetOrderListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetOrderFieldData ( $id );
		}
		return $listCollection;
	}

	public static function GetOrderDetailFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_Script_OrderDetail ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['orderId'] = $instance->GetOrder ()->GetId ();
		$valueData ['userId'] = $instance->GetUser () == null ? 0 : $instance->GetUser ()->GetId ();
		if (! is_null ( $instance->GetUser () )) {
			$valueData ['userInfo'] = Business_User_Tool::GetUserFieldData ( $instance->GetUser ()->GetId () );
		}
		$valueData ['unitPrice'] = $instance->GetUnitPrice ();
		$valueData ['isPay'] = $instance->GetIsPay ();
		$valueData ['discount'] = $instance->GetDiscount ();
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetOrderDetailListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetOrderDetailFieldData ( $id );
		}
		return $listCollection;
	}

	public static function GetDeskFieldData($id) {
		$instance = new Business_Script_Desk ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['title'] = $instance->GetTitle ();
		$valueData ['isEnabled'] = $instance->GetIsEnabled ();
		$valueData ['storeId'] = $instance->GetStore () == null ? 0 : $instance->GetStore ()->GetId ();
		$valueData ['storeName'] = $instance->GetStore () == null ? '' : $instance->GetStore ()->GetName ();
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetDeskListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetDeskFieldData ( $id );
		}
		return $listCollection;
	}

	public static function GetDeskOrderListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $key => $value ) {
			$listCollection [$key] = self::GetDeskFieldData ( $value ['ID'] );
			$listCollection [$key] ['orderInfo'] = self::GetOrderFieldData ( $value ['ORDER_ID'] );
		}
		return $listCollection;
	}
}