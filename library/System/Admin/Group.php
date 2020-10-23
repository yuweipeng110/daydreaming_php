<?php

/**
 * 后台功能组
 * 
 * @author Finder
 *
 */
class System_Admin_Group extends Data_List {

	public function __construct() {
		$this->setTableName ( PROJECT . "_001" );
		
		$this->initCache ();
		$this->initAdapter ();
	}

	/**
	 * 项目列表
	 *
	 * @return multitype:System_Admin_Menu
	 */
	public function GetItems() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A001 = ? ', '0' );
		$order = array (
				"F4_A001 ASC",
				"OTIME ASC" 
		);
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Menu ( $value ['ID'] );
		}
		return $objectList;
	}

	/**
	 * 项目列表
	 *
	 * @return multitype:System_Admin_Menu
	 */
	public function GetMenuList() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' 1 = 1 ', '1' );
		$order = array (
				"F4_A001 ASC",
				"OTIME ASC" 
		);
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Menu ( $value ['ID'] );
		}
		return $objectList;
	}

	/**
	 * 项目列表
	 *
	 * @return multitype:System_Admin_Menu
	 */
	public function GetSubsetList() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A001 != 0 ', '1' );
		$order = array (
				"F4_A001 ASC",
				"OTIME ASC" 
		);
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Menu ( $value ['ID'] );
		}
		return $objectList;
	}
}