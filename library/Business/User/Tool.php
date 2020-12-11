<?php

class Business_User_Tool {

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
		$valueData ['killerIntegral'] = $instance->GetKillerIntegral ();
		$valueData ['detectiveIntegral'] = $instance->GetDetectiveIntegral ();
		$valueData ['peopleIntegral'] = $instance->GetPeopleIntegral ();
		$valueData ['remark'] = $instance->GetRemark ();
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetUserListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetUserFieldData ( $id );
		}
		return $listCollection;
	}

	public static function GetPlayerFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_User_Player_Base ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['nickname'] = $instance->GetNickname ();
		$valueData ['sex'] = $instance->GetSex ();
		$valueData ['phone'] = $instance->GetPhone ();
		$valueData ['killerIntegral'] = $instance->GetKillerIntegral ();
		$valueData ['detectiveIntegral'] = $instance->GetDetectiveIntegral ();
		$valueData ['peopleIntegral'] = $instance->GetPeopleIntegral ();
		$valueData ['totalIntegral'] = $instance->GetTotalIntegral ();
		$valueData ['activeIntegral'] = $instance->GetActiveIntegral ();
		$valueData ['remark'] = $instance->GetRemark ();
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetPlayerListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetPlayerFieldData ( $id );
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
		$userName = '';
		$password = '';
		$realName = '';
		if ($instance->GetBoss () != null) {
			$systemUser = $instance->GetBoss ()->GetSystemUser ();
			$userName = $systemUser->GetUserName ();
			$password = $systemUser->GetPassword ();
			$nickname = $instance->GetBoss ()->GetNickname ();
		}
		$valueData ['userName'] = $userName;
		$valueData ['passWord'] = $password;
		$valueData ['realName'] = $realName;
		
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
		$valueData ['maxAddIntegral'] = (int) $instance->GetMaxAddIntegral ();
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