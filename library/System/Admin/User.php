<?php

/**
 * 后台用户
 * 
 * @author Finder
 *
 */
class System_Admin_User extends Data_Object {
	
	/**
	 * 用户名
	 *
	 * @var string
	 */
	private $userName = "";

	/**
	 * 获取用户名
	 */
	public function GetUserName() {
		return $this->userName;
	}

	/**
	 * 设置用户名
	 *
	 * @param string $userName        	
	 */
	public function SetUserName($userName) {
		$this->userName = $userName;
	}
	
	/**
	 * 密码
	 *
	 * @var string
	 */
	private $password = "123456";

	/**
	 * 获取密码
	 */
	public function GetPassword() {
		return rtrim ( Format::FormatStreamDecrypt ( $this->password ), "\0" );
	}

	/**
	 * 更改密码
	 *
	 * @param string $password        	
	 */
	public function SetPassword($password) {
		$this->password = Format::FormatStreamEncrypt ( $password );
	}
	
	/**
	 * 是否只读
	 *
	 * @var boolean
	 */
	private $readOnly = false;

	/**
	 * 获取用户是否只读
	 *
	 * @return boolean
	 */
	public function GetReadOnly() {
		return $this->readOnly;
	}

	/**
	 * 设置用户是否只读
	 *
	 * @param boolean $readOnly        	
	 */
	public function SetReadOnly($readOnly) {
		$this->readOnly = $readOnly;
	}
	
	/**
	 * 姓名
	 *
	 * @var string
	 */
	private $realName = "";

	/**
	 * 获取姓名
	 *
	 * @return string
	 */
	public function GetRealName() {
		return $this->realName;
	}

	/**
	 * 设置姓名
	 *
	 * @param string $realName        	
	 */
	public function SetRealName($realName) {
		$this->realName = $realName;
	}

	/**
	 * 获取主题
	 *
	 * @return string
	 */
	public function GetTheme() {
		return "base";
	}
	
	/**
	 * 用户权限
	 *
	 * @var System_Admin_Relation
	 */
	private $relation = null;

	/**
	 * 设置权限
	 *
	 * @param unknown_type $relationList        	
	 */
	public function SetRelation(System_Admin_Relation $relation) {
		$this->relation = $relation;
	}

	/**
	 * 获取权限
	 */
	public function GetRelation() {
		$this->relation = new System_Admin_Relation ( $this );
		return $this->relation;
	}
	
	/**
	 * 所属分组
	 *
	 * @var System_Admin_Team
	 */
	private $team = null;

	/**
	 * 获取所属分组
	 *
	 * @return System_Admin_Team NULL
	 */
	public function GetTeam() {
		$team = new System_Admin_Team ( $this->team );
		if (! is_null ( $team->GetId () )) {
			return $team;
		} else {
			return null;
		}
	}

	/**
	 * 设置所属分组
	 *
	 * @param System_Admin_Team $team        	
	 */
	public function SetTeam(System_Admin_Team $team) {
		if (! is_null ( $team->GetId () )) {
			if (is_null ( $this->team )) {
				$this->team = $team->GetId ();
			} else if ($this->team != $team->GetId ()) {
				$this->team = $team->GetId ();
			}
		} else {
			if (! is_null ( $this->team )) {
				$this->team = null;
			}
		}
	}
	
	/**
	 * 微信TOKEN
	 *
	 * @var string
	 */
	private $weChatToken = "";

	/**
	 * 获取微信TOKEN
	 *
	 * @return string
	 */
	public function GetWeChatToken() {
		return $this->weChatToken;
	}

	/**
	 * 设置微信TOKEN
	 *
	 * @param string $weChatToken        	
	 */
	public function SetWeChatToken($weChatToken) {
		if ($this->weChatToken != $weChatToken) {
			$this->weChatToken = $weChatToken;
		}
	}
	
	/**
	 * 排序参数
	 *
	 * @var int
	 */
	private $sort = 9999;

	/**
	 * 获取排序参数
	 *
	 * @return int
	 */
	public function GetSort() {
		return $this->sort;
	}

	/**
	 * 设置排序参数
	 *
	 * @param int $sort        	
	 */
	public function SetSort($sort) {
		$this->sort = $sort;
	}
	
	/**
	 * 是否可用
	 *
	 * @var number
	 */
	private $isRemove = false;

	/**
	 * 获取是否可用
	 *
	 * @return number
	 */
	public function GetIsRemove() {
		return $this->isRemove;
	}

	/**
	 * 设置是否可用
	 *
	 * @param number $isRemove        	
	 */
	public function SetIsRemove($isRemove) {
		$this->isRemove = $isRemove;
	}

	/**
	 * 后台用户
	 *
	 * @param number $id        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_101" );
		$this->setMemcacheId ( PROJECT . "_ADMIN_USER" );
		$this->setZendCacheId ( PROJECT . "_ADMIN_USER" );
		$this->setZendCacheDir ( "/ADMIN/USER" );
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
			$this->userName = $data ['F1_A101'];
			$this->password = $data ['F2_A101'];
			$this->SetReadOnly ( $data ['F3_A101'] == 1 );
			$this->realName = $data ['F4_A101'];
			$this->weChatToken = $data ['F5_A101'];
			$this->team = $data ['F6_A101'];
// 			$this->branch = $data ['F7_A101'];
			$this->SetSort ( $data ['F8_A101'] );
			$this->SetIsRemove ( $data ['ISREMOVE_A101'] == 1 );
			$this->SetOtime ( $data ['OTIME'] );
		} else {
			$this->SetId ( 0 );
		}
	}

	/**
	 * 保存
	 *
	 * @see Data_Object::Save()
	 */
	public function Save() {
		$data = array (
				'F1_A101' => $this->userName,
				'F2_A101' => $this->password,
				'F3_A101' => $this->GetReadOnly () ? "1" : "0",
				'F4_A101' => $this->realName,
				'F5_A101' => $this->weChatToken,
				'F6_A101' => $this->team,
// 				'F7_A101' => $this->branch,
				'F8_A101' => $this->GetSort (),
				'ISREMOVE_A101' => $this->GetIsRemove () ? "1" : "0" 
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
		return true;
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

	/**
	 * 获取登录系统的用户名是否存在
	 *
	 * @return boolean
	 */
	private function ExistsUserName() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A101 = ? ', $this->GetUserName () );
		$row = $this->table->fetchRow ( $where );
		return is_null ( $row ) ? false : true;
	}
}