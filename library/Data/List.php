<?php
class Data_List {
	
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
	 * 初始化缓存
	 *
	 * @return multitype:string
	 */
	protected function initCache() {
	}
	
	/**
	 * 初始化数据适配器
	 */
	protected function initAdapter() {
		$this->table = new Custom_Adapter ();
		$this->db = $this->table->getAdapter ();
	}
}