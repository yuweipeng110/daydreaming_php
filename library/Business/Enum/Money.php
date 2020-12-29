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
				'MANUAL_IN' => '手动充值',
				'MANUAL_OUT' => '手动支付',
				'WECHAT_QRCODE_IN' => '微信二维码充值',
				'WECHAT_QRCODE_OUT' => '微信二维码支付',
				'PROMOTIONS_IN' => '活动抵用卷赠送',
				'PROMOTIONS_OUT' => '活动抵用卷支付',
				'ORDER_OUT' => '订单支付',
		);
		return $list;
	}
}