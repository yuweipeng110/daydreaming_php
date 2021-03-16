<?php

/**
 * 门店营收流水表
 * @author xy
 *
 */
class Object_Account_Revenue extends Data_Object {
	
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
	 * 变动类型
	 *
	 * @var number
	 */
	private $changeType = 0;

	/**
	 * 获取变动类型
	 *
	 * @return number
	 */
	public function GetChangeType() {
		return ( int ) $this->changeType;
	}

	/**
	 * 设置变动类型
	 *
	 * @param number $changeType        	
	 */
	public function SetChangeType($changeType) {
		if ($this->changeType != $changeType) {
			$this->changeType = $changeType;
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
	 * 订单对象
	 *
	 * @var Object_Script_Order
	 */
	private $order = null;

	/**
	 * 获取订单对象
	 *
	 * @return Object_Script_Order
	 */
	public function GetOrder() {
		$order = new Object_Script_Order ( $this->order );
		if ($order->GetId () > 0) {
			return $order;
		} else {
			return null;
		}
	}

	/**
	 * 设置订单对象
	 *
	 * @param Object_Script_Order $order        	
	 */
	public function SetOrder(Object_Script_Order $order) {
		if ($this->order != $order->GetId ()) {
			$this->order = $order->GetId ();
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 支付方式
	 *
	 * @var Object_Script_ParmentMethod
	 */
	private $paymentMethod = null;

	/**
	 * 获取支付方式
	 *
	 * @return Object_Script_PaymentMethod
	 */
	public function GetPaymentMethod() {
		$paymentMethod = new Object_Script_PaymentMethod ( $this->paymentMethod );
		if ($paymentMethod->GetId () > 0) {
			return $paymentMethod;
		} else {
			return null;
		}
	}

	/**
	 * 设置支付方式
	 *
	 * @param Object_Script_PaymentMethod $paymentMethod        	
	 */
	public function SetPaymentMethod(Object_Script_PaymentMethod $paymentMethod) {
		if ($this->paymentMethod != $paymentMethod->GetId ()) {
			$this->paymentMethod = $paymentMethod->GetId ();
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_803" );
		$this->setMemcacheId ( PROJECT . "_803" );
		$this->setZendCacheId ( PROJECT . "_803" );
		$this->setZendCacheDir ( "/A8/803" );
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
			$this->user = $data ['F1_A803'];
			$this->SetChangeMoney ( $data ['F2_A803'] );
			$this->SetChangeTime ( $data ['F3_A803'] );
			$this->SetRemarkIncrease ( $data ['F4_A803'] );
			$this->SetRemarkReduce ( $data ['F5_A803'] );
			$this->SetChangeType ( $data ['F6_A803'] );
			$this->store = $data ['F7_A803'];
			$this->order = $data ['F8_A803'];
			$this->paymentMethod = $data ['F9_A803'];
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
				'F1_A803' => $this->user,
				'F2_A803' => $this->GetChangeMoney (),
				'F3_A803' => $this->GetChangeTime (),
				'F4_A803' => $this->GetRemarkIncrease (),
				'F5_A803' => $this->GetRemarkReduce (),
				'F6_A803' => $this->GetChangeType (),
				'F7_A803' => $this->store,
				'F8_A803' => $this->order,
				'F9_A803' => $this->paymentMethod 
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