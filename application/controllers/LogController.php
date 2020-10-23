<?php
header ( "Content-type:text/html;charset=utf-8" );

class LogController extends Custom_Competence {

	public function init() {
		parent::init ();
	}
	// ---------------------------------------------------------------------------------------------
	public function indexAction() {
		$logFolder = LOGDIR . "/";
		$logFileList = array ();
		foreach ( scandir ( $logFolder ) as $file ) {
			if ($file != "." && $file != "..") {
				$fileData = array ();
				$fileData [] = $file;
				$fileData [] = explode ( ".", $file );
				$logFileList [] = $fileData;
			}
		}
		$this->view->assign ( "logFileList", $logFileList );
		$this->render ( "index" );
	}

	public function logDetailsAction() {
		$logFileName = $this->_getParam ( "logFileName", "" );
		$line = explode ( "\n", file_get_contents ( LOGDIR . "/" . $logFileName ) );
		echo "<pre>";
		for($i = count ( $line ); $i > count ( $line ) - 100; $i --) {
			echo "<p>" . print_r ( $line [$i] ) . "<p/>";
			// echo "<p>" . print_r ( Zend_Json::decode ( $line [$i] ) ) . "<p/>";
		}
	}
}