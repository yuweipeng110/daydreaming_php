<?php

/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
	
	/**
	 * Save the file to the specified path
	 *
	 * @return boolean TRUE on success
	 */
	function save($path) {
		$input = fopen ( "php://input", "r" );
		$temp = tmpfile ();
		$realSize = stream_copy_to_stream ( $input, $temp );
		fclose ( $input );
		
		if ($realSize != $this->getSize ()) {
			return false;
		}
		
		$target = fopen ( $path, "w" );
		fseek ( $temp, 0, SEEK_SET );
		stream_copy_to_stream ( $temp, $target );
		fclose ( $target );
		
		return true;
	}
	function getName() {
		return $_GET ['qqfile'];
	}
	function getSize() {
		if (isset ( $_SERVER ["CONTENT_LENGTH"] )) {
			return ( int ) $_SERVER ["CONTENT_LENGTH"];
		} else {
			throw new Exception ( 'Getting content length is not supported.' );
		}
	}
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {
	
	/**
	 * Save the file to the specified path
	 *
	 * @return boolean TRUE on success
	 */
	function save($path) {
		if (! move_uploaded_file ( $_FILES ['qqfile'] ['tmp_name'], $path )) {
			return false;
		}
		return true;
	}
	function getName() {
		return $_FILES ['qqfile'] ['name'];
	}
	function getSize() {
		return $_FILES ['qqfile'] ['size'];
	}
}
class qqFileUploader {
	private $allowedExtensions = array ();
	private $sizeLimit = 10485760;
	private $file;
	function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760) {
		$allowedExtensions = array_map ( "strtolower", $allowedExtensions );
		
		$this->allowedExtensions = $allowedExtensions;
		$this->sizeLimit = $sizeLimit;
		
		$this->checkServerSettings ();
		
		if (isset ( $_GET ['qqfile'] )) {
			$this->file = new qqUploadedFileXhr ();
		} elseif (isset ( $_FILES ['qqfile'] )) {
			$this->file = new qqUploadedFileForm ();
		} else {
			$this->file = false;
		}
	}
	private function checkServerSettings() {
		$postSize = $this->toBytes ( ini_get ( 'post_max_size' ) );
		$uploadSize = $this->toBytes ( ini_get ( 'upload_max_filesize' ) );
		
		if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit) {
			$size = max ( 1, $this->sizeLimit / 1024 / 1024 ) . 'M';
			die ( "{'error':'increase post_max_size and upload_max_filesize to $size'}" );
		}
	}
	private function toBytes($str) {
		$val = trim ( $str );
		$last = strtolower ( $str [strlen ( $str ) - 1] );
		switch ($last) {
			case 'g' :
				$val *= 1024;
			case 'm' :
				$val *= 1024;
			case 'k' :
				$val *= 1024;
		}
		return $val;
	}
	
	/**
	 * Returns array('success'=>true) or array('error'=>'error message')
	 */
	function handleUpload($uploadDirectory, $replaceOldFile = FALSE, $newFileName = NULL) {
		if (! is_writable ( $uploadDirectory )) {
			return array (
					'error' => "Server error. Upload directory isn't writable." 
			);
		}
		
		if (! $this->file) {
			return array (
					'error' => 'No files were uploaded.' 
			);
		}
		
		$size = $this->file->getSize ();
		
		if ($size == 0) {
			return array (
					'error' => 'File is empty' 
			);
		}
		
		if ($size > $this->sizeLimit) {
			return array (
					'error' => 'File is too large' 
			);
		}
		
		$pathinfo = pathinfo ( $this->file->getName () );
		$filename = $pathinfo ['filename'];
		// $filename = md5(uniqid());
		$ext = strtolower ( $pathinfo ['extension'] );
		
		if ($this->allowedExtensions && ! in_array ( strtolower ( $ext ), $this->allowedExtensions )) {
			$these = implode ( ', ', $this->allowedExtensions );
			return array (
					'error' => 'File has an invalid extension, it should be one of ' . $these . '.' 
			);
		}
		
		if (! $replaceOldFile) {
			// / don't overwrite previous files that were uploaded
			while ( file_exists ( $uploadDirectory . $filename . '.' . $ext ) ) {
				$filename .= rand ( 10, 99 );
			}
		}
		
		if ($newFileName != NULL) {
			$filename = $newFileName;
		}
		
		if ($this->file->save ( $uploadDirectory . $filename . '.' . $ext )) {
			list ( $width, $height, $type, $attr ) = getimagesize ( $uploadDirectory . $filename . '.' . $ext );
			return array (
					'success' => true,
					'path' => $uploadDirectory . $filename . '.' . $ext,
					'imageWidth' => $width,
					'imageHeight' => $height 
			);
		} else {
			return array (
					'error' => 'Could not save uploaded file.' . 'The upload was cancelled, or server error encountered' 
			);
		}
	}
}

require_once '../../../../library/Format.php';
if ($_GET ['act'] == "uploadcsv") {
	$school = Format::FormatStreamDecrypt ( $_GET ['school'] );
	
	$path = "../../../../csvs/$school/";
	$dir = $path;
	if (! file_exists ( $dir )) {
		mkdir ( $dir, 0777, true );
	}
	
	$newFileName = "$school";
	
	$allowedExtensions = array (
			"txt" 
	);
	$sizeLimit = 1024 * 1024 * 2;
	$uploader = new qqFileUploader ( $allowedExtensions, $sizeLimit );
	$result = $uploader->handleUpload ( $path, TRUE, $newFileName );
	echo htmlspecialchars ( json_encode ( $result ), ENT_NOQUOTES );
}
