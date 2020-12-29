<?php

class Business_Promotions_List {

	public static function GetPromotionsList() {
		$objectList = array ();
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$table->setTable ( PROJECT . "_601" );
		$where = $db->quoteInto ( ' 1 = 1 ', null );
		$order = "F4_A601 DESC";
		$data = $table->fetchAll ( $where, $order );
		
		foreach ( $data as $value ) {
			$objectList [] = $value ['ID'];
		}
		return $objectList;
	}
}