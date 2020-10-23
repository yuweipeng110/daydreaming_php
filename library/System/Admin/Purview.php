<?php

/**
 * 系统用户组权限对应列表
 * 
 * @author Finder
 */
class System_Admin_Purview extends Data_List {
	
	/**
	 * 系统用户组
	 *
	 * @var System_Admin_Organize
	 */
	protected $organize;
	
	/**
	 * 功能列表
	 *
	 * @var array
	 */
	private $purview = array ();

	/**
	 * 系统用户组权限对应列表
	 *
	 * @param System_Admin_Organize $organize        	
	 */
	public function __construct(System_Admin_Organize $organize) {
		$this->organize = $organize;
		
		$this->setTableName ( PROJECT . "_104" );
		
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
		$where = $this->db->quoteInto ( ' F1_A104= ? ', $this->organize->GetId () );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Menu ( $value ['F2_A104'] );
		}
		return $objectList;
	}

	/**
	 * 用户列表
	 *
	 * @return multitype:System_Admin_User
	 */
	public function GetUsers() {
		$sql = "SELECT F1_A105 FROM A_105 WHERE F2_A105='" . $this->organize->GetId () . "' AND F1_A105 IN(SELECT ID FROM A_101 WHERE ISREMOVE_A101=0)";
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$data = $db->fetchAll ( $sql );
		
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_User ( $value ['F1_A105'] );
		}
		return $objectList;
	}

	/**
	 * 权限列表
	 *
	 * @return multitype:System_Admin_Organizepurview
	 */
	public function GetPurview() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A104= ? ', $this->organize->GetId () );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$objectList [] = new System_Admin_Organizepurview ( $value ['ID'] );
		}
		return $objectList;
	}

	/**
	 * 移除权限对应
	 *
	 * @param System_Admin_Organizepurview $orgenizePurview        	
	 */
	public function RemovePurview(System_Admin_Organizepurview $orgenizePurview) {
		$orgenizePurview->Destroy ();
	}

	/**
	 * 清除功能权限
	 *
	 * @return null
	 */
	public function ClearPurview() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A104= ? ', $this->organize->GetId () );
		$order = "OTIME ASC";
		$data = $this->table->fetchAll ( $where, $order );
		foreach ( $data as $key => $value ) {
			$organizepurview = new System_Admin_Organizepurview ( $value ['ID'] );
			$organizepurview->Destroy ();
		}
	}

	/**
	 * 添加权限对应
	 *
	 * @param System_Admin_Menu $menu        	
	 * @param boolean $readonly        	
	 * @return null
	 */
	public function AppendPurview(System_Admin_Menu $menu, $readonly = false) {
		$orgenizePurview = new System_Admin_Organizepurview ();
		$orgenizePurview->SetOrganize ( $this->organize );
		$orgenizePurview->SetMenu ( $menu );
		$orgenizePurview->SetReadOnly ( false );
		$orgenizePurview->Save ();
	}
}