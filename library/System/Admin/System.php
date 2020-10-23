<?php

/**
 * 网站系统参数
 * 
 * @author Finder
 *
 */
class System_Admin_System {
	
	/**
	 * 服务器名称
	 */
	public $serverName = null;
	
	/**
	 * 服务器IP地址
	 */
	public $serverAddress = null;
	
	/**
	 * 服务器端口
	 */
	public $serverPort = null;
	
	/**
	 * 服务器运行环境
	 */
	public $serverEnvironment = null;
	
	/**
	 * Session变量
	 */
	public $serverSession = null;
	
	/**
	 * Application变量
	 */
	public $serverApplication = null;
	
	/**
	 * 服务器名称
	 */
	public $serverComputer = null;
	
	/**
	 * 网站实际路径
	 */
	public $serverWebRoot = null;
	
	/**
	 * 服务器系统内核
	 */
	public $serverSysetem = null;
	
	/**
	 * 服务器CPU数量
	 */
	public $serverCPU = null;
	
	/**
	 * 脚本超时
	 */
	public $serverTimeOut = null;
	
	/**
	 * 框架版本
	 */
	public $serverFramework = null;
	
	/**
	 * 网站标题
	 *
	 * @var string
	 */
	private $title = "";

	/**
	 * 获取网站标题
	 *
	 * @return string
	 */
	public function GetTitle() {
		return $this->title;
	}

	/**
	 * 设置网站标题
	 *
	 * @param string $title        	
	 */
	public function SetTitle($title) {
		$this->title = $title;
	}
	
	/**
	 * 网站关键字
	 *
	 * @var string
	 */
	private $keywords = "";

	/**
	 * 获取网站关键字
	 *
	 * @return string
	 */
	public function GetKeywords() {
		return $this->keywords;
	}

	/**
	 * 设置网站关键字
	 *
	 * @param string $keywords        	
	 */
	public function SetKeywords($keywords) {
		$this->keywords = $keywords;
	}
	
	/**
	 * 网站说明
	 *
	 * @var string
	 */
	private $description = "";

	/**
	 * 获取网站说明
	 *
	 * @return string
	 */
	public function GetDescription() {
		return $this->description;
	}

	/**
	 * 设置网站说明
	 *
	 * @param string $description        	
	 */
	public function SetDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * 网站备案信息
	 *
	 * @var string
	 */
	private $icp = "";

	/**
	 * 获取网站备案信息
	 *
	 * @return string
	 */
	public function GetIcp() {
		return $this->icp;
	}

	/**
	 * 设置网站备案信息
	 *
	 * @param string $icp        	
	 */
	public function SetIcp($icp) {
		$this->icp = $icp;
	}
	
	/**
	 * 缓存对象
	 *
	 * @var Zend_Cache
	 */
	private $cache = null;

	/**
	 * 网站系统参数
	 */
	public function __construct() {
		$cacheDir = CACHEDIR . "/ADMIN/SYSTEM";
		$dir = $cacheDir;
		if (! file_exists ( $dir )) {
			mkdir ( $dir, 0777, true );
		}
		$frontendOptions = array (
				'lifeTime' => CACHELIFETIME,
				'automatic_serialization' => false 
		);
		$backendOptions = array (
				'cache_dir' => $cacheDir 
		);
		$this->cache = Zend_Cache::factory ( 'Core', 'File', $frontendOptions, $backendOptions );
		
		$this->serverName = array (
				'服务器名称',
				$_SERVER ['SERVER_NAME'] 
		);
		$this->serverAddress = array (
				'服务器IP地址',
				$_SERVER ['SERVER_ADDR'] 
		);
		$this->serverPort = array (
				'服务器端口',
				$_SERVER ['SERVER_PORT'] 
		);
		$this->serverEnvironment = array (
				'服务器运行环境',
				$_SERVER ['SERVER_SOFTWARE'] 
		);
		$this->serverSession = array (
				'Session变量',
				$_COOKIE ['PHPSESSID'] 
		);
		$this->serverComputer = array (
				'服务器名称',
				$_ENV ['COMPUTERNAME'] 
		);
		$this->serverWebRoot = array (
				'网站实际路径',
				$_SERVER ['DOCUMENT_ROOT'] 
		);
		$this->serverSysetem = array (
				'服务器系统内核',
				$_ENV ['OS'] 
		);
		$this->serverCPU = array (
				'服务器CPU数量',
				$_ENV ['NUMBER_OF_PROCESSORS'] 
		);
		$this->serverTimeOut = array (
				'地址',
				$_SERVER ['SERVER_NAME'] 
		);
		$this->serverFramework = array (
				'框架版本',
				"Zend Framework " . Zend_Version::VERSION 
		);
		
		$data = $this->GetInstance ();
		if ($data != null) {
			$this->SetTitle ( $data ['systemTitle'] );
			$this->SetKeywords ( $data ['systemKeywords'] );
			$this->SetDescription ( $data ['systemDescription'] );
			$this->SetIcp ( $data ['systemIcp'] );
		}
	}

	/**
	 * 从缓存获取对象数据
	 *
	 * @param boolean $refreshCache        	
	 */
	private function GetInstance($refreshCache = false) {
		$cacheId = "SYSTEM_INFORMATION";
		$result = $this->cache->load ( $cacheId );
		if (! $result || $refreshCache) {
			$row ['systemTitle'] = $this->GetTitle ();
			$row ['systemKeywords'] = $this->GetKeywords ();
			$row ['systemDescription'] = $this->GetDescription ();
			$row ['systemIcp'] = $this->GetIcp ();
			$jsonData = Zend_Json::encode ( $row );
			$this->cache->save ( $jsonData, $cacheId );
			$result = $jsonData;
		}
		$data = Zend_Json::decode ( $result );
		return $data;
	}

	public function Save() {
		$this->GetInstance ( true );
	}
}