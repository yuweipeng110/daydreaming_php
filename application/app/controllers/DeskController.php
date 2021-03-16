<?php
header ( "Content-type:text/html;charset=utf-8" );

class App_DeskController extends Custom_Webpage {

	public function getDeskOrderListAction() {
		$current = isset ( $this->params ['current'] ) ? $this->params ['current'] : 1;
		$pageSize = isset ( $this->params ['pageSize'] ) ? $this->params ['pageSize'] : 100;
		
		$storeId = $this->params ['storeId'];
		$storeId = 1;
		
		$deskList = Business_Script_List::GetEnabledDeskList ( $storeId );
		$paginate = new Paginate ( $deskList, $pageSize, $current );
		
		$listCollection = Business_Script_Tool::GetDeskOrderListFieldData ( $paginate->CurrentRecord () );
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'pageCount' => $paginate->PageCount (),
				'total' => $paginate->DataCount () 
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function getDeskListAction() {
		$current = isset ( $this->params ['current'] ) ? $this->params ['current'] : 1;
		$pageSize = isset ( $this->params ['pageSize'] ) ? $this->params ['pageSize'] : 10;
		
		$deskList = Business_Script_List::GetDeskList ();
		$paginate = new Paginate ( $deskList, $pageSize, $current );
		
		$listCollection = Business_Script_Tool::GetDeskListFieldData ( $paginate->CurrentRecord () );
		
		$message = array (
				"code" => 10200,
				"msg" => '成功',
				"data" => $listCollection,
				"time" => date ( 'Y-m-d H:i:s' ),
				'pageCount' => $paginate->PageCount () ,
				'total' => $paginate->DataCount()
		);
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function addDeskAction() {
		$storeId = $this->data ['storeId'];
		$title = $this->data ['title'];
		$isEnabled = $this->data ['isEnabled'];
		
		$desk = new Business_Webpage_Desk ();
		$result = $desk->AddDesk ( $storeId, $title, $isEnabled );
		
		$message = array (
				"code" => $desk->GetCode (),
				"msg" => $desk->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($desk->GetData ()) {
			$message ['data'] = $desk->GetData ();
		}
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}

	public function editDeskAction() {
		$deskId = $this->data ['deskId'];
		$title = $this->data ['title'];
		$isEnabled = $this->data ['isEnabled'];
		
		$desk = new Business_Webpage_Desk ();
		$result = $desk->EditDesk ( $deskId, $title, $isEnabled );
		
		$message = array (
				"code" => $desk->GetCode (),
				"msg" => $desk->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($desk->GetData ()) {
			$message ['data'] = $desk->GetData ();
		}
		echo JsonData::ResultNotEncrypt ( $message );
		exit ();
	}
}