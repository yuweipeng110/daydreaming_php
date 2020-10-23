<?php
class Data_Index implements Interface_IIndex {
	
	/**
	 * 缓存对象
	 *
	 * @var Zend_Cache
	 */
	protected $cache = null;
	
	/**
	 * 表操作对象
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $table;
	
	/**
	 * 适配器对象
	 *
	 * @var Zend_Db_Adapter_Abstract
	 */
	protected $db;
	
	/**
	 * 数据表名称
	 *
	 * @var string
	 */
	private $tableName = "DATA_INDEX";
	
	/**
	 * 获取数据表名称
	 *
	 * @return string
	 */
	protected function getTableName() {
		return $this->tableName;
	}
	
	/**
	 * 设置数据表名称
	 *
	 * @param string $tableName        	
	 */
	protected function setTableName($tableName) {
		$this->tableName = $tableName;
	}
	
	/**
	 * 索引字段名
	 *
	 * @var string
	 */
	private $columnName = "DATA_COLUNM";
	
	/**
	 * 获取索引字段名
	 *
	 * @return string
	 */
	protected function getColumnName() {
		return $this->columnName;
	}
	
	/**
	 * 设置索引字段名
	 *
	 * @param string $columnName        	
	 */
	protected function setColumnName($columnName) {
		$this->columnName = $columnName;
	}
	
	/**
	 * 内存缓冲名称
	 *
	 * @var string
	 */
	private $memcacheId = "DATA_INDEX";
	
	/**
	 * 获取内存缓冲名称
	 *
	 * @return string
	 */
	protected function getMemcacheId() {
		return $this->memcacheId;
	}
	
	/**
	 * 设置内存缓冲名称
	 *
	 * @param string $memcacheId        	
	 */
	protected function setMemcacheId($memcacheId) {
		$this->memcacheId = $memcacheId;
	}
	
	/**
	 * 文件缓冲名称
	 *
	 * @var string
	 */
	private $zendCacheId = "DATA_INDEX";
	
	/**
	 * 获取文件缓冲名称
	 *
	 * @return string
	 */
	protected function getZendCacheId() {
		return $this->zendCacheId;
	}
	
	/**
	 * 设置文件缓冲名称
	 *
	 * @param string $zendCacheId        	
	 */
	protected function setZendCacheId($zendCacheId) {
		$this->zendCacheId = $zendCacheId;
	}
	
	/**
	 * 文件缓冲地址
	 *
	 * @var string
	 */
	private $zendCacheDir = "/DATA/INDEX";
	
	/**
	 * 获取文件缓冲地址
	 *
	 * @return string
	 */
	protected function getZendCacheDir() {
		return $this->zendCacheDir;
	}
	
	/**
	 * 设置文件缓冲地址
	 *
	 * @param string $zendCacheDir        	
	 */
	protected function setZendCacheDir($zendCacheDir) {
		$this->zendCacheDir = $zendCacheDir;
	}
	
	/**
	 * 缓存方式
	 *
	 * @var string
	 */
	private $cacheType = 1;
	
	/**
	 * 获取缓存方式
	 *
	 * @return string
	 */
	protected function getCacheType() {
		return $this->cacheType;
	}
	
	/**
	 * 设置缓存方式
	 *
	 * @param number $cacheFlag
	 *        	(0:No Cache,1:Zend Cache,2:Memory Cache,3:Zend Cache & Memory Cache)
	 */
	protected function setCacheType($cacheType) {
		$this->cacheType = $cacheType;
	}
	
	/**
	 * 对象索引
	 *
	 * @var string
	 */
	private $index = null;
	
	/**
	 * 获取对象索引(non-PHPdoc)
	 *
	 * @see Object_IData::GetIndex()
	 */
	public function GetIndex() {
		return $this->index;
	}
	
	/**
	 * 设置对象索引
	 *
	 * @param string $index        	
	 */
	protected function SetIndex($index) {
		$this->index = $index;
	}
	
	/**
	 * 对象Id
	 *
	 * @var string
	 */
	private $Id = null;
	
	/**
	 * 获取对象索引(non-PHPdoc)
	 *
	 * @see Object_IData::GetObject()
	 */
	public function GetId() {
		return $this->Id;
	}
	
	/**
	 * 设置对象索引
	 *
	 * @param number $Id        	
	 */
	protected function SetId($Id) {
		$this->Id = $Id;
	}
	
	/**
	 * 对象构造函数
	 *
	 * @param string $index        	
	 */
	public function __construct($tableName = null, $columnName = null, $index = null) {
		if (strlen ( $tableName ) == 0) {
			$tableName = null;
			$this->SetId ( 0 );
			return;
		}
		if (strlen ( $columnName ) == 0) {
			$columnName = null;
			$this->SetId ( 0 );
			return;
		}
		if (strlen ( $index ) == 0) {
			$index = null;
			$this->SetId ( 0 );
			return;
		}
		
		$this->SetIndex ( $index );
		$this->setTableName ( $tableName );
		$this->setColumnName ( $columnName );
		
		$this->setMemcacheId ( $this->getColumnName () );
		$this->setZendCacheId ( $this->getColumnName () );
		
		$group1 = is_null ( $this->GetIndex () ) ? '' : "/" . substr ( strtoupper ( md5 ( $this->GetIndex () ) ), 0, 1 );
		$group2 = is_null ( $this->GetIndex () ) ? '' : "/" . substr ( strtoupper ( md5 ( $this->GetIndex () ) ), 1, 1 );
		$group3 = is_null ( $this->GetIndex () ) ? '' : "/" . substr ( strtoupper ( md5 ( $this->GetIndex () ) ), 2, 1 );
		
		$this->setZendCacheDir ( "/INDEX/" . $this->getColumnName () . $group1 . "" . $group2 . "" . $group3 );
		$this->setCacheType ( 3 );
		
		$this->table = new Custom_Adapter ();
		$this->db = $this->table->getAdapter ();
		$data = $this->GetInstance ( false );
		if ($data != null) {
			$this->SetId ( $data ['Id'] );
		} else {
			$this->SetId ( 0 );
		}
	}
	
	/**
	 * 初始化缓存
	 *
	 * @return multitype:string
	 */
	private function initCache() {
		return list ( $memoryId, $cacheId ) = array (
				$this->getMemcacheId () . "_" . strtoupper ( md5 ( $this->GetIndex () ) ),
				$this->getZendCacheId () . "_" . strtoupper ( md5 ( $this->GetIndex () ) ) 
		);
	}
	
	/**
	 * 获取数据库中的实例
	 *
	 * @return Ambigous <NULL, multitype:, array>
	 */
	protected function GetInstanceFromDataBase() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' ' . $this->getColumnName () . ' = ? ', $this->GetIndex () );
		$row = $this->table->fetchRow ( $where );
		$result = is_null ( $row ) ? null : $row->toArray ();
		
		return $result;
	}
	
	/**
	 * 获取数据
	 *
	 * @param string $refreshCache
	 *        	是否刷新缓存
	 * @return array
	 */
	protected function GetInstance($refreshCache = false) {
		if (strlen ( $this->GetIndex () ) == null)
			return null;
		list ( $memoryId, $cacheId ) = $this->initCache ();
		$result = array ();
		if ($this->getCacheType () == 0) {
			$result = $this->GetInstanceFromDataBase ();
		} elseif ($this->getCacheType () == 1) {
			$zendcache = new Cache ();
			$zendcache->open ( $this->getZendCacheDir () );
			$cacheData = $zendcache->load ( $cacheId );
			if (! $cacheData || $refreshCache) {
				$data = $this->GetInstanceFromDataBase ();
				if (is_null ( $data )) {
					return null;
				}
				$zendcache->save ( $cacheId, $data );
				$cacheData = $data;
			}
			$zendcache->close ();
			$result = $cacheData;
		} elseif ($this->getCacheType () == 2) {
			$memcache = new Mem ();
			$memcache->open ();
			$memoryData = $memcache->load ( $memoryId );
			if (! $memoryData || $refreshCache) {
				$data = $this->GetInstanceFromDataBase ();
				if (is_null ( $data )) {
					return null;
				}
				$memcache->save ( $memoryId, $data );
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
					$data = $this->GetInstanceFromDataBase ();
					if (is_null ( $data )) {
						return null;
					}
					$zendcache->save ( $cacheId, $data );
					$cacheData = $data;
				}
				$zendcache->close ();
				$memcache->save ( $memoryId, $cacheData );
				$memoryData = $cacheData;
			}
			$result = $memoryData;
			$memcache->close ();
		}
		return $result;
	}
	
	/**
	 * 清除缓存
	 */
	protected function DestroyInstance() {
		if ( $this->GetId () > 0)
			return null;
		list ( $memoryId, $cacheId ) = $this->initCache ();
		if ($this->getCacheType () == 0) {
		} elseif ($this->getCacheType () == 1) {
			$zendcache = new Cache ();
			$zendcache->open ( $this->getZendCacheDir () );
			$zendcache->delete ( $cacheId );
			$zendcache->close ();
		} elseif ($this->getCacheType () == 2) {
			$memcache = new Mem ();
			$memcache->open ();
			$memcache->delete ( $memoryId );
			$memcache->close ();
		} elseif ($this->getCacheType () == 3) {
			$memcache = new Mem ();
			$memcache->open ();
			$memcache->delete ( $memoryId );
			$memcache->close ();
			
			$zendcache = new Cache ();
			$zendcache->open ( $this->getZendCacheDir () );
			$zendcache->delete ( $cacheId );
			$zendcache->close ();
		}
	}
	
	/**
	 * 保存
	 *
	 * @see Interface_IData::Save()
	 */
	public function Save() {
		$this->GetInstance ( true );
	}
	
	/**
	 * 删除
	 *
	 * @see Interface_IData::Destroy()
	 */
	public function Destroy() {
		$this->DestroyInstance ();
	}
}
	