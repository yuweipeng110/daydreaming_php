<?php
class Business_Check_User{


	public static function CheckPhone($phone) {
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_201" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where = $db->quoteInto ( ' F6_A201 = ? ', $phone );
		$row = $table->fetchRow ( $where );
		$result = is_null ( $row ) ? null : $row->toArray ();
		return $result != null ? false : true;
	}
}