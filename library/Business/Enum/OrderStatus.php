<?php

/**
 * 订单状态枚举
 * 
 * @author xy
 *
 */
class Business_Enum_OrderStatus {

	public static function GetValue($value) {
		$list = self::getDescriptionList ();
		if (array_key_exists ( $value, self::getDescriptionList () )) {
			return $value;
		}
		return "";
	}

	public static function GetDescription($typeCode) {
		$list = self::getDescriptionList ();
		if (array_key_exists ( $typeCode, $list )) {
			return $list [$typeCode];
		}
		return "";
	}

	public static function GetDescriptionList() {
		$list = array (
				10 => '进行中',
				20 => '完成' 
		);
		return $list;
	}
}