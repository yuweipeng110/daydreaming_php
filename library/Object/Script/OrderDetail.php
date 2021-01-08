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
		return $this->isPay;
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
	 * 结算方式
	 *
	 * @var Object_Script_ParmentMethod
	 */
	private $paymentMethod = null;
	
	/**
	 * 获取结算方式
	 *
	 * @return Object_Script_ParmentMethod
	 */
	public function GetPaymentMethod() {
		$paymentMethod = new Object_Script_ParmentMethod ( $this->paymentMethod );
		if ($paymentMethod->GetId () > 0) {
			return $paymentMethod;
		} else {
			return null;
		}
	}
	
	/**
	 * 设置结算方式
	 *
	 * @param Object_Script_ParmentMethod $paymentMethod
	 */
	public function SetPaymentMethod(Object_Script_ParmentMethod $paymentMethod) {
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
				'F7_A303' => $this->paymentMethod 
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