<?php
class XmlData {
	public static function LoadDecryption($string = null) {
		if (! empty ( $string )) {
			$xml = substr ( Format::FormatStreamDecrypt ( $string ), 8 );
			if (! empty ( $xml )) {
				if (simplexml_load_string ( $xml )) {
					$dom = new DOMDocument ();
					if ($dom->loadXML ( $xml )) {
						return $dom;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public static function LoadNotDecrypt($string = null) {
		$xml = $string;
		if (! empty ( $xml )) {
			if (simplexml_load_string ( $xml )) {
				$dom = new DOMDocument ();
				if ($dom->loadXML ( $xml )) {
					return $dom;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public static function ResultEncryption(array $array) {
		$xml = Func::RandomKeys ( 8 ) . "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
		$xml .= "<root>";
		$xml .= XmlData::ArrayToXml ( $array );
		$xml .= "</root>";
		return Format::FormatStreamEncrypt ( $xml );
	}
	public static function ResultNotEncrypt(array $array) {
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
		$xml .= "<root>";
		$xml .= XmlData::ArrayToXml ( $array );
		$xml .= "</root>";
		return $xml;
	}
	public static function ArrayToXml(array $array) {
		$node = "";
		foreach ( $array as $key => $value ) {
			$node .= "<" . (is_numeric ( $key ) ? "List" : $key) . ">";
			if (is_array ( $value )) {
				$node .= XmlData::ArrayToXml ( $value );
			} else {
				$node .= htmlspecialchars ( $value );
			}
			$node .= "</" . (is_numeric ( $key ) ? "List" : $key) . ">";
		}
		return $node;
	}
	public static function XmlToArray($xmlData = array()) {
		return ( array ) simplexml_load_string ( $xmlData, 'SimpleXMLElement', LIBXML_NOCDATA );
	}
}