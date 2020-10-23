<?php

/**
 * 可以解析XML和JSON格式的数据
* 先判断是XML格式还是JSON格式的数据,然后解析
* 返回解析后的数据,格式为array
 * @author skendy  2008-12-16
 */
class CheckString {
	var $arr;
	public $mark;
	
	/**
	 * 解析函数,判断字符串格式
	 *
	 * @param string $str        	
	 */
	function __construct($str) {
		if ($this->mark = $this->xml_parser ( $str )) {
			$this->arr = $this->mark;
		} elseif ($this->mark = $this->json_parser ( $str )) {
			$this->arr = $this->mark;
		} else {
			$this->arr = 'NULL';
		}
	}
	
	/**
	 * 解析XML格式的字符串
	 *
	 * @param string $str        	
	 * @return 解析正确就返回解析结果,否则返回false,说明字符串不是XML格式
	 */
	public static function xml_parser($str) {
		$xml_parser = xml_parser_create ();
		if (! xml_parse ( $xml_parser, $str, true )) {
			xml_parser_free ( $xml_parser );
			return false;
		} else {
			return (json_decode ( json_encode ( simplexml_load_string ( $str ) ), true ));
		}
	}
	
	/**
	 * 解析JSON格式的字符串
	 *
	 * @param string $str        	
	 * @return 解析正确就返回解析结果,否则返回false,说明字符串不是JSON格式
	 */
	public static function json_parser($str) {
		$arr = json_decode ( $str, true );
		if (gettype ( $arr ) != "array") {
			return false;
		} else {
			return $arr;
		}
	}
	
	/**
	 * 也有可能既不是XML也不是JSON数据
	 *
	 * @param string $str        	
	 * @return unknown
	 */
	public static function string_parser($str) {
		$strArr = explode ( "&", $str );
		$len = @count ( $strArr );
		if ($len < 1) {
			return false;
		} else {
			return false;
		}
	}
	
	/**
	 * 返回解析的结果
	 */
	function display() {
		return $this->arr;
	}
}