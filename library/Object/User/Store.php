<?php

/**
 * 門店表
 * @author xy
 *
 */
class Object_User_Store extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 名稱
	 *
	 * @var string
	 */
	private $name = "";

	/**
	 * 获取名稱
	 *
	 * @return string
	 */
	public function GetName() {
		return $this->name;
	}

	/**
	 * 设置名稱
	 *
	 * @param string $name        	
	 */
	public function SetName($name) {
		if ($this->name != $name) {
			$this->name = $name;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 運營狀態
	 *
	 * @var string
	 */
	private $status = 0;

	/**
	 * 获取運營狀態
	 *
	 * @return string
	 */
	public function GetStatus() {
		return (int) $this->status;
	}

	/**
	 * 设置運營狀態
	 *
	 * @param string $status        	
	 */
	public function SetStatus($status) {
		if ($this->status != $status) {
			$this->status = $status;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 电话
	 *
	 * @var string
	 */
	private $phone = "";

	/**
	 * 获取电话
	 *
	 * @return string
	 */
	public function GetPhone() {
		return $this->phone;
	}

	/**
	 * 设置电话
	 *
	 * @param string $phone        	
	 */
	public function SetPhone($phone) {
		if ($this->phone != $phone) {
			$this->phone = $phone;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 地址
	 *
	 * @var string
	 */
	private $address = "";

	/**
	 * 获取地址
	 *
	 * @return string
	 */
	public function GetAddress() {
		return $this->address;
	}

	/**
	 * 设置地址
	 *
	 * @param string $address        	
	 */
	public function SetAddress($address) {
		if ($this->address != $address) {
			$this->address = $address;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 店长
	 *
	 * @var Object_User_Base
	 */
	private $boss = null;

	/**
	 * 获取店长
	 *
	 * @return Object_User_Base
	 */
	public function GetBoss() {
		$boss = new Object_User_Base ( $this->boss );
		if ($boss->GetId () > 0) {
			return $boss;
		} else {
			return null;
		}
	}

	/**
	 * 设置店长
	 *
	 * @param Object_User_Base $boss        	
	 */
	public function SetBoss(Object_User_Base $boss) {
		if ($this->boss != $boss->GetId ()) {
			$this->boss = $boss->GetId ();
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_203" );
		$this->setMemcacheId ( PROJECT . "_203" );
		$this->setZendCacheId ( PROJECT . "_203" );
		$this->setZendCacheDir ( "/A2/203" );
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
			$this->SetName ( $data ['F1_A203'] );
			$this->SetStatus ( $data ['F2_A203'] );
			$this->SetPhone ( $data ['F3_A203'] );
			$this->SetAddress ( $data ['F4_A203'] );
			$this->boss = $data ['F5_A203'];
			$this->SetOtime ( $data ['OTIME'] );
		} else {
			$this->SetId ( 0 );
		}
		$this->isValueChanged = false;
	}

	/**
	 * 保存
	 *
	 * @see Interface_IData::Save()
	 */
	public function Save() {
		if (! $this->isValueChanged)
			return;
		$data = array (
				'F1_A203' => $this->GetName (),
				'F2_A203' => $this->GetStatus (),
				'F3_A203' => $this->GetPhone (),
				'F4_A203' => $this->GetAddress (),
				'F5_A203' => $this->boss 
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
		$this->isValueChanged = false;
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