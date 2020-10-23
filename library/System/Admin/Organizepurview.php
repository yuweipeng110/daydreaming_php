<?php
/**
 * 用户权限
 * 
 * @author Finder
 */
class System_Admin_Organizepurview extends Data_Object {
	
	/**
	 * 系统用户组ID
	 *
	 * @var System_Admin_Organize
	 */
	private $F1_A104 = null;

	/**
	 * 获取系统用户组
	 *
	 * @return System_Admin_Organize
	 */
	public function GetOrganize() {
		return $this->F1_A104;
	}

	/**
	 * 设置系统用户组
	 *
	 * @param System_Admin_Organize $organize        	
	 */
	public function SetOrganize(System_Admin_Organize $organize) {
		$this->F1_A104 = $organize;
	}
	
	/**
	 * 功能ID
	 *
	 * @var System_Admin_Menu
	 */
	private $F2_A104 = null;

	/**
	 * 获取功能
	 *
	 * @return System_Admin_Menu
	 */
	public function GetMenu() {
		return $this->F2_A104;
	}

	/**
	 * 设置功能
	 *
	 * @param System_Admin_Menu $menu        	
	 */
	public function SetMenu(System_Admin_Menu $menu) {
		$this->F2_A104 = $menu;
	}
	
	/**
	 * 权限
	 *
	 * @var boolean
	 */
	private $F3_A104 = true;

	/**
	 * 是否只读
	 *
	 * @return boolean
	 */
	public function GetReadOnly() {
		return $this->F3_A104;
	}

	/**
	 * 设置权限
	 *
	 * @param boolean $readOnly        	
	 */
	public function SetReadOnly($readOnly) {
		$this->F3_A104 = $readOnly;
	}
	
	/**
	 * 是否被移除(0:可用,1:不可用)
	 *
	 * @var boolean
	 */
	private $isRemove = false;

	/**
	 * 获取是否被移除
	 *
	 * @return boolean
	 */
	public function GetIsRemove() {
		return $this->isRemove;
	}

	/**
	 * 设置是否被移除
	 *
	 * @param boolean $isRemove        	
	 */
	public function SetIsRemove($isRemove) {
		$this->isRemove = $isRemove;
	}

	/**
	 * 系统用户组权限对照对象
	 *
	 * @param number $id        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_104" );
		$this->setMemcacheId ( PROJECT . "_ADMIN_ORGANIZEPUR" );
		$this->setZendCacheId ( PROJECT . "_ADMIN_ORGANIZEPUR" );
		$this->setZendCacheDir ( "/ADMIN/ORGANIZEPUR" );
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
			$this->SetOrganize ( new System_Admin_Organize ( $data ['F1_A104'] ) );
			$this->SetMenu ( new System_Admin_Menu ( $data ['F2_A104'] ) );
			$this->SetReadOnly ( $data ['F3_A104'] == "1" );
			$this->SetIsRemove ( $data ['ISREMOVE_A104'] == "1" );
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
				'F1_A104' => $this->GetOrganize ()->GetId (),
				'F2_A104' => $this->GetMenu ()->GetId (),
				'F3_A104' => $this->GetReadOnly () ? "1" : "0",
				'ISREMOVE_A104' => $this->GetIsRemove () ? "1" : "0" 
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