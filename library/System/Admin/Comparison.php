<?php

/**
 * 用户组对应对象
 * 
 * @author Finder
 */
class System_Admin_Comparison extends Data_Object {
	
	/**
	 * 用户对象
	 *
	 * @var System_Admin_User
	 */
	private $user = null;

	/**
	 * 获取用户对象
	 *
	 * @return System_Admin_User
	 */
	public function GetUser() {
		return $this->user;
	}

	/**
	 * 设置用户对象
	 *
	 * @param System_Admin_User $user        	
	 */
	public function SetUser(System_Admin_User $user) {
		$this->user = $user;
	}
	
	/**
	 * 用户组对象
	 *
	 * @var System_Admin_Organize
	 */
	private $organize = null;

	/**
	 * 获取用户组对象
	 *
	 * @return System_Admin_Organize
	 */
	public function GetOrganize() {
		return $this->organize;
	}

	/**
	 * 设置用户组对象
	 *
	 * @param System_Admin_Organize $organize        	
	 */
	public function SetOrganize(System_Admin_Organize $organize) {
		$this->organize = $organize;
	}

	/**
	 * 后台用户组对照
	 *
	 * @param number $id        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_105" );
		$this->setMemcacheId ( PROJECT . "_ADMIN_COMPARISON" );
		$this->setZendCacheId ( PROJECT . "_ADMIN_COMPARISON" );
		$this->setZendCacheDir ( "/ADMIN/COMPARISON" );
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
			$this->SetUser ( new System_Admin_User ( $data ['F1_A105'] ) );
			$this->SetOrganize ( new System_Admin_Organize ( $data ['F2_A105'] ) );
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
				'F1_A105' => $this->GetUser ()->GetId (),
				'F2_A105' => $this->GetOrganize ()->GetId () 
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