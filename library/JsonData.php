<?php
class JsonData {
	public static function LoadDecryption($string = null) {
		if (! empty ( $string )) {
			$json = substr ( Format::FormatStreamDecrypt ( $string ), 8 );
			if (! empty ( $json )) {
				return $json;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public static function LoadNotDecrypt($string = null) {
		$json = $string;
		if (! empty ( $json )) {
			return $json;
		} else {
			return false;
		}
	}
	public static function ResultEncryption(array $array) {
		$xml = Func::RandomKeys ( 8 );
		$xml .= JsonData::ArrayToJson ( $array );
		return Format::FormatStreamEncrypt ( $xml );
	}
	public static function ResultNotEncrypt(array $array) {
		$xml = JsonData::ArrayToJson ( $array );
		return $xml;
	}
	public static function ArrayToJson(array $array) {
		return Zend_Json::encode ( $array );
	}
}