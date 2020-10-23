<?php
class Cache {
	private $zendCache = null;
	private $cachePath = null;
	private $frontendOptions = array (
			'lifeTime' => null,
			'automatic_serialization' => false 
	);
	private $backendOptions = array (
			'cache_dir' => null 
	);
	
	/**
	 * 实例化文件缓存对象
	 */
	public function __construct() {
	}
	
	/**
	 * 打开文件缓存
	 *
	 * @param string $cacheDir
	 *        	缓存地址
	 */
	public function open($cacheDir) {
		$this->cachePath = CACHEDIR . $cacheDir;
		$dir = $this->cachePath;
		if (! file_exists ( $dir )) {
			mkdir ( $dir, 0777, true );
		}
		$this->backendOptions ['cache_dir'] = $this->cachePath;
	}
	
	/**
	 * 获取文件缓存数据
	 *
	 * @param string $key        	
	 * @return mixed
	 */
	public function load($key) {
		$this->frontendOptions ['lifeTime'] = CACHELIFETIME;
		$this->zendCache = Zend_Cache::factory ( 'Core', 'File', $this->frontendOptions, $this->backendOptions );
		
		$jsonData = $this->zendCache->load ( $key );
		if ($jsonData) {
			return Zend_Json::decode ( $jsonData );
		} else {
			return false;
		}
	}
	
	/**
	 * 设置文件缓存数据
	 *
	 * @param string $key        	
	 * @param mixed $data        	
	 * @param number $expire        	
	 */
	public function save($key, $data, $expire = null) {
		$this->frontendOptions ['lifeTime'] = $expire;
		$this->zendCache = Zend_Cache::factory ( 'Core', 'File', $this->frontendOptions, $this->backendOptions );
		
		$jsonData = Zend_Json::encode ( $data );
		$this->zendCache->save ( $jsonData, $key );
	}
	
	/**
	 * 清除文件缓存
	 *
	 * @param string $key        	
	 */
	public function delete($key) {
		$this->frontendOptions ['lifeTime'] = null;
		$this->zendCache = Zend_Cache::factory ( 'Core', 'File', $this->frontendOptions, $this->backendOptions );
		
		$this->zendCache->remove ( $key );
	}
	
	/**
	 * 关闭文件缓存
	 */
	public function close() {
	}
}