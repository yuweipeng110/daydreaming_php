<?php

/**
 * 系统用户组
 * 
 * @author Finder
 */
class System_Admin_Converge extends Data_List {

	public function __construct() {
		$this->setTableName ( PROJECT . "_103" );
		
		$this->initCache ();
		$this->initAdapter ();
	}

	/**
	 * 项目列表
	 *
	 * @return multitype:System_Admin_Bug
	 */
	public function GetItems() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' 1=1 ', '1' );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Organize ( $value ['ID'] );
		}
		return $objectList;
	}
}