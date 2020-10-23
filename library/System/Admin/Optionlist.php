<?php

/**
 * 网站bug修改日志列表
 * 
 * @author Finder
 */
class System_Admin_Optionlist extends Data_List {

	public function __construct() {
		$this->setTableName ( PROJECT . "_002" );
		
		$this->initCache ();
		$this->initAdapter ();
	}

	/**
	 * 项目列表
	 *
	 * @return multitype:System_Admin_Option
	 */
	public function GetItems() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A002= ? ', null );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Option ( $value ['ID'] );
		}
		return $objectList;
	}
}