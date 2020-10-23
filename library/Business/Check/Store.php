<?php
class Business_Check_Store{

	public static function CheckStoreName($name) {
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_203" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where = $db->quoteInto ( ' F1_A203 = ? ', $name );
		$row = $table->fetchRow ( $where );
		$result = is_null ( $row ) ? null : $row->toArray ();
		return $result != null ? false : true;
	}
	
	public static function CheckStoreNameOnly( $storeId,$name){
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_203" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND ID != ? ', $storeId );
		$where .= $db->quoteInto ( ' AND F1_A203 = ? ', $name );
		$row = $table->fetchRow ( $where );
		$result = is_null ( $row ) ? null : $row->toArray ();
		return $result != null ? false : true;
	}
}