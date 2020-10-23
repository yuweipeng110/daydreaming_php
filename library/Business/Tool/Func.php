<?php
class Business_Tool_Func{

	/**
	 * 获取导航字段
	 *
	 * @param System_Admin_Menu $menu
	 * @param array $children
	 * @return array
	 */
	public static function getMenuField(System_Admin_Menu $menu, $children = array()) {
		$data = array ();
		$valueData = array ();
		$valueData ['id'] = $menu->GetId ();
		$valueData ['title'] = $menu->GetTitle ();
		$valueData ['url'] = $menu->GetUrl ();
		$valueData ['parentId'] = $menu->GetParentMenu () == null ? 0 : $menu->GetParentMenu ()->GetId ();
		$valueData ['children'] = array ();
		$data [$menu->GetId ()] = $valueData;
		foreach ( $children as $valueMenu ) {
			$valueData ['children'] [] = $this->GetMenuField ( $valueMenu );
			$data [$menu->GetId ()] = $valueData;
		}
	
		return $data;
	}
}