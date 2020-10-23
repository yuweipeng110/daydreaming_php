<?php

/**
 * 后台登录验证类
 * 
 * @author Finder
 *
 */
class System_Admin_Signin extends Data_List {

	/**
	 * 后台登录验证类
	 */
	public function __construct() {
		$this->setTableName ( PROJECT . "_101" );
		
		$this->initCache ();
		$this->initAdapter ();
	}

	/**
	 * 验证用户
	 *
	 * @param 用户名 $userName        	
	 * @param 密码 $password        	
	 */
	public function CheckUser($userName, $password) {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A101 = ? ', $userName );
		$where .= $this->db->quoteInto ( ' AND F2_A101 = ? ', Format::FormatStreamEncrypt ( $password ) );
		$row = $this->table->fetchRow ( $where );
		if ($row != null && $row ['ISREMOVE_A101'] == 0) {
			return $row ['ID'];
		} else {
			return 0;
		}
	}
}