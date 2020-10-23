<?php

/**
 * 用户组对照列表
 * 
 * @author Finder
 *
 */
class System_Admin_Congregation extends Data_List {
	
	/**
	 * 系统用户
	 *
	 * @var System_Admin_User
	 */
	private $user = null;

	/**
	 * 用户组对照列表
	 *
	 * @param System_Admin_User $user        	
	 */
	public function __construct(System_Admin_User $user) {
		$this->user = $user;
		
		$this->setTableName ( PROJECT . "_105" );
		
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
		$where = $this->db->quoteInto ( ' F1_A105=? ', $this->user->GetId () );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Comparison ( $value ['ID'] );
		}
		return $objectList;
	}
}