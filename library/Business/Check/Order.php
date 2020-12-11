<?php
class Business_Check_Order{

	public static function CheckStoreOrderDesk($storeId,$deskId){
		$table = new Custom_Adapter();
		$db = $table->getAdapter();
		$table->setTable ( PROJECT . "_302" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND F3_A302 = ? ', $storeId );
		$where .= $db->quoteInto ( ' AND F4_A302 = ? ', $deskId );
		$where .= $db->quoteInto ( ' AND F11_A302 = ? ', 10 );
		$row = $table->fetchRow ( $where );
		$result = is_null ( $row ) ? null : $row->toArray ();
		return count($result) > 0 ? true : false;
	}
}