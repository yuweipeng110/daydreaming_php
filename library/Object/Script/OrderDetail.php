<?php

/**
 * 订单明细表
 * @author xy
 *
 */
class Object_Script_OrderDetail extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 订单对象
	 *
	 * @var Object_Script_Order
	 */
	private $order = null;

	/**
	 * 获取订单对象
	 *
	 * @return Object_Script_Order NULL
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
	 * @param Object_Script_Order $store        	
	 * @throws Exception
	 */
	public function SetOrder(Object_Script_Order $order) {
		if (! is_null ( $order )) {
			if (! is_null ( $this->order )) {
				if ($this->order != $order->GetId ()) {
					$this->order = $order->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->order = $order->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "order OBJECT IS NULL" );
		}
	}
	
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
	 * 单价
	 *
	 * @var DECIMAL(10,2)
	 */
	private $unitPrice = 0.00;

	/**
	 * 获取单价
	 *
	 * @return DECIMAL(10,2)
	 */
	public function GetUnitPrice() {
		return $this->unitPrice;
	}

	/**
	 * 设置单价
	 *
	 * @param DECIMAL(10,2) $unitPrice        	
	 */
	public function SetUnitPrice($unitPrice) {
		if ($this->unitPrice != sprintf ( "%.2f", $unitPrice )) {
			$this->unitPrice = sprintf ( "%.2f", $unitPrice );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 是否付费
	 *
	 * @var number
	 */
	private $isPay = 0;

	/**
	 * 获取是否付费
	 *
	 * @return number
	 */
	public function GetIsPay() {
		return ( int ) $this->isPay;
	}

	/**
	 * 设置是否付费
	 *
	 * @param number $isPay        	
	 */
	public function SetIsPay($isPay) {
		if ($this->isPay != $isPay) {
			$this->isPay = $isPay;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 折扣
	 *
	 * @var DECIMAL(10,2)
	 */
	private $discount = 0.00;

	/**
	 * 获取折扣
	 *
	 * @return DECIMAL(10,2)
	 */
	public function GetDiscount() {
		return $this->discount;
	}

	/**
	 * 设置折扣
	 *
	 * @param DECIMAL(10,2) $discount        	
	 */
	public function SetDiscount($discount) {
		if ($this->discount != sprintf ( "%.2f", $discount )) {
			$this->discount = sprintf ( "%.2f", $discount );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 结算价格
	 *
	 * @var DECIMAL(10,2)
	 */
	private $settlementPrice = 0.00;

	/**
	 * 获取结算价格
	 *
	 * @return DECIMAL(10,2)
	 */
	public function GetSettlementPrice() {
		return $this->settlementPrice;
	}

	/**
	 * 设置结算价格
	 *
	 * @param DECIMAL(10,2) $settlementPrice        	
	 */
	public function SetSettlementPrice($settlementPrice) {
		if ($this->settlementPrice != sprintf ( "%.2f", $settlementPrice )) {
			$this->settlementPrice = sprintf ( "%.2f", $settlementPrice );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 支付方式
	 *
	 * @var Object_Script_PaymentMethod
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
	 * 游戏角色
	 *
	 * @var number
	 */
	private $gameRole = 0;

	/**
	 * 获取游戏角色
	 *
	 * @return number
	 */
	public function GetGameRole() {
		return ( int ) $this->gameRole;
	}

	/**
	 * 设置游戏角色
	 *
	 * @param number $gameRole        	
	 */
	public function SetGameRole($gameRole) {
		if ($this->gameRole != $gameRole) {
			$this->gameRole = $gameRole;
			$this->isValueChanged = true;
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
		return ( int ) $this->integral;
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
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_303" );
		$this->setMemcacheId ( PROJECT . "_303" );
		$this->setZendCacheId ( PROJECT . "_303" );
		$this->setZendCacheDir ( "/A3/303" );
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
			$this->order = $data ['F1_A303'];
			$this->user = $data ['F2_A303'];
			$this->SetUnitPrice ( $data ['F3_A303'] );
			$this->SetIsPay ( $data ['F4_A303'] );
			$this->SetDiscount ( $data ['F5_A303'] );
			$this->SetSettlementPrice ( $data ['F6_A303'] );
			$this->paymentMethod = $data ['F7_A303'];
			$this->SetGameRole ( $data ['F8_A303'] );
			$this->SetIntegral ( $data ['F9_A303'] );
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
				'F1_A303' => $this->order,
				'F2_A303' => $this->user,
				'F3_A303' => $this->GetUnitPrice (),
				'F4_A303' => $this->GetIsPay (),
				'F5_A303' => $this->GetDiscount (),
				'F6_A303' => $this->GetSettlementPrice (),
				'F7_A303' => $this->paymentMethod,
				'F8_A303' => $this->GetGameRole (),
				'F9_A303' => $this->GetIntegral () 
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