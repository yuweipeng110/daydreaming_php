<?php

/**
 * 系统用户组
 * 
 * @author Finder
 */
class System_Admin_Organize extends Data_Object {
	
	/**
	 * 名称
	 *
	 * @var string
	 */
	private $title = "";

	/**
	 * 获取名称
	 *
	 * @return string
	 */
	public function GetTitle() {
		return $this->title;
	}

	/**
	 * 设置名称
	 *
	 * @param string $title        	
	 */
	public function SetTitle($title) {
		$this->title = $title;
	}
	
	/**
	 * 备注
	 *
	 * @var string
	 */
	private $remark = "";

	/**
	 * 获取备注
	 *
	 * @return string
	 */
	public function GetRemark() {
		return $this->remark;
	}

	/**
	 * 设置备注
	 *
	 * @param string $remark        	
	 */
	public function SetRemark($remark) {
		$this->remark = $remark;
	}
	
	/**
	 * 是否被删除
	 *
	 * @var boolean
	 */
	private $isRemove = false;

	/**
	 * 获取记录状态
	 *
	 * @return boolean
	 */
	public function GetIsRemove() {
		return $this->isRemove;
	}

	/**
	 * 设置记录状态
	 *
	 * @param boolean $isRemove        	
	 */
	public function SetIsRemove($isRemove) {
		$this->isRemove = $isRemove;
	}

	/**
	 * 后台系统用户组
	 *
	 * @param number $id        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_103" );
		$this->setMemcacheId ( PROJECT . "_ADMIN_ORGANIZE" );
		$this->setZendCacheId ( PROJECT . "_ADMIN_ORGANIZE" );
		$this->setZendCacheDir ( "/ADMIN/ORGANIZE" );
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
			$this->title = $data ['F1_A103'];
			$this->remark = $data ['F2_A103'];
			$this->SetIsRemove ( $data ['isremove_A103'] == "1" );
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
				'F1_A103' => $this->title,
				'F2_A103' => $this->remark,
				'ISREMOVE_A103' => $this->GetIsRemove () ? "1" : "0",
				'OTIME' => $this->GetOtime () 
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