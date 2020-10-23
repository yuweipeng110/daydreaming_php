<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	protected function _initDoctype() {
		$this->bootstrap ( 'multidb' );
		$resource = $this->getPluginResource ( 'multidb' );
		foreach ( $resource->getOptions () as $key => $value ) {
			Zend_Registry::set ( $key, $resource->getDb ( $key ) );
		}
	}
}