<?php

class Business_Script_List {

	public static function GetScriptList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_301" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function SearchScriptList($storeId, $title, $type, $applicableNumber, $isAdapt) {
		$storeString = $storeId == "" ? "" : " AND F2_A301=$storeId";
		$titleString = $title == "" ? "" : " AND F1_A301 LIKE '%$title%'";
		$typeString = $type == "" ? "" : " AND F3_A301 LIKE '%$type%'";
		$applicableNumberString = $applicableNumber == "" ? "" : " AND F8_A301=$applicableNumber";
		$isAdaptString = $isAdapt == "" ? "" : " AND F10_A301=$isAdapt";
		
		$sqlString = "SELECT ID FROM A_301 WHERE 1=1
		$storeString
		$titleString
		$typeString
		$applicableNumberString
		$isAdaptString
		ORDER BY OTIME DESC";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sqlString );
		$objectList = array ();
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetScriptFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$instance = new Business_Script_Base ( $id );
			
			$valueData = array ();
			$valueData ['id'] = $instance->GetId ();
			$valueData ['title'] = $instance->GetTitle ();
			$valueData ['storeId'] = $instance->GetStore ()->GetId ();
			$valueData ['type'] = $instance->GetType ();
			$valueData ['amount'] = $instance->GetAmount ();
			$valueData ['image'] = $instance->GetImage ();
			$valueData ['costPrice'] = $instance->GetCostPrice ();
			$valueData ['description'] = $instance->GetDescription ();
			$valueData ['applicableNumber'] = $instance->GetApplicableNumber ();
			$valueData ['gameTime'] = $instance->GetGameTime ();
			$valueData ['isAdapt'] = $instance->GetIsAdapt ();
			$valueData ['adaptContent'] = $instance->GetAdaptContent ();
			$valueData ['otime'] = $instance->GetOtime ();
			
			$listCollection [] = $valueData;
		}
		return $listCollection;
	}

	public static function GetOrderList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_302" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetOrderFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$instance = new Business_Script_Order ( $id );
			
			$valueData = array ();
			$valueData ['id'] = $instance->GetId ();
			$valueData ['orderNo'] = $instance->GetOrderNo ();
			$valueData ['scriptId'] = $instance->GetScript ()->GetId ();
			$valueData ['scriptTitle'] = $instance->GetScript ()->GetTitle ();
			$valueData ['storeId'] = $instance->GetStore ()->GetId ();
			$valueData ['deskId'] = $instance->GetDesk ()->GetId ();
			$valueData ['deskTitle'] = $instance->GetDesk ()->GetTitle ();
			$valueData ['receivableMoney'] = $instance->GetReceivableMoney ();
			$valueData ['realMoney'] = $instance->GetRealMoney ();
			$valueData ['orderOperatorId'] = $instance->GetOrderOperator ()->GetId ();
			$valueData ['orderOperatorNickname'] = $instance->GetOrderOperator ()->GetNickname ();
			$valueData ['orderTime'] = $instance->GetOrderTime ();
			if (! is_null ( $instance->GetSettlementOperator () )) {
				$valueData ['settlementOperatorId'] = $instance->GetSettlementOperator ()->GetId ();
				$valueData ['settlementOperatorTitle'] = $instance->GetSettlementOperator ()->GetNickname ();
			}
			$valueData ['settlementTime'] = $instance->GetSettlementTime ();
			$valueData ['status'] = $instance->GetStatus ();
			$valueData ['statusDescription'] = Business_Enum_OrderStatus::GetDescription ( $instance->GetStatus () );
			$valueData ['remark'] = $instance->GetRemark ();
			// if (! is_null ( $instance->GetPaymentMethod () )) {
			// $valueData ['paymentMethodId'] = $instance->GetPaymentMethod ()->GetId ();
			// $valueData ['paymentMethodTitle'] = $instance->GetPaymentMethod ()->GetTitle ();
			// }
			$valueData ['otime'] = $instance->GetOtime ();
			
			$listCollection [] = $valueData;
		}
		return $listCollection;
	}

	public static function GetOrderDetailListByOrder($orderId) {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_303" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND F1_A303 = ? ', $orderId );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetOrderDetailFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$instance = new Business_Script_OrderDetail ( $id );
			
			$valueData = array ();
			$valueData ['id'] = $instance->GetId ();
			$valueData ['orderId'] = $instance->GetOrder ()->GetId ();
			$valueData ['userId'] = $instance->GetUser () == null ? 0 : $instance->GetUser ()->GetId ();
			$valueData ['userNickname'] = $instance->GetUser () == null ? '' : $instance->GetUser ()->GetNickname ();
			$valueData ['unitPrice'] = $instance->GetUnitPrice ();
			$valueData ['isMakeUp'] = $instance->GetIsMakeUp ();
			$valueData ['otime'] = $instance->GetOtime ();
			
			$listCollection [] = $valueData;
		}
		return $listCollection;
	}

	public static function GetOrderDetailIntegralByDetailList($detailId) {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_304" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND F1_A304 = ? ', $detailId );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetDeskList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_305" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetEnabledDeskList($storeId, $activate) {
		$activateString = $activate == "" ? "" : " AND TABLE1.F11_A302 = $activate";
		
		$sqlString = "
			SELECT A_305.ID,
			IFNULL(TABLE1.ID,0) AS 'ORDER_ID',
			IFNULL(TABLE1.F12_A302,0) AS 'ORDER_STATE'
			FROM A_305
			
			LEFT JOIN (
				SELECT ID,F4_A302,F12_A302
				FROM A_302
				WHERE F12_A302 = 10
				AND F3_A302 = $storeId
			) AS TABLE1 
			ON A_305.ID = TABLE1.F4_A302
			
			WHERE F2_A305 = 1
			AND F3_A305 = $storeId
			$activateString
			ORDER BY ID DESC
		";
		
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sqlString );
		return $data;
	}

	public static function GetDeskFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$instance = new Business_Script_Desk ( $id );
			
			$valueData = array ();
			$valueData ['id'] = $instance->GetId ();
			$valueData ['title'] = $instance->GetTitle ();
			$valueData ['isEnabled'] = $instance->GetIsEnabled ();
			$valueData ['storeId'] = $instance->GetStore () == null ? 0 : $instance->GetStore ()->GetId ();
			$valueData ['storeName'] = $instance->GetStore () == null ? '' : $instance->GetStore ()->GetName ();
			$valueData ['otime'] = $instance->GetOtime ();
			
			$listCollection [] = $valueData;
		}
		return $listCollection;
	}
}