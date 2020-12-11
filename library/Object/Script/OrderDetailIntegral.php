<?php

/**
 * 剧本开局明细积分表
 * @author xy
 *
 */
class Object_Script_OrderDetailIntegral extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 订单明细对象
	 *
	 * @var Object_Script_OrderDetail
	 */
	private $orderDetail = null;

	/**
	 * 获取订单明细对象
	 *
	 * @return Object_Script_OrderDetail NULL
	 */
	public function GetOrderDetail() {
		$orderDetail = new Object_Script_OrderDetail ( $this->orderDetail );
		if ($orderDetail->GetId () > 0) {
			return $orderDetail;
		} else {
			return null;
		}
	}

	/**
	 * 设置订单明细对象
	 *
	 * @param Object_Script_OrderDetail $orderDetail        	
	 * @throws Exception
	 */
	public function SetOrderDetail(Object_Script_OrderDetail $orderDetail) {
		if (! is_null ( $orderDetail )) {
			if (! is_null ( $this->orderDetail )) {
				if ($this->orderDetail != $orderDetail->GetId ()) {
					$this->orderDetail = $orderDetail->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->orderDetail = $orderDetail->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "orderDetail OBJECT IS NULL" );
		}
	}
	
	/**
	 * 游戏角色
	 *
	 * @var Object_User_Role
	 */
	private $role = null;

	/**
	 * 获取游戏角色
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
	 * 设置游戏角色
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
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_304" );
		$this->setMemcacheId ( PROJECT . "_304" );
		$this->setZendCacheId ( PROJECT . "_304" );
		$this->setZendCacheDir ( "/A3/304" );
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
			$this->orderDetail = $data ['F1_A304'];
			$this->role = $data ['F2_A304'];
			$this->SetIntegral ( $data ['F3_A304'] );
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
				'F1_A304' => $this->orderDetail,
				'F2_A304' => $this->role,
				'F3_A304' => $this->GetIntegral () 
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