<?php
class Custom_Adapter extends Zend_Db_Table {
	public function init() {
		parent::init ();
	}
	public function setTable($tableName) {
		$this->_name = $tableName;
	}
}