<?php

/**
 * 用户账户流水信息表
 * @author xy
 *
 */
class Object_Account_Money extends Data_Object {
	
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
	 * 变动金额
	 *
	 * @var DECIMAL(10,2)
	 */
	private $changeMoney = 0.00;

	/**
	 * 获取变动金额
	 *
	 * @return DECIMAL(10,2)
	 */
	public function GetChangeMoney() {
		return sprintf ( "%.2f", $this->changeMoney );
	}

	/**
	 * 设置变动金额
	 *
	 * @param DECIMAL(10,2) $changeMoney        	
	 */
	public function SetChangeMoney($changeMoney) {
		if ($this->changeMoney != sprintf ( "%.2f", $changeMoney )) {
			$this->changeMoney = sprintf ( "%.2f", $changeMoney );
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
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_801" );
		$this->setMemcacheId ( PROJECT . "_801" );
		$this->setZendCacheId ( PROJECT . "_801" );
		$this->setZendCacheDir ( "/A8/801" );
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
			$this->user = $data ['F1_A801'];
			$this->SetChangeMoney ( $data ['F2_A801'] );
			$this->SetChangeTime ( $data ['F3_A801'] );
			$this->SetRemarkIncrease ( $data ['F4_A801'] );
			$this->SetRemarkReduce ( $data ['F5_A801'] );
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
				'F1_A801' => $this->user,
				'F2_A801' => $this->GetChangeMoney (),
				'F3_A801' => $this->GetChangeTime (),
				'F4_A801' => $this->GetRemarkIncrease (),
				'F5_A801' => $this->GetRemarkReduce () 
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