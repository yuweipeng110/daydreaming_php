<?php

class Business_User_Tool {

	public static function GetSystemUserFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new System_Admin_User ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['userName'] = $instance->GetUserName ();
		$valueData ['password'] = $instance->GetPassword ();
		$valueData ['realName'] = $instance->GetRealName ();
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetUserFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_User_Base ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['role'] = $instance->GetRole ();
		$valueData ['storeId'] = $instance->GetStore ()->GetId ();
		$valueData ['nickname'] = $instance->GetNickname ();
		$valueData ['sex'] = $instance->GetSex ();
		$valueData ['phone'] = $instance->GetPhone ();
		$valueData ['birthday'] = $instance->GetBirthday ();
		$valueData ['killerRanking'] = $instance->GetKillerRanking ();
		$valueData ['killerIntegral'] = $instance->GetKillerIntegral ();
		$valueData ['killerTitle'] = $instance->GetKillerTitle ();
		$valueData ['detectiveRanking'] = $instance->GetDetectiveRanking ();
		$valueData ['detectiveIntegral'] = $instance->GetDetectiveIntegral ();
		$valueData ['detectiveTitle'] = $instance->GetDetectiveTitle ();
		$valueData ['peopleRanking'] = $instance->GetPeopleRanking ();
		$valueData ['peopleIntegral'] = $instance->GetPeopleIntegral ();
		$valueData ['peopleTitle'] = $instance->GetPeopleTitle ();
		$valueData ['totalRanking'] = $instance->GetTotalRanking ();
		$valueData ['totalIntegral'] = $instance->GetTotalIntegral ();
		$valueData ['totalTitle'] = $instance->GetTotalTitle ();
		$valueData ['activeIntegral'] = $instance->GetActiveIntegral ();
		$valueData ['remark'] = $instance->GetRemark ();
		$valueData ['otime'] = $instance->GetOtime ();
		$valueData ['accountBalance'] = $instance->GetBalance ();
		$valueData ['voucherBalance'] = $instance->GetVoucherBalance ();
		
		return $valueData;
	}

	public static function GetUserListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetUserFieldData ( $id );
		}
		return $listCollection;
	}

	public static function GetStoreFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_User_Store ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['storeName'] = $instance->GetName ();
		$valueData ['status'] = $instance->GetStatus () == 1 ? true : false;
		$valueData ['phoneNumber'] = $instance->GetPhone ();
		$valueData ['address'] = $instance->GetAddress ();
		if ($instance->GetBoss () != null) {
			$valueData ['bossId'] = $instance->GetBoss ()->GetId ();
			$valueData ['bossInfo'] = self::GetSystemUserFieldData ( $instance->GetBoss ()->GetSystemUser ()->GetId () );
		}
		
		return $valueData;
	}

	public static function GetStoreListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetStoreFieldData ( $id );
		}
		return $listCollection;
	}

	public static function GetRoleFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_User_Role ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['title'] = $instance->GetTitle ();
		$valueData ['maxAddIntegral'] = ( int ) $instance->GetMaxAddIntegral ();
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetRoleListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetRoleFieldData ( $id );
		}
		return $listCollection;
	}

	public static function GetRankFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_User_Rank ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['title'] = $instance->GetTitle ();
		$roleId = 0;
		$roleTitle = '';
		if ($instance->GetRole () != null) {
			$roleId = $instance->GetRole ()->GetId ();
			$roleTitle = $instance->GetRole ()->GetTitle ();
		}
		$valueData ['roleId'] = $roleId;
		$valueData ['roleTitle'] = $roleTitle;
		$valueData ['integral'] = $instance->GetIntegral ();
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetRankListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetRankFieldData ( $id );
		}
		return $listCollection;
	}
}