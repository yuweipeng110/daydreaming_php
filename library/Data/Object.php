<?php

class Data_Object implements Interface_IData {

	/**
	 * 状态码
	 *
	 * @var number
	 */
	private $code = 0;

	/**
	 * 获取状态码
	 *
	 * @return number
	 */
	public function GetCode() {
		return $this->code;
	}

	/**
	 * 设置状态码
	 *
	 * @param number $code        	
	 */
	public function SetCode($code) {
		$this->code = (int) $code;
	}

	/**
	 * 说明
	 *
	 * @var string
	 */
	private $message = "";

	/**
	 * 获取说明
	 *
	 * @return string
	 */
	public function GetMessage() {
		return $this->message;
	}

	/**
	 * 设置说明
	 *
	 * @param string $message        	
	 */
	public function SetMessage($message) {
		$this->message = $message;
	}

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
	private $tableName = "DATA_OBJECT";

	/**
	 * 获取数据表名称
	 *
	 * @return string
	 */
	protected function getTableName() {
		return $this->tableName;
	}

	/**
	 * 设置数据表明成
	 *
	 * @param string $tableName        	
	 */
	protected function setTableName($tableName) {
		$this->tableName = $tableName;
	}

	/**
	 * 内存缓冲名称
	 *
	 * @var string
	 */
	private $memcacheId = "DATA_OBJECT";

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
	private $zendCacheId = "DATA_OBJECT";

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
	private $zendCacheDir = "/DATA/OBJECT";

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
	 * 对象ID
	 *
	 * @var number
	 */
	private $id = 0;

	/**
	 * 获取对象ID(non-PHPdoc)
	 *
	 * @see Interface_IData::GetId()
	 */
	public function GetId() {
		return (int) $this->id;
	}

	/**
	 * 设置对象ID
	 *
	 * @param number $id        	
	 */
	public function SetId($id) {
		$this->id = $id;
	}

	/**
	 * 入库时间
	 *
	 * @var datetime
	 */
	private $otime = "0";

	/**
	 * 获取入库时间
	 *
	 * @see Interface_IData::GetOtime()
	 */
	public function GetOtime() {
		return $this->otime;
	}

	/**
	 * 设置入库时间
	 *
	 * @param datetime $otime        	
	 */
	public function SetOtime($otime) {
		$this->otime = $otime;
	}

	/**
	 * 对象构造函数
	 *
	 * @param string $id        	
	 */
	public function __construct($id = 0) {
		// if (strlen ( $guid ) != 36) {
		// $guid = null;
		// }
		
		// $group1 = is_null ( $guid ) ? '' : "/" . substr ( $guid, 0, 1 );
		// $group2 = is_null ( $guid ) ? '' : "/" . substr ( $guid, 1, 1 );
		// $group3 = is_null ( $guid ) ? '' : "/" . substr ( $guid, 2, 1 );
		// $this->setZendCacheDir ( $this->getZendCacheDir () . $group1 . "" . $group2 . "" . $group3 );
		
		// $this->SetGuid ( $guid );
		$this->setZendCacheDir ( $this->getZendCacheDir () );
		
		$this->SetId ( $id );
		
		$this->table = new Custom_Adapter ();
		$this->db = $this->table->getAdapter ();
	}

	/**
	 * 防注入
	 *
	 * @param unknown $data        	
	 */
	protected function SafeParam(&$data) {
		$data = str_replace ( "'", "''", $data );
	}

	/**
	 * 初始化缓存
	 *
	 * @return multitype:string
	 */
	private function initCache() {
		return list ( $memoryId, $cacheId ) = array (
				$this->getMemcacheId () . "_" . $this->GetId (),
				$this->getZendCacheId () . "_" . $this->GetId () 
		);
	}

	protected function BuildDataBaseTable($tableStruct) {
	}

	/**
	 * 获取数据库中的实例
	 *
	 * @return Ambigous <NULL, multitype:, array>
	 */
	protected function GetInstanceFromDataBase() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' ID = ? ', $this->GetId () );
		$row = $this->table->fetchRow ( $where );
		$result = is_null ( $row ) ? null : $row->toArray ();
		// foreach ( $result as $key => $value ) {
		// if (is_resource ( $value )) {
		// var_dump ( get_resource_type ( $value ) );
		// var_dump ( stream_get_meta_data ( $value ) );
		// }
		// }
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
		if ($this->GetId () == 0)
			return null;
		list ( $memoryId, $cacheId ) = $this->initCache ();
		$result = array ();
		if ($this->getCacheType () == 0) {
			$result = $this->GetInstanceFromDataBase ();
			// echo "OBEJCT FROM DATABASE SOURCE";
			// echo "<br/>";
		} elseif ($this->getCacheType () == 1) {
			$zendcache = new Cache ();
			$zendcache->open ( $this->getZendCacheDir () );
			$cacheData = $zendcache->load ( $cacheId );
			if (! $cacheData || $refreshCache) {
				$data = $this->GetInstanceFromDataBase ();
				$zendcache->save ( $cacheId, $data, null );
				$cacheData = $data;
				// echo "OBEJCT FROM DATABASE SOURCE";
				// echo "<br/>";
			}
			$zendcache->close ();
			$result = $cacheData;
		} elseif ($this->getCacheType () == 2) {
			$memcache = new Mem ();
			$memcache->open ();
			$memoryData = $memcache->load ( $memoryId );
			if (! $memoryData || $refreshCache) {
				$data = $this->GetInstanceFromDataBase ();
				$memcache->save ( $memoryId, $data, 0 );
				$memoryData = $data;
				// echo "OBEJCT FROM DATABASE SOURCE";
				// echo "<br/>";
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
					$zendcache->save ( $cacheId, $data, null );
					$cacheData = $data;
					// echo "OBEJCT FROM DATABASE SOURCE";
					// echo "<br/>";
				}
				$zendcache->close ();
				$memcache->save ( $memoryId, $cacheData, 0 );
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
		if ($this->GetId () == 0)
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
		$indexing = new Data_Index ( $this->getTableName (), "ID", $this->GetId () );
		$indexing->Destroy ();
		
		$this->DestroyInstance ();
	}
}
	