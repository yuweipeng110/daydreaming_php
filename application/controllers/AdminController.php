<?php
header ( "Content-type:text/html;charset=utf-8" );

class AdminController extends Custom_Competence {

	public function init() {
		parent::init ();
		$this->view->assign ( "user", $this->user );
	}
	// ---------------------------------------------------------------------------------------------
	public function indexAction() {
		$this->render ( "index" );
	}

	public function menuAction() {
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
		$this->render ( "left" );
	}

	public function helloAction() {
		$this->render ( "top" );
	}

	public function rightAction() {
		$this->render ( "right" );
	}

	public function informationAction() {
		$this->render ( "bottom" );
	}

	public function systemAction() {
		$system = new System_Admin_System ();
		$this->view->assign ( "system", $system );
		$this->render ( "system" );
	}

	public function settingAction() {
		$system = new System_Admin_System ();
		
		if ($this->act == "setting") {
			$title = $this->_getParam ( "title", "" );
			$keywords = $this->_getParam ( "keywords", "" );
			$description = $this->_getParam ( "description", "" );
			$icp = $this->_getParam ( "icp", "" );
			
			$system->SetTitle ( $title );
			$system->SetKeywords ( $keywords );
			$system->SetDescription ( $description );
			$system->SetIcp ( $icp );
			
			$system->Save ();
		}
		
		$this->view->assign ( "system", $system );
		
		$this->render ( "setting" );
	}

	public function logoffAction() {
		unset ( $this->application->manager );
		$this->_helper->redirector ( "login", "signin" );
	}

	public function passwordAction() {
		if ($this->act == "setPassword") {
			$password = $this->_getParam ( "password", null );
			$newPassword = $this->_getParam ( "newPassword", null );
			$retryPassword = $this->_getParam ( "retryPassword", null );
			if ($newPassword == $retryPassword) {
				if ($password == $this->user->GetPassword ()) {
					$this->user->SetPassword ( $newPassword );
					
					if ($this->user->Save ()) {
						echo "<script>alert('密码修改成功');</script>";
					} else {
						echo "<script>alert('修改失败');</script>";
					}
				} else {
					echo "<script>alert('原密码输入有误');</script>";
				}
			} else {
				echo "<script>alert('两次输入有误');</script>";
			}
		}
		
		$this->render ( "password" );
	}

	public function themeAction() {
		$handler = opendir ( $_SERVER ['DOCUMENT_ROOT'] . "/js/ui/themes/" );
		$themeList = array ();
		while ( ($filename = readdir ( $handler )) !== false ) {
			if ($filename != "." && $filename != "..") {
				$themeList [] = $filename;
			}
		}
		closedir ( $handler );
		
		$theme = $this->_getParam ( "Id", null );
		if (in_array ( $theme, $themeList )) {
			$this->user->SetTheme ( $theme );
			echo "<script>MenuFrameSet();</script>";
		}
		$this->view->assign ( "theme", $this->user->GetTheme () );
		$this->view->assign ( "themeList", $themeList );
		$this->render ( "theme" );
	}

	public function holdSessionAction() {
	}
	// ---------------------------------------------------------------------------------------------
	public function groupListAction() {
		if ($this->act == "edit") {
			$Id = $this->_getParam ( "Id", null );
			$title = ( string ) $this->_getParam ( "title", "" );
			$menu = new System_Admin_Menu ( $Id );
			$menu->SetTitle ( $title );
			$menu->Save ();
		} elseif ($this->act == "delete") {
			$Id = $this->_getParam ( "Id", null );
			$menu = new System_Admin_Menu ( $Id );
			$menu->Destroy ();
		}
		
		$group = new System_Admin_Group ();
		$this->view->assign ( "group", $group );
		
		$this->render ( "groupList" );
	}

	public function groupSortAction() {
		$group = new System_Admin_Group ();
		$this->view->assign ( "group", $group );
		
		$this->render ( "groupSort" );
	}

	public function groupSortProcessAction() {
		if ($this->act == "sortable") {
			$groupIdList = $this->_getParam ( "groupId" );
			$sortIndex = 0;
			foreach ( $groupIdList as $groupId ) {
				$groupObject = new System_Admin_Menu ( $groupId );
				$groupObject->SetSort ( $sortIndex );
				$groupObject->Save ();
				$sortIndex ++;
			}
		}
	}

	public function menuListAction() {
		if ($this->act == "edit") {
			$Id = $this->_getParam ( "Id", null );
			$title = ( string ) $this->_getParam ( "title", "" );
			$url = ( string ) $this->_getParam ( "url", "" );
			$parentId = $this->_getParam ( "parentId", null );
			
			$menu = new System_Admin_Menu ( $Id );
			
			$newParent = new System_Admin_Menu ( $parentId );
			$oldParent = $menu->GetParentMenu ();
			
			if (! is_null ( $oldParent )) {
				if ($newParent->GetId () != $oldParent->GetId ()) {
					$menu->SetSort ( 9999 );
				}
			} else {
				$menu->SetSort ( 9999 );
			}
			
			$menu->SetTitle ( $title );
			$menu->SetUrl ( $url );
			$menu->SetParentMenu ( $newParent );
			
			$menu->Save ();
			
			! is_null ( $newParent ) ? $newParent->GetChildren ( true ) : "";
			! is_null ( $oldParent ) ? $oldParent->GetChildren ( true ) : "";
		} elseif ($this->act == "delete") {
			$Id = $this->_getParam ( "Id", null );
			$menu = new System_Admin_Menu ( $Id );
			$oldParent = $menu->GetParentMenu ();
			
			$menu->Destroy ();
			
			! is_null ( $oldParent ) ? $oldParent->GetChildren ( true ) : "";
		}
		
		$group = new System_Admin_Group ();
		$this->view->assign ( "group", $group );
		
		$this->render ( "menuList" );
	}

	public function menuSortAction() {
		$group = new System_Admin_Group ();
		$this->view->assign ( "group", $group );
		
		$this->render ( "menuSort" );
	}

	public function menuSortProcessAction() {
		if ($this->act == "sortable") {
			$groupId = $this->_getParam ( "groupId", "" );
			$menuIdList = $this->_getParam ( "menuId" );
			$sortIndex = 0;
			foreach ( $menuIdList as $menuId ) {
				$menuObject = new System_Admin_Menu ( $menuId );
				$menuObject->SetSort ( $sortIndex );
				$menuObject->Save ();
				$sortIndex ++;
			}
			$groupObject = new System_Admin_Menu ( $groupId );
			$groupObject->GetChildren ( true );
		}
	}

	public function userListAction() {
		$managerConverge = new System_Admin_Converge ();
		
		if ($this->act == "create") {
			$Id = $this->_getParam ( "Id", null );
			$userName = ( string ) $this->_getParam ( "userName", "" );
			$realname = ( string ) $this->_getParam ( "name", "" );
			$teamId = $this->_getParam ( "teamId", "" );
			$weChatToken = $this->_getParam ( "token", "" );
			$branchId = $this->_getParam ( "branchId", "" );
			
			$user = new System_Admin_User ( $Id );
			$user->SetRealName ( $realname );
			$user->SetUserName ( $userName );
			$user->SetTeam ( new System_Admin_Team ( $teamId ) );
			$user->SetPassword ( "123456" );
			$user->SetWeChatToken ( $weChatToken );
			$user->SetBranch ( new System_Admin_Branch ( $branchId ) );
			$user->Save ();
		} elseif ($this->act == "edit") {
			$Id = $this->_getParam ( "Id", null );
			$userName = ( string ) $this->_getParam ( "userName", "" );
			$realname = ( string ) $this->_getParam ( "name", "" );
			$teamId = $this->_getParam ( "teamId", "" );
			$weChatToken = $this->_getParam ( "token", "" );
			$branchId = $this->_getParam ( "branchId", "" );
			
			$user = new System_Admin_User ( $Id );
			
			$newTeam = new System_Admin_Team ( $teamId );
			$oldTeam = $user->GetTeam ();
			
			if (! is_null ( $oldTeam )) {
				if ($newTeam->GetId () != $oldTeam->GetId ()) {
					$user->SetSort ( 9999 );
				}
			} else {
				$user->SetSort ( 9999 );
			}
			
			$user->SetRealName ( $realname );
			$user->SetUserName ( $userName );
			$user->SetTeam ( $newTeam );
			$user->SetBranch ( new System_Admin_Branch ( $branchId ) );
			$user->SetWeChatToken ( $weChatToken );
			$user->Save ();
		} elseif ($this->act == "delete") {
			$Id = $this->_getParam ( "Id", null );
			if ($Id != 1) {
				$user = new System_Admin_User ( $Id );
				$user->SetIsRemove ( true );
				$user->Save ();
			}
		} elseif ($this->act == "reset") {
			$Id = $this->_getParam ( "Id", null );
			if ($Id != 1) {
				$user = new System_Admin_User ( $Id );
				$user->SetPassword ( "123456" );
				$user->Save ();
			}
		}
		
		$this->view->assign ( 'managerConverge', $managerConverge );
		
		$manager = new System_Admin_Manager ();
		$this->view->assign ( "manager", $manager );
		
		$teamList = new System_Admin_Teamlist ();
		$this->view->assign ( "teamList", $teamList->GetItems () );
		
		$branchList = new System_Admin_Branchlist ();
		$this->view->assign ( "branchList", $branchList->GetItems () );
		
		$this->render ( "userList" );
	}

	public function userSortAction() {
		$teamList = new System_Admin_Teamlist ();
		$this->view->assign ( "team", $teamList );
		
		$manager = new System_Admin_Manager ();
		$this->view->assign ( "manager", $manager );
		
		$this->render ( "userSort" );
	}

	public function userSortProcessAction() {
		if ($this->act == "sortable") {
			$userIdList = $this->_getParam ( "userId" );
			$sortIndex = 0;
			foreach ( $userIdList as $userId ) {
				$userObject = new System_Admin_User ( $userId );
				$userObject->SetSort ( $sortIndex );
				$userObject->Save ();
				$sortIndex ++;
			}
		}
	}

	public function userRelationListAction() {
		$userId = $this->_getParam ( "userId", null );
		if ($userId > 0) {
			$user = new System_Admin_User ( $userId );
			$userRelation = new System_Admin_Relation ( $user );
			
			if ($this->act == "edit") {
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
			}
			
			$this->view->assign ( "user", $user );
			$this->view->assign ( "userRelation", $userRelation );
			
			$group = new System_Admin_Group ();
			$this->view->assign ( "group", $group );
			
			$this->render ( "userRelationList" );
		}
	}

	public function optionListAction() {
		if ($this->act == "edit") {
			$title = ( string ) $this->_getParam ( "title", "undefind" );
			$optionId = $this->_getParam ( "Id", null );
			$parentId = $this->_getParam ( "parent", null );
			
			$option = new System_Admin_Option ( $optionId );
			$option->SetParentOption ( new System_Admin_Option ( $parentId ) );
			$option->SetTitle ( $title );
			$option->Save ();
		} else if ($this->act == "delete") {
			$optionId = $this->_getParam ( "Id", null );
			$option = new System_Admin_Option ( $optionId );
			$option->Destroy ();
		}
		
		$optionList = new System_Admin_Optionlist ();
		$this->view->assign ( "tree", $optionList );
		
		$this->render ( "optionList" );
	}

	public function organizeListAction() {
		$converge = new System_Admin_Converge ();
		if ($this->act == "edit") {
			$Id = $this->_getParam ( "organizeId", null );
			$title = ( string ) $this->_getParam ( "title", "" );
			$readOnly = ( boolean ) $this->_getParam ( "readOnly", false );
			$organize = new System_Admin_Organize ( $Id );
			$organize->SetTitle ( $title );
			$organize->Save ();
		} else if ($this->act == "delete") {
			$Id = $this->_getParam ( "organizeId", null );
			$organize = new System_Admin_Organize ( $Id );
			$organize->Destroy ();
		} else if ($this->act == "editPurview") {
			$organizeId = $this->_getParam ( 'organizeId', null );
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
			echo "<script>$(document).ready(function(){ EditPurview('$organizeId'); });</script>";
		}
		$this->view->assign ( "converge", $converge );
		$this->render ( "organizeList" );
	}

	public function organizeUserListAction() {
		$organizeId = $this->_getParam ( 'organizeId', null );
		$organize = new System_Admin_Organize ( $organizeId );
		$organizePurview = new System_Admin_Purview ( $organize );
		
		$this->view->assign ( "usersOrganize", $organizePurview->GetUsers () );
		$this->render ( "organizeUserList" );
	}

	public function organizePurviewListAction() {
		$organizeId = $this->_getParam ( 'organizeId', null );
		$organize = new System_Admin_Organize ( $organizeId );
		$adminPurview = new System_Admin_Purview ( $organize );
		$id = $this->_getParam ( 'Id', null );
		if ($this->act == "edit") {
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
		}
		$this->view->assign ( "organize", $organize );
		$this->view->assign ( "adminPurview", $adminPurview );
		
		$group = new System_Admin_Group ();
		$this->view->assign ( "group", $group );
		$this->render ( "organizePurviewList" );
	}

	public function userRelationListAjaxAction() {
		$userId = $this->_getParam ( 'userId', null );
		$user = new System_Admin_User ( $userId );
		$this->view->assign ( 'person', $user );
		
		$relation = $this->_getParam ( 'relation', array () );
		$this->view->assign ( 'relation', $relation );
		
		$managerConverge = new System_Admin_Converge ();
		$this->view->assign ( 'managerConverge', $managerConverge );
		
		$this->render ( "userRelationListAjax" );
	}

	public function userSetRelationAjaxAction() {
		$comparisonId = $this->_getParam ( 'comparisonId', null );
		$index = $this->_getParam ( 'index', null );
		if (strlen ( $comparisonId ) == 0) {
			$comparison = new System_Admin_Comparison ( null );
			$userId = $this->_getParam ( 'userId', null );
			$user = new System_Admin_User ( $userId );
			$organizeId = $this->_getParam ( 'organizeId', null );
			$organize = new System_Admin_Organize ( $organizeId );
			$comparison->SetUser ( $user );
			$comparison->SetOrganize ( $organize );
			$comparison->Save ();
			$congregation = new System_Admin_Congregation ( $user );
			$result = array ();
		} else {
			$comparison = new System_Admin_Comparison ( $comparisonId );
			$comparison->Destroy ();
			$result = array ();
		}
	}

	public function bugListAction() {
		if ($this->act == "add") {
			$bugInfo = $this->_getParam ( "bugInfo", "" );
			$bugTime = date ( "Y-m-d H:i:s" );
			$bug = new System_Admin_Bug ();
			$bug->SetBugInfo ( $bugInfo );
			$bug->SetBugTime ( $bugTime );
			$bug->SetBugUser ( $this->user );
			$bug->Save ();
		} elseif ($this->act == "delete") {
			$Id = $this->_getParam ( "Id", null );
			$bug = new System_Admin_Bug ( $Id );
			$bug->Destroy ();
		} elseif ($this->act == "update") {
			$Id = $this->_getParam ( "Id", null );
			$overTime = date ( "Y-m-d H:i:s" );
			$bug = new System_Admin_Bug ( $Id );
			$bug->SetOverTime ( $overTime );
			$bug->SetOverCoder ( $this->user );
			$bug->Save ();
		}
		$bugList = new System_Admin_Buglist ();
		$this->view->assign ( "bugList", $bugList );
		
		$this->render ( "bugList" );
	}

	public function instanceAction() {
		$this->view->assign ( "instanceList", System_Admin_InstanceView::GetViewInstance () );
		$userId = $this->_getParam ( "userId", "" );
		$this->view->assign ( "userId", $userId );
		$this->render ( "instance" );
	}

	public function instanceAjaxAction() {
		$role = $this->_getParam ( "role", "" );
		$roleChenked = $this->_getParam ( "roleChenked", 2 );
		$userId = $this->_getParam ( "userId", "" );
		if ($roleChenked == 1) {
			$object = new System_Admin_Instance ();
			$object->SetUser ( new System_Admin_User ( $userId ) );
			$object->SetRole ( $role );
			$object->Save ();
		} elseif ($roleChenked == 0) {
			$roleObject = System_Admin_InstanceView::GetInstanceFromUser ( $userId, $role );
			if (! is_null ( $roleObject )) {
				$roleObject->Destroy ();
			}
		}
	}

	public function branchAction() {
		if ($this->act == "edit") {
			$Id = $this->_getParam ( "Id", "" );
			$title = $this->_getParam ( "title", "" );
			$team = new System_Admin_Branch ( $Id );
			$team->SetTitle ( $title );
			$team->Save ();
		} elseif ($this->act == "delete") {
			$Id = $this->_getParam ( "Id", "" );
			$team = new System_Admin_Branch ( $Id );
			$team->Destroy ();
		}
		$branchList = new System_Admin_Branchlist ();
		$this->view->assign ( "branchList", $branchList->GetItems () );
		$this->render ( "branch" );
	}
}