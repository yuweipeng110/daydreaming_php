<?php
class Persistent {
	
	/**
	 * 内存缓冲名称
	 *
	 * @var string
	 */
	private $zendCacheId = "";
	
	/**
	 * 获取内存缓冲名称
	 *
	 * @var string
	 */
	private function getZendCachceId() {
		return $this->zendCacheId;
	}
	
	/**
	 * 设置内存缓冲名称
	 *
	 * @var string
	 */
	private function setZendCacheId($zendCacheId) {
		$this->zendCacheId = $zendCacheId;
	}
	
	/**
	 * 文件缓冲名称
	 *
	 * @var string
	 */
	private $zendCacheDir = "";
	
	/**
	 * 获取文件缓冲名称
	 *
	 * @var string
	 */
	private function getZendCacheDir() {
		return $this->zendCacheDir;
	}
	
	/**
	 * 设置文件缓冲名称
	 *
	 * @var string
	 */
	private function setZendCacheDir($zendCacheDir) {
		$this->zendCacheDir = $zendCacheDir;
	}
	
	/**
	 * 数据DATA
	 *
	 * @var array()
	 */
	private $data = array ();
	
	/**
	 * 获取数据
	 */
	public function GetData() {
		return $this->data;
	}
	
	/**
	 * 设置数据
	 *
	 * @param string $data        	
	 */
	private function SetData($data) {
		$this->data = $data;
	}
	
	/**
	 * 添加数据
	 *
	 * @param string $key        	
	 * @param string $value        	
	 * @return Persistent
	 */
	public function AddData($key, $value) {
		$isExists = false;
		foreach ( $this->GetData () as $dataKey => $dataValue ) {
			if ($dataKey == $key && $dataValue == $value) {
				$isExists = true;
			}
		}
		if (! $isExists) {
			$this->data [$key] = $value;
			$this->GetInstance ( true );
		}
		return $value;
	}
	
	/**
	 * 移除数据
	 *
	 * @param string $key        	
	 */
	public function RemoveData($key) {
		$isExists = false;
		foreach ( $this->GetData () as $dataKey => $dataValue ) {
			if ($dataKey == $key) {
				unset ( $this->data [$key] );
				$isExists = true;
			}
		}
		if ($isExists) {
			$this->GetInstance ( true );
		}
	}
	
	/**
	 * 获取GET数据
	 *
	 * @return array
	 */
	public function GetUrlGetData() {
		$getArray = array ();
		foreach ( $this->GetData () as $key => $value ) {
			$getArray [] = $key . "=" . $value;
		}
		return implode ( "&", $getArray );
	}
	
	/**
	 * 获取GET数据
	 *
	 * @param string $key        	
	 * @return string
	 */
	public function GetUrlGetKeyData($key) {
		foreach ( $this->GetData () as $dataKey => $dataValue ) {
			if ($dataKey == $key) {
				return $dataValue;
			}
		}
		return false;
	}
	
	/**
	 * 过期时间
	 *
	 * @var number
	 */
	private $expire = 3600;
	
	/**
	 * 获取过期时间
	 *
	 * @return number
	 */
	private function GetExpire() {
		return $this->expire;
	}
	
	/**
	 * 设置过期时间
	 *
	 * @param number $expire        	
	 */
	private function SetExpire($expire) {
		$this->expire = $expire;
	}
	
	/**
	 * 构造函数
	 *
	 * @param System_Admin_User $user        	
	 * @param Zend_Controller_Action $controller        	
	 * @param number $expire        	
	 */
	public function __construct(System_Admin_User $user, Zend_Controller_Action $controller, $expire = 3600) {
		$userGuid = str_replace ( "-", "_", $user->GetGuid () );
		$controllerName = str_replace ( ".", "_", $controller->getRequest ()->getControllerName () );
		$actionName = str_replace ( ".", "_", $controller->getRequest ()->getActionName () );
		$this->setZendCacheId ( $userGuid . "_" . $controllerName . "_" . $actionName );
		$this->setZendCacheDir ( "/PERSISTENT/" . $userGuid . "/" . $controllerName . "/" . $actionName );
		$this->SetExpire ( $expire );
		$this->SetData ( $this->GetInstance () );
	}
	
	/**
	 * 获取数据
	 *
	 * @param string $refreshCache
	 *        	是否刷新缓存
	 * @return array
	 */
	public function GetInstance($refreshCache = false) {
		$zendcache = new Cache ();
		$zendcache->open ( $this->getZendCacheDir () );
		$cacheData = $zendcache->load ( $this->getZendCachceId () );
		if (! $cacheData || $refreshCache) {
			$data = $this->GetData ();
			$zendcache->save ( $this->getZendCachceId (), $data, $this->GetExpire () );
			$cacheData = $data;
		}
		$zendcache->close ();
		$result = $cacheData;
		return $result;
	}
	
	/**
	 * 清除缓存
	 */
	public function DestroyInstance() {
		$zendcache = new Cache ();
		$zendcache->open ( $this->setZendCacheDir () );
		$zendcache->delete ( $this->getCachceId () );
		$zendcache->close ();
	}
}