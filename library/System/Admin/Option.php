<?php

/**
 * 选项信息
 * 
 * @author Finder
 */
class System_Admin_Option extends Data_Object {
	
	/**
	 * 上级选项
	 *
	 * @var System_Admin_Option
	 */
	private $parent = null;

	/**
	 * 获取上级选项
	 *
	 * @return System_Admin_Option
	 */
	public function GetParentOption() {
		return $this->parent;
	}

	/**
	 * 设置上级选项
	 *
	 * @return System_Admin_Option $parent
	 */
	public function SetParentOption(System_Admin_Option $parent) {
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
	 * @return multitype:System_Admin_Option
	 */
	public function GetChildren($refreshCache = false) {
		$this->children = $this->GetChildrenOptions ( $refreshCache );
		return $this->children;
	}

	/**
	 * 添加选项到子级
	 *
	 * @param System_Admin_Option $option        	
	 */
	public function AppendChild(System_Admin_Option $option) {
		$option->SetParentOption ( $this );
		$option->Save ();
		$this->GetChildrenOptions ( true );
	}

	/**
	 * 从子级移除某个选项
	 *
	 * @param System_Admin_Option $option        	
	 */
	public function RemoveChild(System_Admin_Option $option) {
		$option->Destroy ();
		$this->GetChildrenOptions ( true );
	}

	/**
	 * 选项信息
	 *
	 * @param number $id        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_002" );
		$this->setMemcacheId ( PROJECT . "_ADMIN_OPTION" );
		$this->setZendCacheId ( PROJECT . "_ADMIN_OPTION" );
		$this->setZendCacheDir ( "/ADMIN/OPTION" );
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
			$this->SetParentOption ( new System_Admin_Option ( $data ['F1_A002'] ) );
			$this->title = $data ['F2_A002'];
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
				'F1_A002' => is_null ( $this->GetParentOption () ) ? "" : $this->GetParentOption ()->GetId (),
				'F2_A002' => $this->title 
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
		is_null ( $this->GetParentOption () ) ? null : $this->GetParentOption ()->GetChildren ( true );
		
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
		
		is_null ( $this->GetParentOption () ) ? null : $this->GetParentOption ()->GetChildren ( true );
		
		parent::Destroy ();
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
	 * 获取子项列表
	 *
	 * @return Ambigous <multitype:, multitype:mixed Ambigous <string, boolean, mixed> >
	 */
	private function GetItemsFromDataBase() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F1_A002= ? ', $this->GetId () );
		$result = $this->table->fetchAll ( $where );
		
		return $result;
	}

	/**
	 * 从缓存获取子级信息
	 *
	 * @param boolean $refreshCache        	
	 */
	private function GetChildrenOptions($refreshCache = false) {
		if (strlen ( $this->GetId () ) == null)
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
				$objectList [] = new System_Admin_Option ( $value ['ID'] );
			}
		} else {
			$objectList = null;
		}
		return $objectList;
	}
}