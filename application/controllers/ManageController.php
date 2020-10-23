<?php
header ( "Content-type:text/html;charset=utf-8" );

class ManageController extends Custom_Competence {

	public function init() {
		parent::init ();
		$this->view->assign ( "user", $this->user );
	}
	// ---------------------------------------------------------------------------------------------
	public function indexAction() {
		// start menu
		$group = new System_Admin_Group ();
		$this->view->assign ( "group", $group );
		
		$selfMenu = array ();
		
		// 用户所属分组所有权限
		$groupCongregation = new System_Admin_Congregation ( $this->user );
		foreach ( $groupCongregation->GetItems () as $valueCongregation ) {
			$groupRelation = new System_Admin_Purview ( $valueCongregation->GetOrganize () );
			foreach ( $groupRelation->GetMenus () as $valueMenu ) {
				$selfMenu [] = $valueMenu->GetId ();
			}
		}
		
		$userRelation = new System_Admin_Relation ( $this->user );
		foreach ( $userRelation->GetMenus () as $valueMenu ) {
			$selfMenu [] = $valueMenu->GetId ();
		}
		
		$this->view->assign ( "selfMenu", $selfMenu );
		// end menu
		
		$this->render ( "index" );
	}

	public function menuAction() {
		$this->render ( "menu" );
	}

	public function systemAction() {
		$group = new System_Admin_Group ();
		$billStatistics = new Business_Bill_Statistics ();
		
		$searchStartDate = $this->_getParam ( "searchStartDate", date ( "Y-m-d" ) );
		$searchEndDate = $this->_getParam ( "searchEndDate", date ( "Y-m-d" ) );
		$categories = array ();
		$series = array ();
		
		$table0Data = array ();
		$table1Data = array ();
		$table2Data = array ();
		$table3Data = array ();
		$table4Data = array ();
		foreach ( Business_Statistics_TransactionDay::GetOrderBusStatisticsFromDate ( $searchStartDate, $searchEndDate ) as $value ) {
			$orderBus = new Business_Option_OrderBus ( $value ['OrderBusId'] );
			$categories [] = $orderBus->GetOrderName ();
			
			$table0Data [] = ( float ) $value ['TABLE0_AllMoney'];
			$table1Data [] = ( float ) $value ['TABLE1_AllMoney'];
			$table2Data [] = ( float ) $value ['TABLE2_AllMoney'];
			$table3Data [] = ( float ) $value ['TABLE3_AllMoney'];
			$table4Data [] = ( float ) $value ['TABLE4_AllMoney'];
		}
		
		$tmpArr = array ();
		$tmpArr ['name'] = "总计";
		$tmpArr ['data'] = $table0Data;
		$series [] = $tmpArr;
		
		foreach ( Business_Option_List::GetPayTypeList () as $payTypeId ) {
			$payType = new Business_Option_PayType ( $payTypeId );
			$tmpArr = array ();
			$tmpArr ['name'] = $payType->GetPayTypeName ();
			switch ($payTypeId) {
				case 1 :
					$tmpArr ['data'] = $table1Data;
					break;
				case 2 :
					$tmpArr ['data'] = $table2Data;
					break;
				case 3 :
					$tmpArr ['data'] = $table3Data;
					break;
				case 4 :
					$tmpArr ['data'] = $table4Data;
					break;
			}
			$series [] = $tmpArr;
		}
		
		$this->view->assign ( "categories", $categories );
		$this->view->assign ( "series", $series );
		$this->view->assign ( "billStatistics", $billStatistics );
		$this->view->assign ( "groupSubsetList", $group->GetSubsetList () );
		$this->render ( "system" );
	}

	public function menuListAction() {
		$this->render ( "menu-list" );
	}

	public function menuEditAction() {
		$menuId = $this->_getParam ( "menuId", 0 );
		
		$group = new System_Admin_Group ();
		$this->view->assign ( "group", $group );
		$this->view->assign ( "menuId", $menuId );
		$this->render ( "menu-edit" );
	}

	public function menuProcessAction() {
		if ($this->_getParam ( "act" ) == "menuList") {
			$group = new System_Admin_Group ();
			$groupItems = $group->GetMenuList ();
			
			$listCollection = array ();
			foreach ( $groupItems as $value ) {
				$valueData = array ();
				$valueData ['id'] = $value->GetId ();
				$valueData ['title'] = $value->GetTitle ();
				$valueData ['url'] = $value->GetUrl ();
				$valueData ['parentId'] = $value->GetParentMenu () == null ? 0 : $value->GetParentMenu ()->GetId ();
				$valueData ['parentTitle'] = $value->GetParentMenu () == null ? 0 : $value->GetParentMenu ()->GetTitle ();
				
				$listCollection [] = $valueData;
			}
			$jsonData = array (
					"code" => 0,
					"msg" => "数据更新成功",
					"data" => $listCollection,
					"count" => count ( $groupItems ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "editMenu") {
			$menuId = $this->_getParam ( "menuId", 0 );
			$parentId = $this->_getParam ( "parentId", 0 );
			$title = $this->_getParam ( "title", "" );
			$url = $this->_getParam ( "url", "" );
			
			$menu = new System_Admin_Menu ( $menuId );
			$newParent = new System_Admin_Menu ( $parentId );
			$oldParent = $menu->GetParentMenu ();
			$menu->SetParentMenu ( $newParent );
			$menu->SetTitle ( $title );
			$menu->SetUrl ( $url );
			$menu->Save ();
			
			! is_null ( $newParent ) ? $newParent->GetChildren ( true ) : "";
			! is_null ( $oldParent ) ? $oldParent->GetChildren ( true ) : "";
			
			$jsonData = array (
					"code" => 0,
					"msg" => "数据更新成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "removeMenu") {
			$menuId = $this->_getParam ( "menuId", 0 );
			
			$menu = new System_Admin_Menu ( $menuId );
			$menu->Destroy ();
			
			$jsonData = array (
					"code" => 0,
					"msg" => "数据更新成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		}
	}

	public function organizeListAction() {
		$this->render ( "organize-list" );
	}

	public function organizeEditAction() {
		$organizeId = $this->_getParam ( "organizeId", 0 );
		
		$this->view->assign ( "organizeId", $organizeId );
		$this->render ( "organize-edit" );
	}

	public function organizePurviewListAction() {
		$organizeId = $this->_getParam ( "organizeId", 0 );
		
		$this->view->assign ( "organizeId", $organizeId );
		$this->render ( "organize-purview-list" );
	}

	public function organizeProcessAction() {
		if ($this->_getParam ( "act" ) == "pageList") {
			$currentPage = ( int ) $this->_getParam ( "page", 1 );
			$pageRecords = ( int ) $this->_getParam ( "rows", 5 );
			
			$converge = new System_Admin_Converge ();
			$paginate = new Paginate ( $converge->GetItems (), $pageRecords, $currentPage );
			
			$listCollection = array ();
			foreach ( $paginate->CurrentRecord () as $value ) {
				$valueData = array ();
				$valueData ['id'] = $value->GetId ();
				$valueData ['title'] = $value->GetTitle ();
				
				$listCollection [] = $valueData;
			}
			$jsonData = array (
					"code" => 0,
					"data" => $listCollection,
					"count" => $paginate->DataCount () 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "editOrganize") {
			$organizeId = $this->_getParam ( "organizeId", 0 );
			$title = $this->_getParam ( "title", "" );
			
			$organize = new System_Admin_Organize ( $organizeId );
			$organize->SetTitle ( $title );
			$organize->Save ();
			
			$jsonData = array (
					"code" => 0,
					"msg" => "数据更新成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "removeOrganize") {
			$organizeId = $this->_getParam ( "organizeId", 0 );
			
			$organize = new System_Admin_Organize ( $organizeId );
			$organize->Destroy ();
			
			$jsonData = array (
					"code" => 0,
					"msg" => "删除成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "organizePurviewList") {
			$organizeId = $this->_getParam ( "organizeId", 0 );
			
			$organize = new System_Admin_Organize ( $organizeId );
			$adminPurview = new System_Admin_Purview ( $organize );
			
			$group = new System_Admin_Group ();
			$groupItems = $group->GetMenuList ();
			
			$listCollection = array ();
			foreach ( $groupItems as $menuValue ) {
				$valueData = array ();
				$valueData ['id'] = $menuValue->GetId ();
				$valueData ['url'] = $menuValue->GetUrl ();
				$valueData ['title'] = $menuValue->GetTitle ();
				$valueData ['parentId'] = $menuValue->GetParentMenu () == null ? 0 : $menuValue->GetParentMenu ()->GetId ();
				$valueData ['parentTitle'] = $menuValue->GetParentMenu () == null ? "" : $menuValue->GetParentMenu ()->GetTitle ();
				
				$isChecked = false;
				foreach ( $adminPurview->GetMenus () as $k => $v ) {
					if ($menuValue->GetId () == $v->GetId ()) {
						$isChecked = true;
						break;
					}
				}
				$valueData ['purview'] = $isChecked;
				$valueData ['isShowReadonly'] = $isChecked;
				
				$readonly = false;
				foreach ( $adminPurview->GetPurview () as $v ) {
					if ($menuValue->GetId () == $v->GetMenu ()->GetId ()) {
						$readonly = $v->GetReadOnly ();
						break;
					}
				}
				$valueData ['readonly'] = $readonly;
				
				$listCollection [] = $valueData;
			}
			
			$jsonData = array (
					"code" => 0,
					"data" => $listCollection,
					"count" => count ( $groupItems ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "organizePurviewEdit") {
			$organizeId = $this->_getParam ( "organizeId", 0 );
			
			$organize = new System_Admin_Organize ( $organizeId );
			$adminPurview = new System_Admin_Purview ( $organize );
			
			$adminPurview->ClearPurview ();
			$purview = $this->_getParam ( "purview", array () );
			$readonly = $this->_getParam ( "readonly", array () );
			foreach ( $purview as $menuId ) {
				$adminPurview->AppendPurview ( new System_Admin_Menu ( $menuId ), false );
			}
			
			foreach ( $adminPurview->GetPurview () as $purviewKey => $purviewValue ) {
				$isReadOnly = false;
				foreach ( $readonly as $readonlyKey => $readonlyValue ) {
					if ($purviewValue->GetMenu ()->GetId () == $readonlyValue) {
						$isReadOnly = true;
						break;
					}
				}
				$purviewValue->SetReadOnly ( $isReadOnly );
				$purviewValue->Save ();
			}
			
			$jsonData = array (
					"code" => 0,
					"msg" => "数据更新成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		}
	}

	public function userListAction() {
		$this->render ( "user-list" );
	}

	public function userEditAction() {
		$userId = $this->_getParam ( "userId", 0 );
		
		$this->view->assign ( "userId", $userId );
		$this->render ( "user-edit" );
	}

	public function userRelationListAction() {
		$userId = $this->_getParam ( "userId", 0 );
		
		$this->view->assign ( "userId", $userId );
		$this->render ( "user-relation-list" );
	}

	public function userComparisonListAction() {
		$userId = $this->_getParam ( "userId", 0 );
		
		$this->view->assign ( "userId", $userId );
		$this->render ( "user-comparison-list" );
	}

	public function userProcessAction() {
		if ($this->_getParam ( "act" ) == "pageList") {
			$currentPage = ( int ) $this->_getParam ( "page", 1 );
			$pageRecords = ( int ) $this->_getParam ( "rows", 5 );
			
			$manager = new System_Admin_Manager ();
			$paginate = new Paginate ( $manager->GetItems (), $pageRecords, $currentPage );
			
			$listCollection = array ();
			foreach ( $paginate->CurrentRecord () as $value ) {
				$valueData = array ();
				$valueData ['id'] = $value->GetId ();
				$valueData ['userName'] = $value->GetUserName ();
				$valueData ['password'] = $value->GetPassword ();
				$valueData ['realName'] = $value->GetRealName ();
				
				$listCollection [] = $valueData;
			}
			$jsonData = array (
					"code" => 0,
					"data" => $listCollection,
					"count" => $paginate->DataCount () 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "editUser") {
			$userId = $this->_getParam ( "userId", 0 );
			$userName = $this->_getParam ( "userName", "" );
			$password = $this->_getParam ( "password", "" );
			$realName = $this->_getParam ( "realName", "" );
			
			if ($userId > 1) {
				$user = new System_Admin_User ( $userId );
				$user->SetUserName ( $userName );
				$user->SetPassword ( $password );
				$user->SetRealName ( $realName );
				$user->Save ();
			}
			
			$jsonData = array (
					"code" => 0,
					"msg" => "数据更新成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "removeUser") {
			$userId = $this->_getParam ( "userId", 0 );
			
			if ($userId > 1) {
				$user = new System_Admin_User ( $userId );
				$user->SetIsRemove ( false );
				$user->Save ();
			}
			
			$jsonData = array (
					"code" => 0,
					"msg" => "删除成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "resetUser") {
			$userId = $this->_getParam ( "userId", 0 );
			
			if ($userId != 1) {
				$user = new System_Admin_User ( $userId );
				$user->SetPassword ( "123456" );
				$user->Save ();
			}
			
			$jsonData = array (
					"code" => 0,
					"msg" => "数据更新成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "userRelationList") {
			$userId = $this->_getParam ( "userId", 0 );
			
			$user = new System_Admin_User ( $userId );
			$userRelation = new System_Admin_Relation ( $user );
			
			$group = new System_Admin_Group ();
			$groupItems = $group->GetMenuList ();
			
			$listCollection = array ();
			foreach ( $groupItems as $menuValue ) {
				$valueData = array ();
				$valueData ['id'] = $menuValue->GetId ();
				$valueData ['url'] = $menuValue->GetUrl ();
				$valueData ['title'] = $menuValue->GetTitle ();
				$valueData ['parentId'] = $menuValue->GetParentMenu () == null ? 0 : $menuValue->GetParentMenu ()->GetId ();
				$valueData ['parentTitle'] = $menuValue->GetParentMenu () == null ? "" : $menuValue->GetParentMenu ()->GetTitle ();
				
				$isChecked = false;
				foreach ( $userRelation->GetMenus () as $k => $v ) {
					if ($menuValue->GetId () == $v->GetId ()) {
						$isChecked = true;
						break;
					}
				}
				$valueData ['relation'] = $isChecked;
				$valueData ['isShowReadonly'] = $isChecked;
				
				$readonly = false;
				foreach ( $userRelation->GetRelation () as $v ) {
					if ($menuValue->GetId () == $v->GetMenu ()->GetId ()) {
						$readonly = $v->GetReadOnly ();
						break;
					}
				}
				$valueData ['readonly'] = $readonly;
				
				$listCollection [] = $valueData;
			}
			
			$jsonData = array (
					"code" => 0,
					"data" => $listCollection,
					"count" => count ( $groupItems ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "userRelationEdit") {
			$userId = $this->_getParam ( "userId", 0 );
			
			$user = new System_Admin_User ( $userId );
			$userRelation = new System_Admin_Relation ( $user );
			
			$userRelation->ClearRelation ();
			$relation = $this->_getParam ( "relation", array () );
			$readonly = $this->_getParam ( "readonly", array () );
			foreach ( $relation as $menuId ) {
				$userRelation->AppendRelation ( new System_Admin_Menu ( $menuId ), false );
			}
			
			foreach ( $userRelation->GetRelation () as $relationKey => $relationValue ) {
				$isReadOnly = false;
				foreach ( $readonly as $readonlyKey => $readonlyValue ) {
					if ($relationValue->GetMenu ()->GetId () == $readonlyValue) {
						$isReadOnly = true;
						break;
					}
				}
				$relationValue->SetReadOnly ( $isReadOnly );
				$relationValue->Save ();
			}
			
			$jsonData = array (
					"code" => 0,
					"msg" => "数据更新成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "userComparisonList") {
			$userId = $this->_getParam ( "userId", 0 );
			
			$user = new System_Admin_User ( $userId );
			$congregation = new System_Admin_Congregation ( $user );
			$managerConverge = new System_Admin_Converge ();
			$managerConvergeItems = $managerConverge->GetItems ();
			
			$listCollection = array ();
			foreach ( $managerConvergeItems as $value ) {
				$valueData = array ();
				$valueData ['id'] = $value->GetId ();
				$valueData ['organizeId'] = $value->GetId ();
				$valueData ['title'] = $value->GetTitle ();
				$comparisonId = 0;
				foreach ( $congregation->GetItems () as $congregationValue ) {
					if ($value->GetId () == $congregationValue->GetOrganize ()->GetId ()) {
						$comparisonId = $congregationValue->GetId ();
						break;
					}
				}
				$valueData ['comparisonId'] = $comparisonId;
				$valueData ['checked'] = $comparisonId > 0 ? true : false;
				
				$listCollection [] = $valueData;
			}
			
			$jsonData = array (
					"code" => 0,
					"data" => $listCollection,
					"count" => count ( $managerConvergeItems ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		} elseif ($this->_getParam ( "act" ) == "userComparisonEdit") {
			$comparisonId = $this->_getParam ( 'comparisonId', 0 );
			if ($comparisonId == 0) {
				$userId = $this->_getParam ( 'userId', 0 );
				$organizeId = $this->_getParam ( 'organizeId', 0 );
				
				$comparison = new System_Admin_Comparison ( 0 );
				$user = new System_Admin_User ( $userId );
				$organize = new System_Admin_Organize ( $organizeId );
				$comparison->SetUser ( $user );
				$comparison->SetOrganize ( $organize );
				$comparison->Save ();
			} else {
				$comparison = new System_Admin_Comparison ( $comparisonId );
				$comparison->Destroy ();
			}
			
			$jsonData = array (
					"code" => 0,
					"msg" => "数据更新成功",
					"time" => date ( 'Y-m-d H:i:s' ) 
			);
			echo JsonData::ArrayToJson ( $jsonData );
			exit ();
		}
	}
}