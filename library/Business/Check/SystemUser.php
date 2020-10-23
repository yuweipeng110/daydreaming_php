<?php
class Business_Check_SystemUser{

	public static function CheckSystemUserName($userName) {
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_101" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where = $db->quoteInto ( ' F1_A101 = ? ', $userName );
		$row = $table->fetchRow ( $where );
		$result = is_null ( $row ) ? null : $row->toArray ();
		return $result != null ? false : true;
	}
}