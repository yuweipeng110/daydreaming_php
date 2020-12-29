<?php

/**
 * 抵用卷明细表
 * @author xy
 *
 */
class Object_Promotions_Voucher extends Data_Object {
	
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
	 * 抵用卷金额
	 *
	 * @var DECIMAL(10,2)
	 */
	private $voucherMoney = 0.00;

	/**
	 * 获取抵用卷金额
	 *
	 * @return decimal(10,2)
	 */
	public function GetVoucherMoney() {
		return $this->voucherMoney;
	}

	/**
	 * 设置抵用卷金额
	 *
	 * @param decimal(10,2) $voucherMoney        	
	 */
	public function SetVoucherMoney($voucherMoney) {
		if ($this->voucherMoney != sprintf ( "%.2f", $voucherMoney )) {
			$this->voucherMoney = sprintf ( "%.2f", $voucherMoney );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 激活时间
	 *
	 * @var DateTime
	 */
	private $activationTime = '0000-00-00 00:00:00';

	/**
	 * 获取激活时间
	 *
	 * @return DateTime
	 */
	public function GetActivationTime() {
		return $this->activationTime;
	}

	/**
	 * 设置激活时间
	 *
	 * @param DateTime $activationTime        	
	 */
	public function SetActivationTime($activationTime) {
		if ($this->activationTime != $activationTime) {
			$this->activationTime = $activationTime;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 激活方式
	 *
	 * @var number
	 */
	private $activationMode = 0;

	/**
	 * 获取激活方式
	 *
	 * @return number
	 */
	public function GetActivationMode() {
		return $this->activationMode;
	}

	/**
	 * 设置激活方式
	 *
	 * @param number $activationMode        	
	 */
	public function SetActivationMode($activationMode) {
		if ($this->activationMode != $activationMode) {
			$this->activationMode = $activationMode;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 活动对象
	 *
	 * @var Object_Promotions_Base
	 */
	private $promotions = null;

	/**
	 * 获取活动对象
	 *
	 * @return Object_Promotions_Base
	 */
	public function GetPromotions() {
		$promotions = new Object_Promotions_Base ( $this->promotions );
		if ($promotions->GetId () > 0) {
			return $promotions;
		} else {
			return null;
		}
	}

	/**
	 * 设置活动对象
	 *
	 * @param Object_Promotions_Base $promotions        	
	 */
	public function SetPromotions(Object_Promotions_Base $promotions) {
		if ($this->promotions != $promotions->GetId ()) {
			$this->promotions = $promotions->GetId ();
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_602" );
		$this->setMemcacheId ( PROJECT . "_602" );
		$this->setZendCacheId ( PROJECT . "_602" );
		$this->setZendCacheDir ( "/A3/602" );
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
			$this->user = $data ['F1_A602'];
			$this->SetVoucherMoney ( $data ['F2_A602'] );
			$this->SetActivationTime ( $data ['F3_A602'] );
			$this->SetActivationMode ( $data ['F4_A602'] );
			$this->promotions = $data ['F5_A602'];
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
				'F1_A602' => $this->user,
				'F2_A602' => $this->GetVoucherMoney (),
				'F3_A602' => $this->GetActivationTime (),
				'F4_A602' => $this->GetActivationMode (),
				'F5_A602' => $this->promotions 
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