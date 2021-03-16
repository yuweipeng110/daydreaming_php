<?php

class Business_Promotions_List {

	public static function GetPromotionsList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_601" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
// 		$where .= $db->quoteInto ( ' AND F2_A601 <= ? ', date ( 'Y-m-d H:i:s' ) );
// 		$where .= $db->quoteInto ( ' AND F3_A601 >= ? ', date ( 'Y-m-d H:i:s' ) );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}

	public static function GetOpenPromotionsList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_601" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$where .= $db->quoteInto ( ' AND F2_A601 <= ? ', date ( 'Y-m-d H:i:s' ) );
		$where .= $db->quoteInto ( ' AND F3_A601 >= ? ', date ( 'Y-m-d H:i:s' ) );
		$order = "OTIME DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}
}