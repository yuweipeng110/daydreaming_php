<?php
class Format {
	
	/**
	 * 加密
	 *
	 * @param
	 *        	明文
	 * @param
	 *        	密钥
	 * @param
	 *        	向量
	 */
	public static function FormatStreamEncrypt($string, $key = 'jiutianxingchen1', $iv = '!jiutianxingchen') {
		$cipher = mcrypt_module_open ( MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '' );
		
		// $iv = mcrypt_create_iv ( mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC ), MCRYPT_RAND );
		mcrypt_generic_init ( $cipher, $key, $iv );
		$stream = base64_encode ( mcrypt_generic ( $cipher, $string ) );
		// $stream = mcrypt_generic ( $cipher, $string );
		mcrypt_generic_deinit ( $cipher );
		
		return $stream;
	}
	
	/**
	 * 解密
	 *
	 * @param
	 *        	密文
	 * @param
	 *        	密钥
	 * @param
	 *        	向量
	 */
	public static function FormatStreamDecrypt($stream, $key = 'jiutianxingchen1', $iv = '!jiutianxingchen') {
		$cipher = mcrypt_module_open ( MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '' );
		
		// $iv = mcrypt_create_iv ( mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC ), MCRYPT_RAND );
		mcrypt_generic_init ( $cipher, $key, $iv );
		$string = mdecrypt_generic ( $cipher, base64_decode ( $stream ) );
		// $string = mdecrypt_generic ( $cipher, $stream );
		mcrypt_generic_deinit ( $cipher );
		
		return rtrim ( $string, "\0" );
	}
}