<?php

/**
 * 系统用户权限对照对象
 * @author Finder
 *
 */
class System_Admin_Userrelation extends Data_Object {
	
	/**
	 * 系统用户ID
	 *
	 * @var int
	 */
	private $user_id = 0;

	/**
	 * 获取系统用户
	 *
	 * @return System_Admin_User
	 */
	public function GetUser() {
		return $this->F1_A102;
	}

	/**
	 * 设置系统用户
	 *
	 * @param System_Admin_User $F1_A102        	
	 */
	public function SetUser(System_Admin_User $user) {
		$this->F1_A102 = $user;
	}
	
	/**
	 * 功能ID
	 *
	 * @var int
	 */
	private $F2_A102 = 0;

	/**
	 * 获取功能
	 *
	 * @return System_Admin_Menu
	 */
	public function GetMenu() {
		return $this->F2_A102;
	}

	/**
	 * 设置功能
	 *
	 * @param System_Admin_Menu $menu        	
	 */
	public function SetMenu(System_Admin_Menu $menu) {
		$this->F2_A102 = $menu;
	}
	
	/**
	 * 权限
	 *
	 * @var boolean
	 */
	private $F3_A102 = true;

	/**
	 * 获取权限
	 *
	 * @return boolean
	 */
	public function GetReadOnly() {
		return $this->F3_A102;
	}

	/**
	 * 设置权限
	 *
	 * @param boolean $readOnly        	
	 */
	public function SetReadOnly($readOnly) {
		$this->F3_A102 = $readOnly;
	}

	/**
	 * 权限
	 *
	 * @param number $id        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_102" );
		$this->setMemcacheId ( PROJECT . "_ADMIN_RELATION" );
		$this->setZendCacheId ( PROJECT . "_ADMIN_RELATION" );
		$this->setZendCacheDir ( "/ADMIN/RELATION" );
		$this->setCacheType ( 3 );
		
		parent::__construct ( $id );
		
		try {
			$data = $this->GetInstance ( false );
			$this->SetObjectProperty ( $data );
			$this->isValueChanged = false;
		} catch ( Exception $ex ) {
			$data = $this->GetInstance ( true );
			$this->SetObjectProperty ( $data );
			$this->isValueChanged = false;
		}
	}

	/**
	 * 设定对象相关属性
	 */
	private function SetObjectProperty($data) {
		if ($data != null) {
			$this->SetId ( $data ['ID'] );
			$this->SetUser ( new System_Admin_User ( $data ['F1_A102'] ) );
			$this->SetMenu ( new System_Admin_Menu ( $data ['F2_A102'] ) );
			$this->SetReadOnly ( $data ['F3_A102'] == "1" );
			$this->SetOtime ( $data ['OTIME'] );
		} else {
			$this->SetId ( 0 );
		}
	}

	/**
	 * 保存
	 *
	 * @see Data_Object::Save()
	 */
	public function Save() {
		$data = array (
				'F1_A102' => $this->GetUser ()->GetId (),
				'F2_A102' => $this->GetMenu ()->GetId (),
				'F3_A102' => $this->GetReadOnly () ? "1" : "0" 
		);
		$this->SafeParam ( $data );
		
		$this->table->setTable ( $this->getTableName () );
		
		if ($this->GetId () > 0) {
			$where = $this->db->quoteInto ( ' ID= ? ', $this->GetId () );
			$this->table->update ( $data, $where );
		} else {
			$data ['OTIME'] = date ( 'Y-m-d H:i:s' );
			$this->SetId ( $this->table->insert ( $data ) );
		}
		parent::Save ();
	}

	/**
	 * 删除
	 *
	 * @see Data_Object::Destroy()
	 */
	public function Destroy() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' ID= ? ', $this->GetId () );
		$this->table->delete ( $where );
		parent::Destroy ();
	}
}