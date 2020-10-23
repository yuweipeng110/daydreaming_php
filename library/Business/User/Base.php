<?php

class Business_User_Base extends Object_User_Base {

	/**
	 * 添加系统用户
	 *
	 * @param string $userName        	
	 * @param string $password        	
	 * @return System_Admin_User
	 */
	protected function addSystemUser($userName, $password) {
		$systemUser = new System_Admin_User ();
		$systemUser->SetUserName ( $userName );
		$systemUser->SetPassword ( $password );
		$systemUser->Save ();
		
		return $systemUser;
	}

	/**
	 * 添加系统导航 admin使用
	 *
	 * @param string $title        	
	 * @param string $url        	
	 * @param number $parentId        	
	 * @return boolean
	 */
	protected function addSystemMenu($title, $url, $parentId = 0) {
		if ($this->GetId() > 0 && $this->GetSystemUser ()->GetId () == 1) {
			// $systemUser = $this->GetSystemUser ();
			$menu = new System_Admin_Menu ();
			$newParent = new System_Admin_Menu ( $parentId );
			$menu->SetParentMenu ( $newParent );
			$menu->SetTitle ( $title );
			$menu->SetUrl ( $url );
			$menu->Save ();
			
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 更新系统导航 admin使用
	 *
	 * @param number $menuId        	
	 * @param string $title        	
	 * @param string $url        	
	 * @param number $parentId        	
	 * @return boolean
	 */
	protected function editSystemMenu($menuId, $title, $url, $parentId = 0) {
		if ($this->GetId() > 0 && $this->GetSystemUser ()->GetId () == 1) {
			$menu = new System_Admin_Menu ( $menuId );
			$newParent = new System_Admin_Menu ( $parentId );
			$menu->SetParentMenu ( $newParent );
			$menu->SetTitle ( $title );
			$menu->SetUrl ( $url );
			$menu->Save ();
			
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 获取系统导航
	 *
	 * @return array
	 */
	protected function getSystemMenuList() {
		$selfMenu = array ();
		$user = $this->GetSystemUser ();
		if ($this->GetId () > 0 && $user != null) {
			$groupCongregation = new System_Admin_Congregation ( $user );
			foreach ( $groupCongregation->GetItems () as $valueCongregation ) {
				$groupRelation = new System_Admin_Purview ( $valueCongregation->GetOrganize () );
				foreach ( $groupRelation->GetMenus () as $valueMenu ) {
					$selfMenu [] = Business_Tool_Func::getMenuField ( $valueMenu, $valueMenu->GetChildren () );
					// $selfMenu [] = $valueMenu->GetId ();
				}
			}
			
			$userRelation = new System_Admin_Relation ( $user );
			foreach ( $userRelation->GetMenus () as $valueMenu ) {
				$selfMenu [] = Business_Tool_Func::getMenuField ( $valueMenu, $valueMenu->GetChildren () );
			}
		}
		return $selfMenu;
	}
}