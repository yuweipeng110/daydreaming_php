<?php

class Business_Enum_Money {

	public function __construct($value) {
		if (array_key_exists ( $value, self::getDescriptionList () )) {
			$this->value = $value;
		} else {
			die ( "Business_Enum_Money is null" );
			throw new Exception ();
		}
	}

	public function getValue() {
		return $this->value;
	}

	public function getDescription() {
		$list = self::getDescriptionList ();
		if (array_key_exists ( $this->value, $list )) {
			return $list [$this->value];
		}
		return "";
	}

	public static function getDescriptionList() {
		$list = array (
				'MANUAL_IN' => '手动添加',
				'MANUAL_OUT' => "手动减少"
		);
		return $list;
	}
}