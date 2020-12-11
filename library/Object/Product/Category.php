<?php

/**
 * 产品类别表
 * @author xy
 *
 */
class Object_Product_Category extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 名称
	 *
	 * @var string
	 */
	private $title = '';

	/**
	 * 获取名称
	 *
	 * @return string
	 */
	public function GetTitle() {
		return $this->title;
	}

	/**
	 * 设置名称
	 *
	 * @param string $title        	
	 */
	public function SetTitle($title) {
		if ($this->title != $title) {
			$this->title = $title;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 上级选项
	 *
	 * @var Object_Product_Category
	 */
	private $parent = null;

	/**
	 * 获取上级选项
	 *
	 * @return Object_Product_Category
	 */
	public function GetParent() {
		$parent = new Object_Product_Category ( $this->parent );
		if ($parent->GetId () > 0) {
			return $parent;
		} else {
			return null;
		}
	}

	/**
	 * 设置上级选项
	 *
	 * @param Object_Product_Category $parent        	
	 */
	public function SetParent(Object_Product_Category $parent) {
		if ($this->parent != $parent->GetId ()) {
			$this->parent = $parent->GetId ();
			$this->isValueChanged = true;
		}
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
	 * @return multitype:
	 */
	public function GetChildren($refreshCache = false) {
		$this->children = $this->GetChildrenOptions ( true );
		return $this->children;
	}

	/**
	 * 添加子级选项列表
	 *
	 * @param Object_Product_Category $child        	
	 */
	public function AppendChild(Object_Product_Category $child) {
		$this->SetParent ( $child );
		$this->Save ();
		$this->GetChildrenOptions ( true );
	}

	/**
	 * 从子级移除某个选项
	 *
	 * @param Object_Product_Category $child        	
	 */
	public function RemoveChild(Object_Product_Category $child) {
		$child->Destroy ();
		$this->GetChildrenOptions ( true );
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_402" );
		$this->setMemcacheId ( PROJECT . "_402" );
		$this->setZendCacheId ( PROJECT . "_402" );
		$this->setZendCacheDir ( "/A4/402" );
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
			$this->SetTitle ( $data ['F1_A402'] );
			$this->parent = $data ['F2_A402'];
			$this->SetOtime ( $data ['OTIME'] );
		} else {
			$this->SetId ( 0 );
		}
		$this->isValueChanged = false;
	}

	/**
	 * 保存
	 *
	 * @see Interface_IData::Save()
	 */
	public function Save() {
		if (! $this->isValueChanged)
			return;
		$data = array (
				'F1_A402' => $this->GetTitle (),
				'F2_A402' => $this->parent 
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
		parent::Save ();
		$this->isValueChanged = false;
	}

	/**
	 * 删除
	 *
	 * @see Data_Object::Destroy()
	 */
	public function Destroy() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' ID= ? ', $this->GetId () );
		$this->table->delete ( $where );
		parent::Destroy ();
	}

	/**
	 * 初始化缓存
	 *
	 * @return multitype:string
	 */
	private function initChildrenCache() {
		return list ( $memoryId, $cacheId ) = array (
				$this->getMemcacheId () . "_" . str_replace ( "-", "_", $this->GetId () ) . "_CHILDREN",
				$this->getZendCacheId () . "_" . str_replace ( "-", "_", $this->GetId () ) . "_CHILDREN" 
		);
	}

	/**
	 * 获取子项列表
	 *
	 * @return Ambigous <multitype:, multitype:mixed Ambigous <string, boolean, mixed> >
	 */
	private function GetItemsFromDataBase() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' F2_A402= ? ', $this->GetId () );
		$result = $this->table->fetchAll ( $where );
		
		return $result;
	}

	/**
	 * 从缓存获取子级信息
	 *
	 * @param boolean $refreshCache        	
	 */
	private function GetChildrenOptions($refreshCache = false) {
		if ($this->GetId () == 0) {
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
					$objectList [] = new Object_Product_Category ( $value ['ID'] );
				}
			} else {
				$objectList = null;
			}
			return $objectList;
		}
	}
}