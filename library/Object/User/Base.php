<?php

/**
 * 用户表
 * @author xy
 *
 */
class Object_User_Base extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 角色
	 *
	 * @var number
	 */
	private $role = 0;

	/**
	 * 获取角色
	 *
	 * @return number
	 */
	public function GetRole() {
		return $this->role;
	}

	/**
	 * 设置角色
	 *
	 * @param number $role        	
	 */
	public function SetRole($role) {
		if ($this->role != $role) {
			$this->role = $role;
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
	 * 系统用户
	 *
	 * @var System_Admin_User
	 */
	private $systemUser = null;

	/**
	 * 获取系统用户
	 *
	 * @return System_Admin_User
	 */
	public function GetSystemUser() {
		$systemUser = new System_Admin_User ( $this->systemUser );
		if ($systemUser->GetId () > 0) {
			return $systemUser;
		} else {
			return null;
		}
	}

	/**
	 * 设置系统用户
	 *
	 * @param System_Admin_User $systemUser        	
	 */
	public function SetSystemUser(System_Admin_User $systemUser) {
		if ($this->systemUser != $systemUser->GetId ()) {
			$this->systemUser = $systemUser->GetId ();
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 昵称
	 *
	 * @var string
	 */
	private $nickname = "";

	/**
	 * 获取昵称
	 *
	 * @return string
	 */
	public function GetNickname() {
		return $this->nickname;
	}

	/**
	 * 设置昵称
	 *
	 * @param string $nickname        	
	 */
	public function SetNickname($nickname) {
		if ($this->nickname != $nickname) {
			$this->nickname = $nickname;
			$this->isValueChanged = true;
		}
	}
	private $sex = 0;

	/**
	 * 获取性别
	 *
	 * @return string
	 */
	public function GetSex() {
		return $this->sex;
	}

	/**
	 * 设置性别
	 *
	 * @param string $sex        	
	 */
	public function SetSex($sex) {
		if ($this->sex != $sex) {
			$this->sex = $sex;
			$this->isValueChanged = true;
		}
	}
	private $phone = "";

	/**
	 * 获取电话
	 *
	 * @return string
	 */
	public function GetPhone() {
		return $this->phone;
	}

	/**
	 * 设置电话
	 *
	 * @param string $phone        	
	 */
	public function SetPhone($phone) {
		if ($this->phone != $phone) {
			$this->phone = $phone;
			$this->isValueChanged = true;
		}
	}
	private $killerIntegral = 0;

	/**
	 * 获取杀手积分
	 *
	 * @return string
	 */
	public function GetKillerIntegral() {
		return $this->killerIntegral;
	}

	/**
	 * 设置杀手积分
	 *
	 * @param string $killerIntegral        	
	 */
	public function SetKillerIntegral($killerIntegral) {
		if ($this->killerIntegral != $killerIntegral) {
			$this->killerIntegral = $killerIntegral;
			$this->isValueChanged = true;
		}
	}
	private $detectiveIntegral = 0;

	/**
	 * 获取侦探积分
	 *
	 * @return string
	 */
	public function GetDetectiveIntegral() {
		return $this->detectiveIntegral;
	}

	/**
	 * 设置侦探积分
	 *
	 * @param string $detectiveIntegral        	
	 */
	public function SetDetectiveIntegral($detectiveIntegral) {
		if ($this->detectiveIntegral != $detectiveIntegral) {
			$this->detectiveIntegral = $detectiveIntegral;
			$this->isValueChanged = true;
		}
	}
	private $peopleIntegral = 0;

	/**
	 * 获取路人积分
	 *
	 * @return string
	 */
	public function GetPeopleIntegral() {
		return $this->peopleIntegral;
	}

	/**
	 * 设置路人积分
	 *
	 * @param string $peopleIntegral        	
	 */
	public function SetPeopleIntegral($peopleIntegral) {
		if ($this->peopleIntegral != $peopleIntegral) {
			$this->peopleIntegral = $peopleIntegral;
			$this->isValueChanged = true;
		}
	}
	
	private $remark = "";

	/**
	 * 获取备注
	 *
	 * @return string
	 */
	public function GetRemark() {
		return $this->remark;
	}
	
	/**
	 * 设置备注
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
		$this->setTableName ( PROJECT . "_201" );
		$this->setMemcacheId ( PROJECT . "_201" );
		$this->setZendCacheId ( PROJECT . "_201" );
		$this->setZendCacheDir ( "/A2/201" );
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
			$this->SetRole ( $data ['F1_A201'] );
			$this->store = $data ['F2_A201'];
			$this->systemUser = $data ['F3_A201'];
			$this->SetNickname ( $data ['F4_A201'] );
			$this->SetSex ( $data ['F5_A201'] );
			$this->SetPhone ( $data ['F6_A201'] );
			$this->SetKillerIntegral ( $data ['F7_A201'] );
			$this->SetDetectiveIntegral ( $data ['F8_A201'] );
			$this->SetPeopleIntegral ( $data ['F9_A201'] );
			$this->SetRemark($data['F10_A201']);
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
				'F1_A201' => $this->GetRole (),
				'F2_A201' => $this->store,
				'F3_A201' => $this->systemUser,
				'F4_A201' => $this->GetNickname (),
				'F5_A201' => $this->GetSex (),
				'F6_A201' => $this->GetPhone (),
				'F7_A201' => $this->GetKillerIntegral (),
				'F8_A201' => $this->GetDetectiveIntegral (),
				'F9_A201' => $this->GetPeopleIntegral () ,
				'F10_A201' => $this->GetRemark()
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