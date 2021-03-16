<?php
header ( "Content-type:text/html;charset=utf-8" );

class App_PromotionsController extends Custom_Webpage {

	/**
	 * 获取活動列表
	 */
	public function getPromotionsListAction() {
		$current = isset ( $this->params ['current'] ) ? $this->params ['current'] : 1;
		$pageSize = isset ( $this->params ['pageSize'] ) ? $this->params ['pageSize'] : 10;
		
		$list = Business_Promotions_List::GetPromotionsList ();
		$paginate = new Paginate ( $list, $pageSize, $current );
		
		$listCollection = Business_Promotions_Tool::GetPromotionsListFieldData ( $paginate->CurrentRecord () );
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'total' => $paginate->DataCount () 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}
}