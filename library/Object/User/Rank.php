<?php

/**
 * 积分段位枚举表
 * @author xy
 *
 */
class Object_User_Rank extends Data_Object {
	
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
	private $title = "";

	/**
	 * 获取名稱
	 *
	 * @return string
	 */
	public function GetTitle() {
		return $this->title;
	}

	/**
	 * 设置名稱
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
	 * 称号类型对象
	 *
	 * @var Object_User_Role
	 */
	private $role = null;

	/**
	 * 获取称号类型对象
	 *
	 * @return Object_User_Role NULL
	 */
	public function GetRole() {
		$role = new Object_User_Role ( $this->role );
		if ($role->GetId () > 0) {
			return $role;
		} else {
			return null;
		}
	}

	/**
	 * 设置称号类型对象
	 *
	 * @param Object_User_Role $role        	
	 * @throws Exception
	 */
	public function SetRole(Object_User_Role $role) {
		if (! is_null ( $role )) {
			if (! is_null ( $this->role )) {
				if ($this->role != $role->GetId ()) {
					$this->role = $role->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->role = $role->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "role OBJECT IS NULL" );
		}
	}
	
	/**
	 * 积分
	 *
	 * @var number
	 */
	private $integral = 0;

	/**
	 * 获取积分
	 *
	 * @return number
	 */
	public function GetIntegral() {
		return $this->integral;
	}

	/**
	 * 设置积分
	 *
	 * @param number $integral        	
	 */
	public function SetIntegral($integral) {
		if ($this->integral != $integral) {
			$this->integral = $integral;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 排名
	 * 
	 * @var number
	 */
	private $fullRanking = 0;

	/**
	 * 获取排名
	 *
	 * @return number
	 */
	public function GetFullRanking() {
		return $this->fullRanking;
	}

	/**
	 * 设置排名
	 *
	 * @param number $fullRanking        	
	 */
	public function SetFullRanking($fullRanking) {
		if ($this->fullRanking != $fullRanking) {
			$this->fullRanking = $fullRanking;
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_211" );
		$this->setMemcacheId ( PROJECT . "_211" );
		$this->setZendCacheId ( PROJECT . "_211" );
		$this->setZendCacheDir ( "/A2/211" );
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
			$this->SetTitle ( $data ['F1_A211'] );
			$this->role = $data ['F2_A211'];
			$this->SetIntegral ( $data ['F3_A211'] );
			$this->SetFullRanking ( $data ['F4_A211'] );
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
				'F1_A211' => $this->GetTitle (),
				'F2_A211' => $this->role,
				'F3_A211' => $this->GetIntegral (),
				'F4_A211' => $this->GetFullRanking () 
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