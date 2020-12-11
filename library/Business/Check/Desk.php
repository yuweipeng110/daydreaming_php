<?php

class Business_Check_Desk {

	public static function CheckStoreDeskTitle($storeId, $title) {
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_304" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND F3_A304 = ? ', $storeId );
		$where .= $db->quoteInto ( ' AND F1_A304 = ? ', $title );
		$row = $table->fetchRow ( $where );
		$result = is_null ( $row ) ? null : $row->toArray ();
		return count ( $result ) > 0 ? false : true;
	}

	public static function CheckStoreDeskTitleOnly($deskId, $storeId, $title) {
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_203" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND ID != ? ', $deskId );
		$where .= $db->quoteInto ( ' AND F3_A304 = ? ', $storeId );
		$where .= $db->quoteInto ( ' AND F1_A304 = ? ', $title );
		$row = $table->fetchRow ( $where );
		$result = is_null ( $row ) ? null : $row->toArray ();
		return $result != null ? false : true;
	}
}