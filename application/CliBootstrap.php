<?php
class CliBootstrap extends Zend_Application_Bootstrap_Bootstrap {
	public function _initDatabase() {
		$controller = "service";
		$action = "index";
		if (count ( $_SERVER ['argv'] )) {
			$this->bootstrap ( 'FrontController' );
			if (isset ( $_SERVER ['argv'] [1] )) {
				$action = $_SERVER ['argv'] [1];
			}
		}
		
		$this->frontController->setParam ( 'noViewRenderer', true );
		$this->frontController->throwExceptions ( false );
		
		$this->frontController->setDefaultControllerName ( $controller );
		$this->frontController->setDefaultAction ( $action );
		
		$this->bootstrap ( 'multidb' );
		$resource = $this->getPluginResource ( 'multidb' );
		foreach ( $resource->getOptions () as $key => $value ) {
			Zend_Registry::set ( $key, $resource->getDb ( $key ) );
		}
	}
}