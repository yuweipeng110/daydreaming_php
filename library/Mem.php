<?php
class Mem {
	private $memcache = null;
	
	/**
	 * 实例化高速缓存对象
	 */
	public function __construct() {
		$this->memcache = new Memcache ();
	}
	
	/**
	 * 打开高速缓存
	 */
	public function open($ipAddress = MEMCACHE_IPADDRESS, $port = MEMCACHE_PORT) {
		$this->memcache->connect ( $ipAddress, $port );
	}
	
	/**
	 * 获取高速缓存数据
	 *
	 * @param string $key        	
	 * @return mixed
	 */
	public function load($key) {
		$jsonData = $this->memcache->get ( $key );
		if ($jsonData) {
			return Zend_Json::decode ( $jsonData );
		} else {
			return false;
		}
	}
	
	/**
	 * 设置高速缓存数据
	 *
	 * @param string $key        	
	 * @param mixed $data        	
	 * @param number $expire        	
	 */
	public function save($key, $data, $expire = 0) {
		$jsonData = Zend_Json::encode ( $data );
		$this->memcache->set ( $key, $jsonData, false, $expire );
	}
	
	/**
	 * 清除高速缓存
	 *
	 * @param string $key        	
	 */
	public function delete($key) {
		$this->memcache->delete ( $key );
	}
	
	/**
	 * 关闭高速缓存
	 */
	public function close() {
		$this->memcache->close ();
	}
}