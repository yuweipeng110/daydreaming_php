<?php

/**
 * 系统用户权限列表
 * 
 * @author Finder
 *
 */
class System_Admin_Relation extends Data_List {
	/**
	 * 系统用户
	 *
	 * @var System_Admin_User
	 */
	private $user = null;
	
	/**
	 * 功能列表
	 *
	 * @var array
	 */
	private $relation = array ();

	/**
	 * 系统用户权限列表
	 *
	 * @param System_Admin_User $user        	
	 */
	public function __construct(System_Admin_User $user) {
		$this->user = $user;
		
		$this->setTableName ( PROJECT . "_102" );
		
		$this->initCache ();
		$this->initAdapter ();
	}

	/**
	 * 菜单列表
	 *
	 * @return multitype:System_Admin_Menu
	 */
	public function GetMenus() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A102= ? ', $this->user->GetId () );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Menu ( $value ['F2_A102'] );
		}
		return $objectList;
	}

	/**
	 * 权限列表
	 *
	 * @return multitype:System_Admin_Userrelation
	 */
	public function GetRelation() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A102= ? ', $this->user->GetId () );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Userrelation ( $value ['ID'] );
			// print_r ( $value ['F2_A102'] );
		}
		return $objectList;
	}

	/**
	 * 移除功能权限
	 *
	 * @param System_Admin_Userrelation $userRelation        	
	 */
	public function RemoveRelation(System_Admin_Userrelation $userRelation) {
		$userRelation->Destroy ();
	}

	/**
	 * 清除功能权限
	 *
	 * @return null
	 */
	public function ClearRelation() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A102= ? ', $this->user->GetId () );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$userRelation = new System_Admin_Userrelation ( $value ['ID'] );
			$userRelation->Destroy ();
		}
	}

	/**
	 * 添加功能权限
	 *
	 * @param System_Admin_Menu $menu        	
	 * @param boolean $readonly        	
	 * @return null
	 */
	public function AppendRelation(System_Admin_Menu $menu, $readonly = false) {
		$userRelation = new System_Admin_Userrelation ();
		$userRelation->SetUser ( $this->user );
		$userRelation->SetMenu ( $menu );
		$userRelation->SetReadOnly ( $readonly );
		$userRelation->Save ();
	}
}