<?php
/**
 * 功能信息
 * 
 * @author Finder
 */
class System_Admin_Menu extends Data_Object {
	/**
	 * 上级选项
	 *
	 * @var System_Admin_Menu
	 */
	private $parent = null;

	/**
	 * 获取上级选项
	 *
	 * @return System_Admin_Menu
	 */
	public function GetParentMenu() {
		return $this->parent;
	}

	/**
	 * 设置上级选项
	 *
	 * @return System_Admin_Menu $part
	 */
	public function SetParentMenu(System_Admin_Menu $parent) {
		$this->parent = $parent;
	}
	/**
	 * 选项名称
	 *
	 * @var string
	 */
	private $title = "";

	/**
	 * 获取选项名称
	 *
	 * @return string
	 */
	public function GetTitle() {
		return $this->title;
	}

	/**
	 * 设置选项名称
	 *
	 * @param string $title        	
	 */
	public function SetTitle($title) {
		$this->title = $title;
	}
	/**
	 * 功能URL地址
	 *
	 * @var string
	 */
	private $url = "";

	/**
	 * 获取功能URL地址
	 *
	 * @return stirng
	 */
	public function GetUrl() {
		return $this->url;
	}

	/**
	 * 设置功能URL地址
	 *
	 * @param string $url        	
	 */
	public function SetUrl($url) {
		$this->url = $url;
	}
	/**
	 * 排序参数
	 *
	 * @var int
	 */
	private $sort = 9999;

	/**
	 * 获取排序参数
	 *
	 * @return int
	 */
	public function GetSort() {
		return $this->sort;
	}

	/**
	 * 设置排序参数
	 *
	 * @param int $sort        	
	 */
	public function SetSort($sort) {
		$this->sort = $sort;
	}
	/**
	 * 选项是否使用中
	 *
	 * @var boolean
	 */
	private $beUsed = false;

	/**
	 * 获取选项是否使用
	 *
	 * @return boolean
	 */
	public function GetBeUsed() {
		if (count ( $this->GetChildren () ) > 0) {
			$this->beUsed = true;
		} else {
			$this->beUsed = false;
		}
		return $this->beUsed;
	}
	/**
	 * 子级选项列表
	 *
	 * @var array
	 */
	private $children = array ();

	/**
	 * 获取子级选项列表
	 *
	 * @return multitype:System_Admin_Menu
	 */
	public function GetChildren($refreshCache = false) {
		$this->children = $this->GetChildrenMenus ( $refreshCache );
		return $this->children;
	}

	/**
	 * 添加选项到子级
	 *
	 * @param System_Admin_Option $option        	
	 */
	public function AppendChild(System_Admin_Option $option) {
		if (! in_array ( $option, $this->children )) {
			$option->SetParent ( $this );
			$option->Save ();
			$this->GetChildrenMenus ( true );
		}
	}

	/**
	 * 从子级移除某个选项
	 *
	 * @param System_Admin_Option $option        	
	 */
	public function RemoveChild(System_Admin_Option $option) {
		if (in_array ( $option, $this->children )) {
			$option->Destroy ();
			$this->GetChildrenMenus ( true );
		}
	}

	/**
	 * 选项信息
	 *
	 * @param number $id        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_001" );
		$this->setMemcacheId ( PROJECT . "_ADMIN_MENU" );
		$this->setZendCacheId ( PROJECT . "_ADMIN_MENU" );
		$this->setZendCacheDir ( "/ADMIN/MENU" );
		$this->setCacheType ( 3 );
		parent::__construct ( $id );
		try {
			$data = $this->GetInstance ( false );
			$this->SetObjectProperty ( $data );
			$this->isValueChanged = false;
		} catch ( Exception $ex ) {
			$data = $this->GetInstance ( true );
			$this->SetObjectProperty ( $data );
			$this->isValueChanged = false;
		}
	}

	/**
	 * 设定对象相关属性
	 */
	private function SetObjectProperty($data) {
		if ($data != null) {
			$this->SetId ( $data ['ID'] );
			$this->SetParentMenu ( new System_Admin_Menu ( $data ['F1_A001'] ) );
			$this->title = $data ['F2_A001'];
			$this->SetUrl ( $data ['F3_A001'] );
			$this->SetSort ( $data ['F4_A001'] );
			$this->SetOtime ( $data ['OTIME'] );
		} else {
			$this->SetId ( 0 );
		}
	}

	/**
	 * 保存
	 *
	 * @see Data_Object::Save()
	 */
	public function Save() {
		$data = array (
				'F1_A001' => is_null ( $this->GetParentMenu () ) ? "" : $this->GetParentMenu ()->GetId (),
				'F2_A001' => $this->title,
				'F3_A001' => $this->GetUrl (),
				'F4_A001' => $this->GetSort () 
		);
		$this->SafeParam ( $data );
		$this->table->setTable ( $this->getTableName () );
		if ($this->GetId () > 0) {
			$where = $this->db->quoteInto ( ' ID= ? ', $this->GetId () );
			$this->table->update ( $data, $where );
		} else {
			$data ['OTIME'] = date ( 'Y-m-d H:i:s' );
			$this->SetId ( $this->table->insert ( $data ) );
		}
		is_null ( $this->GetParentMenu () ) ? null : $this->GetParentMenu ()->GetChildren ( true );
		parent::Save ();
	}

	/**
	 * 删除
	 *
	 * @see Data_Object::Destroy()
	 */
	public function Destroy() {
		if ($this->GetBeUsed ()) {
			return;
		}
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' ID= ? ', $this->GetId () );
		$this->table->delete ( $where );
		is_null ( $this->GetParentMenu () ) ? null : $this->GetParentMenu ()->GetChildren ( true );
		parent::Destroy ();
	}

	/**
	 * 获取controller
	 *
	 * @return string
	 */
	public function GetControllerName() {
		if ($this->url != "") {
			$urlArray = explode ( "/", $this->GetUrl () );
			$controllerName = explode ( ".", $urlArray [1] );
			return $controllerName [0];
		}
	}

	/**
	 * 获取action
	 *
	 * @return array
	 */
	public function GetActionName() {
		if ($this->url != "") {
			$urlArray = explode ( "/", $this->GetUrl () );
			$actionArray = explode ( ".", $urlArray [2] );
			return $actionArray [0];
		}
	}

	/**
	 * 获取子项列表
	 *
	 * @return Ambigous <multitype:, multitype:mixed Ambigous <string, boolean, mixed> >
	 */
	private function GetItemsFromDataBase() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A001= ? ', $this->GetId () );
		$order = array (
				"F4_A001 ASC",
				"OTIME ASC" 
		);
		$result = $this->table->fetchAll ( $where, $order );
		return $result;
	}

	/**
	 * 初始化缓存
	 *
	 * @return multitype:string
	 */
	private function initChildrenCache() {
		return list ( $memoryId, $cacheId ) = array (
				$this->getMemcacheId () . "_" . $this->GetId () . "_CHILDREN",
				$this->getZendCacheId () . "_" . $this->GetId () . "_CHILDREN" 
		);
	}

	/**
	 * 从缓存获取子级信息
	 *
	 * @param boolean $refreshCache        	
	 */
	private function GetChildrenMenus($refreshCache = false) {
		if ($this->GetId () == 0)
			return null;
		list ( $memoryId, $cacheId ) = $this->initChildrenCache ();
		$result = array ();
		if ($this->getCacheType () == 0) {
			$result = $this->GetItemsFromDataBase ();
		} elseif ($this->getCacheType () == 1) {
			$zendcache = new Cache ();
			$zendcache->open ( $this->getZendCacheDir () );
			$cacheData = $zendcache->load ( $cacheId );
			if (! $cacheData || $refreshCache) {
				$data = $this->GetItemsFromDataBase ();
				$zendcache->save ( $cacheId, $data, null );
				$cacheData = $data;
			}
			$zendcache->close ();
			$result = $cacheData;
		} elseif ($this->getCacheType () == 2) {
			$memcache = new Mem ();
			$memcache->open ();
			$memoryData = $memcache->load ( $memoryId );
			if (! $memoryData || $refreshCache) {
				$data = $this->GetItemsFromDataBase ();
				$memcache->save ( $memoryId, $data, 0 );
				$memoryData = $data;
			}
			$memcache->close ();
			$result = $memoryData;
		} elseif ($this->getCacheType () == 3) {
			$memcache = new Mem ();
			$memcache->open ();
			$memoryData = $memcache->load ( $memoryId );
			if (! $memoryData || $refreshCache) {
				$zendcache = new Cache ();
				$zendcache->open ( $this->getZendCacheDir () );
				$cacheData = $zendcache->load ( $cacheId );
				if (! $cacheData || $refreshCache) {
					$data = $this->GetItemsFromDataBase ();
					$zendcache->save ( $cacheId, $data, null );
					$cacheData = $data;
				}
				$zendcache->close ();
				$memcache->save ( $memoryId, $cacheData, 0 );
				$memoryData = $cacheData;
			}
			$result = $memoryData;
			$memcache->close ();
		}
		$objectList = null;
		if ($result != null) {
			foreach ( $result as $key => $value ) {
				$objectList [] = new System_Admin_Menu ( $value ['ID'] );
			}
		} else {
			$objectList = null;
		}
		return $objectList;
	}
}