<?php

/**
 * 订单信息表
 * @author xy
 *
 */
class Object_Script_Order extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 订单编号
	 *
	 * @var string
	 */
	private $orderNo = '';

	/**
	 * 获取订单编号
	 *
	 * @return string
	 */
	public function GetOrderNo() {
		return $this->orderNo;
	}

	/**
	 * 设置订单编号
	 *
	 * @param string $orderNo        	
	 */
	public function SetOrderNo($orderNo) {
		if ($this->orderNo != $orderNo) {
			$this->orderNo = $orderNo;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 剧本对象
	 *
	 * @var Object_Script_Base
	 */
	private $script = null;

	/**
	 * 获取剧本对象
	 *
	 * @return Object_Script_Base NULL
	 */
	public function GetScript() {
		$script = new Object_Script_Base ( $this->script );
		if ($script->GetId () > 0) {
			return $script;
		} else {
			return null;
		}
	}

	/**
	 * 设置剧本对象
	 *
	 * @param Object_Script_Base $script        	
	 * @throws Exception
	 */
	public function SetScript(Object_Script_Base $script) {
		if (! is_null ( $script )) {
			if (! is_null ( $this->script )) {
				if ($this->script != $script->GetId ()) {
					$this->script = $script->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->script = $script->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "script OBJECT IS NULL" );
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
	 * 卓台对象
	 *
	 * @var Object_Script_Desk
	 */
	private $desk = null;

	/**
	 * 获取卓台对象
	 *
	 * @return Object_Script_Desk NULL
	 */
	public function GetDesk() {
		$desk = new Object_Script_Desk ( $this->desk );
		if ($desk->GetId () > 0) {
			return $desk;
		} else {
			return null;
		}
	}

	/**
	 * 设置卓台对象
	 *
	 * @param Object_Script_Desk $desk        	
	 * @throws Exception
	 */
	public function SetDesk(Object_Script_Desk $desk) {
		if (! is_null ( $desk )) {
			if (! is_null ( $this->desk )) {
				if ($this->desk != $desk->GetId ()) {
					$this->desk = $desk->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->desk = $desk->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "desk OBJECT IS NULL" );
		}
	}
	
	/**
	 * 主持人用户对象
	 *
	 * @var Object_User_Base
	 */
	private $host = null;

	/**
	 * 获取主持人用户对象
	 *
	 * @return Object_User_Base NULL
	 */
	public function GetHost() {
		$host = new Object_User_Base ( $this->host );
		if ($host->GetId () > 0) {
			return $host;
		} else {
			return null;
		}
	}

	/**
	 * 设置主持人用户对象
	 *
	 * @param Object_User_Base $host        	
	 * @throws Exception
	 */
	public function SetHost(Object_User_Base $host) {
		if (! is_null ( $host )) {
			if (! is_null ( $this->host )) {
				if ($this->host != $host->GetId ()) {
					$this->host = $host->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->host = $host->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "host OBJECT IS NULL" );
		}
	}
	
	/**
	 * 应收金额
	 *
	 * @var DECIMAL(10,2)
	 */
	private $receivableMoney = 0.00;

	/**
	 * 获取应收金额
	 *
	 * @return DECIMAL(10,2)
	 */
	public function GetReceivableMoney() {
		return $this->receivableMoney;
	}

	/**
	 * 设置应收金额
	 *
	 * @param DECIMAL(10,2) $receivableMoney        	
	 */
	public function SetReceivableMoney($receivableMoney) {
		if ($this->receivableMoney != sprintf ( "%.2f", $receivableMoney )) {
			$this->receivableMoney = sprintf ( "%.2f", $receivableMoney );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 实收金额
	 *
	 * @var DECIMAL(10,2)
	 */
	private $realMoney = 0.00;

	/**
	 * 获取实收金额
	 *
	 * @return DECIMAL(10,2)
	 */
	public function GetRealMoney() {
		return $this->realMoney;
	}

	/**
	 * 设置实收金额
	 *
	 * @param DECIMAL(10,2) $realMoney        	
	 */
	public function SetRealMoney($realMoney) {
		if ($this->realMoney != sprintf ( "%.2f", $realMoney )) {
			$this->realMoney = sprintf ( "%.2f", $realMoney );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 下单操作员
	 *
	 * @var Object_User_Base
	 */
	private $orderOperator = null;

	/**
	 * 获取下单操作员
	 *
	 * @return Object_User_Base NULL
	 */
	public function GetOrderOperator() {
		$orderOperator = new Object_User_Base ( $this->orderOperator );
		if ($orderOperator->GetId () > 0) {
			return $orderOperator;
		} else {
			return null;
		}
	}

	/**
	 * 设置下单操作员
	 *
	 * @param Object_User_Base $orderOperator        	
	 * @throws Exception
	 */
	public function SetOrderOperator(Object_User_Base $orderOperator) {
		if (! is_null ( $orderOperator )) {
			if (! is_null ( $this->orderOperator )) {
				if ($this->orderOperator != $orderOperator->GetId ()) {
					$this->orderOperator = $orderOperator->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->orderOperator = $orderOperator->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "orderOperator OBJECT IS NULL" );
		}
	}
	
	/**
	 * 下单时间
	 *
	 * @var DateTime
	 */
	private $orderTime = "0000-00-00 00:00:00";

	/**
	 * 获取下单时间
	 *
	 * @return DateTime
	 */
	public function GetOrderTime() {
		return $this->orderTime;
	}

	/**
	 * 设置下单时间
	 *
	 * @param DateTime $orderTime        	
	 */
	public function SetOrderTime($orderTime) {
		if ($this->orderTime != $orderTime) {
			$this->orderTime = $orderTime;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 结算操作员
	 *
	 * @var Object_User_Base
	 */
	private $settlementOperator = null;

	/**
	 * 获取结算操作员
	 *
	 * @return Object_User_Base
	 */
	public function GetSettlementOperator() {
		$settlementOperator = new Object_User_Base ( $this->settlementOperator );
		if ($settlementOperator->GetId () > 0) {
			return $settlementOperator;
		} else {
			return null;
		}
	}

	/**
	 * 设置结算操作员
	 *
	 * @param Object_User_Base $settlementOperator        	
	 */
	public function SetSettlementOperator(Object_User_Base $settlementOperator) {
		if ($this->settlementOperator != $settlementOperator->GetId ()) {
			$this->settlementOperator = $settlementOperator->GetId ();
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 结算时间
	 *
	 * @var DateTime
	 */
	private $settlementTime = "0000-00-00 00:00:00";

	/**
	 * 获取结算时间
	 *
	 * @return DateTime
	 */
	public function GetSettlementTime() {
		return $this->settlementTime;
	}

	/**
	 * 设置结算时间
	 *
	 * @param DateTime $settlementTime        	
	 */
	public function SetSettlementTime($settlementTime) {
		if ($this->settlementTime != $settlementTime) {
			$this->settlementTime = $settlementTime;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 订单状态
	 *
	 * @var number
	 */
	private $status = 0;

	/**
	 * 获取订单状态
	 *
	 * @return number
	 */
	public function GetStatus() {
		return $this->status;
	}

	/**
	 * 设置订单状态
	 *
	 * @param number $status        	
	 */
	public function SetStatus($status) {
		if ($this->status != $status) {
			$this->status = $status;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 订单备注
	 *
	 * @var string
	 */
	private $remark = "";

	/**
	 * 获取订单备注
	 *
	 * @return string
	 */
	public function GetRemark() {
		return $this->remark;
	}

	/**
	 * 设置订单备注
	 *
	 * @param string $remark        	
	 */
	public function SetRemark($remark) {
		if ($this->remark != $remark) {
			$this->remark = $remark;
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_302" );
		$this->setMemcacheId ( PROJECT . "_302" );
		$this->setZendCacheId ( PROJECT . "_302" );
		$this->setZendCacheDir ( "/A3/302" );
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
			$this->SetOrderNo ( $data ['F1_A302'] );
			$this->script = $data ['F2_A302'];
			$this->store = $data ['F3_A302'];
			$this->desk = $data ['F4_A302'];
			$this->host = $data ['F5_A302'];
			$this->SetReceivableMoney ( $data ['F6_A302'] );
			$this->SetRealMoney ( $data ['F7_A302'] );
			$this->orderOperator = $data ['F8_A302'];
			$this->SetOrderTime ( $data ['F9_A302'] );
			$this->settlementOperator = $data ['F10_A302'];
			$this->SetSettlementTime ( $data ['F11_A302'] );
			$this->SetStatus ( $data ['F12_A302'] );
			$this->SetRemark ( $data ['F13_A302'] );
			$this->paymentMethod = $data ['F14_A302'];
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
				'F1_A302' => $this->GetOrderNo (),
				'F2_A302' => $this->script,
				'F3_A302' => $this->store,
				'F4_A302' => $this->desk,
				'F5_A302' => $this->host,
				'F6_A302' => $this->GetReceivableMoney (),
				'F7_A302' => $this->GetRealMoney (),
				'F8_A302' => $this->orderOperator,
				'F9_A302' => $this->GetOrderTime (),
				'F10_A302' => $this->settlementOperator,
				'F11_A302' => $this->GetSettlementTime (),
				'F12_A302' => $this->GetStatus (),
				'F13_A302' => $this->GetRemark (),
				'F14_A302' => $this->paymentMethod 
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