<?php

/**
 * 用户积分流水信息表
 * @author xy
 *
 */
class Object_Account_Integral extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 用户对象
	 *
	 * @var Object_User_Base
	 */
	private $user = null;

	/**
	 * 获取用户对象
	 *
	 * @return Object_User_Base NULL
	 */
	public function GetUser() {
		$user = new Object_User_Base ( $this->user );
		if ($user->GetId () > 0) {
			return $user;
		} else {
			return null;
		}
	}

	/**
	 * 设置用户对象
	 *
	 * @param Object_User_Base $user        	
	 * @throws Exception
	 */
	public function SetUser(Object_User_Base $user) {
		if (! is_null ( $user )) {
			if (! is_null ( $this->user )) {
				if ($this->user != $user->GetId ()) {
					$this->user = $user->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->user = $user->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "user OBJECT IS NULL" );
		}
	}
	
	/**
	 * 变动积分
	 *
	 * @var number
	 */
	private $changeIntegral = 0;

	/**
	 * 获取变动积分
	 *
	 * @return number
	 */
	public function GetChangeIntegral() {
		return $this->changeIntegral;
	}

	/**
	 * 设置变动积分
	 *
	 * @param number $changeIntegral        	
	 */
	public function SetChangeIntegral($changeIntegral) {
		if ($this->changeIntegral != $changeIntegral) {
			$this->changeIntegral = $changeIntegral;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 变动时间
	 *
	 * @var DateTime
	 */
	private $changeTime = '0000-00-00 00:00:00';

	/**
	 * 获取变动时间
	 *
	 * @return DateTime
	 */
	public function GetChangeTime() {
		return $this->changeTime;
	}

	/**
	 * 设置变动时间
	 *
	 * @param DateTime $changeTime        	
	 */
	public function SetChangeTime($changeTime) {
		if ($this->changeTime != $changeTime) {
			$this->changeTime = $changeTime;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 备注（金额增加）
	 *
	 * @var string
	 */
	private $remarkIncrease = '';

	/**
	 * 获取备注（金额增加）
	 *
	 * @return string
	 */
	public function GetRemarkIncrease() {
		return $this->remarkIncrease;
	}

	/**
	 * 设置备注（金额增加）
	 *
	 * @param string $remarkIncrease        	
	 */
	public function SetRemarkIncrease($remarkIncrease) {
		if ($this->remarkIncrease != $remarkIncrease) {
			$this->remarkIncrease = $remarkIncrease;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 备注（金额减少）
	 *
	 * @var string
	 */
	private $remarkReduce = '';

	/**
	 * 获取备注（金额减少）
	 *
	 * @return string
	 */
	public function GetRemarkReduce() {
		return $this->remarkReduce;
	}

	/**
	 * 设置备注（金额减少）
	 *
	 * @param string $remarkReduce        	
	 */
	public function SetRemarkReduce($remarkReduce) {
		if ($this->remarkReduce != $remarkReduce) {
			$this->remarkReduce = $remarkReduce;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 段位类型枚举对象
	 *
	 * @var Object_User_Role
	 */
	private $role = null;

	/**
	 * 获取段位类型枚举对象
	 *
	 * @return Object_User_Role
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
	 * 设置段位类型枚举对象
	 *
	 * @param Object_User_Role $role        	
	 */
	public function SetRole(Object_User_Role $role) {
		if ($this->role != $role->GetId ()) {
			$this->role = $role->GetId ();
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_802" );
		$this->setMemcacheId ( PROJECT . "_802" );
		$this->setZendCacheId ( PROJECT . "_802" );
		$this->setZendCacheDir ( "/A8/802" );
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
			$this->user = $data ['F1_A802'];
			$this->SetChangeIntegral ( $data ['F2_A802'] );
			$this->SetChangeTime ( $data ['F3_A802'] );
			$this->SetRemarkIncrease ( $data ['F4_A802'] );
			$this->SetRemarkReduce ( $data ['F5_A802'] );
			$this->role = $data ['F6_A802'];
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
				'F1_A802' => $this->user,
				'F2_A802' => $this->GetChangeIntegral (),
				'F3_A802' => $this->GetChangeTime (),
				'F4_A802' => $this->GetRemarkIncrease (),
				'F5_A802' => $this->GetRemarkReduce (),
				'F6_A802' => $this->role 
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