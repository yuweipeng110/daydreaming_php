<?php

/**
 * 桌台信息表
 * @author xy
 *
 */
class Object_Script_Desk extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 桌号名称
	 *
	 * @var string
	 */
	private $title = '';

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
		if ($this->title != $title) {
			$this->title = $title;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 是否可用
	 *
	 * @var number
	 */
	private $isEnabled = 0;

	/**
	 * 获取是否可用
	 *
	 * @return number
	 */
	public function GetIsEnabled() {
		return $this->isEnabled;
	}

	/**
	 * 设置是否可用
	 *
	 * @param number $isEnabled        	
	 */
	public function SetIsEnabled($isEnabled) {
		if ($this->isEnabled != $isEnabled) {
			$this->isEnabled = $isEnabled;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 门店对象
	 *
	 * @var Object_User_Store
	 */
	private $store = null;

	/**
	 * 获取门店对象
	 *
	 * @return Object_User_Store NULL
	 */
	public function GetStore() {
		$store = new Object_User_Store ( $this->store );
		if ($store->GetId () > 0) {
			return $store;
		} else {
			return null;
		}
	}

	/**
	 * 设置门店对象
	 *
	 * @param Object_User_Store $store        	
	 * @throws Exception
	 */
	public function SetStore(Object_User_Store $store) {
		if (! is_null ( $store )) {
			if (! is_null ( $this->store )) {
				if ($this->store != $store->GetId ()) {
					$this->store = $store->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->store = $store->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "store OBJECT IS NULL" );
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_305" );
		$this->setMemcacheId ( PROJECT . "_305" );
		$this->setZendCacheId ( PROJECT . "_305" );
		$this->setZendCacheDir ( "/A3/305" );
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
			$this->SetTitle ( $data ['F1_A305'] );
			$this->SetIsEnabled ( $data ['F2_A305'] );
			$this->store = $data ['F3_A305'];
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
				'F1_A305' => $this->GetTitle (),
				'F2_A305' => $this->GetIsEnabled (),
				'F3_A305' => $this->store 
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