<?php

/**
 * 后台用户列表
 * 
 * @author Finder
 */
class System_Admin_Manager extends Data_List {

	public function __construct() {
		$this->setTableName ( PROJECT . "_101" );
		
		$this->initCache ();
		$this->initAdapter ();
	}

	/**
	 * 项目列表
	 *
	 * @return multitype:System_Admin_User
	 */
	public function GetItems() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' ISREMOVE_A101= ? ', 0 );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			if ($value ['ID'] > 1) {
				$objectList [] = new System_Admin_User ( $value ['ID'] );
			}
		}
		return $objectList;
	}
}