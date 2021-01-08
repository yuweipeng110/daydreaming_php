<?php

class Business_Option_Tool {

	public static function GetPaymentMethodFieldData($id) {
		if ($id <= 0) {
			return array ();
		}
		$instance = new Business_Option_ParmentMethod ( $id );
		
		$valueData = array ();
		$valueData ['id'] = $instance->GetId ();
		$valueData ['title'] = $instance->GetTitle ();
		$valueData ['otime'] = $instance->GetOtime ();
		
		return $valueData;
	}

	public static function GetPaymentMethodListFieldData($list) {
		$listCollection = array ();
		foreach ( $list as $id ) {
			$listCollection [] = self::GetPaymentMethodFieldData ( $id );
		}
		return $listCollection;
	}
}