<?php

/**
 * 等比缩放上传图片（base64）
 * @author yang
 *
 */
class ImgDispose {

	/**
	 * 图片等比缩放
	 *
	 * @param string $filename        	
	 * @param number $newwidth        	
	 * @param number $newheight        	
	 * @return boolean
	 */
	public static function zoomImg($filename, $newwidth = 480, $newheight = 270) {
		list ( $width, $height ) = getimagesize ( $filename );
		if ($width - $height >= 0) {
			$newheight = $height * ($newwidth / $width);
		} else {
			$newwidth = $width * ($newheight / $height);
		}
		$thumb = imagecreatetruecolor ( $newwidth, $newheight );
		$source = imagecreatefromjpeg ( $filename );
		imagecopyresized ( $thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
		imagejpeg ( $thumb, $filename, 100 );
	}

	/**
	 * 等比自动剪切图片
	 *
	 * @param string $base64String        	
	 * @param number $newwidth        	
	 * @param number $newheight        	
	 * @return multitype:
	 */
	public static function cuptureImg($base64String, $newwidth = 160, $newheight = 90) {
		$data = base64_decode ( $base64String );
		list ( $width, $height ) = @getimagesizefromstring ( $data );
		$thumb = @imagecreatetruecolor ( $newwidth, $newheight );
		$source = @imagecreatefromstring ( $data );
		@imagecopyresampled ( $thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
		ob_start ();
		imagejpeg ( $thumb );
		$buffer = ob_get_contents ();
		ob_end_clean ();
		return base64_encode ( $buffer );
	}

	/**
	 * 等比自动剪切图片
	 *
	 * @param string $base64String        	
	 * @param number $newwidth        	
	 * @param number $newheight        	
	 * @return multitype:
	 */
	public static function cupturePng($base64String, $newwidth = 160, $newheight = 90) {
		$data = base64_decode ( $base64String );
		$playIm = imagecreatefromstring ( $data );
		imagesavealpha ( $playIm, true );
		$playWidth = imagesx ( $playIm );
		$playHeight = imagesy ( $playIm );
		$playPng = imagecreatetruecolor ( $newwidth, $newheight );
		imagealphablending ( $playPng, false );
		imagesavealpha ( $playPng, true );
		imagecopyresampled ( $playPng, $playIm, 0, 0, 0, 0, $newwidth, $newheight, $playWidth, $playHeight );
		ob_start ();
		imagepng ( $playPng );
		$buffer = ob_get_contents ();
		ob_end_clean ();
		return base64_encode ( $buffer );
	}
	
	/**
	 * 转BASE64
	 *
	 * @param string $filename        	
	 * @return string
	 */
	public static function base64EncodeImage($filename) {
		if ($filename) {
			$imgbinary = fread ( fopen ( $filename, "r" ), filesize ( $filename ) );
			return base64_encode ( $imgbinary );
		}
	}

	/**
	 * 读取图片
	 *
	 * @param string $imagePath        	
	 * @return base64string
	 */
	public static function ReadImage($imagePath) {
		$imageData = null;
		$imageRealPath = PUBLICDIR . $imagePath;
		if (file_exists ( $imageRealPath )) {
			$imageData = base64_encode ( file_get_contents ( $imageRealPath ) );
		} else {
			$imageData = "";
		}
		return $imageData;
	}
}