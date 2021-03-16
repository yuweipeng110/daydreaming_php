<?php
header ( "Content-type:text/html;charset=utf-8" );

class Service1Controller extends Zend_Controller_Action {

	public function init() {
		$sapi_type = php_sapi_name ();
		if ($sapi_type == "cli") {
			$this->_helper->viewRenderer->setNoRender ();
		} else {
			echo "Welcome to system services, use the command line to run the relevant procedures.\n";
			die ();
		}
	}

	public function indexAction() {
	}
}