<?php
header ( "Content-type:text/html;charset=utf-8" );
date_default_timezone_set ( 'PRC' );
error_reporting ( 1 );
ini_set ( 'display_errors', 1 );
ini_set ( 'default_charset', 'utf-8' );

putenv ( 'NLS_LANG=AMERICAN_AMERICA.UTF8' );

define ( 'SOCKET_IPADDRESS', '192.168.2.240' );

define ( 'MYSERVER_IPADDRESS', '116.112.3.102' );
define ( 'PROJECT', 'A' );	
define ( 'CACHELIFETIME', null );

define ( 'MYWEBROOT_PATH', dirname ( __FILE__ ) );
define ( 'MEMCACHE_IPADDRESS', '127.0.0.1' );
define ( 'MEMCACHE_PORT', '11211' );
define ( 'HOSTNAME', 'http://116.112.3.102:9999/' );

defined ( 'CACHEDIR' ) || define ( 'CACHEDIR', realpath ( dirname ( __FILE__ ) . '/../cache' ) );
defined ( 'CSVDIR' ) || define ( 'CSVDIR', realpath ( dirname ( __FILE__ ) . '/../csvs' ) );
defined ( 'LOGDIR' ) || define ( 'LOGDIR', realpath ( dirname ( __FILE__ ) . '/../log' ) );
defined ( 'DOCSDIR' ) || define ( 'DOCSDIR', realpath ( dirname ( __FILE__ ) . '/../docs' ) );
defined ( 'IMGDIR' ) || define ( 'IMGDIR', realpath ( dirname ( __FILE__ ) . '/../img' ) );
defined ( 'TMPDIR' ) || define ( 'DOCSDIR', realpath ( dirname ( __FILE__ ) . '/../tmp' ) );
defined ( 'XMLDIR' ) || define ( 'XMLDIR', realpath ( dirname ( __FILE__ ) . '/../xml' ) );
defined ( 'APPLICATION_PATH' ) || define ( 'APPLICATION_PATH', realpath ( dirname ( __FILE__ ) . '/../application' ) );
defined ( 'APPLICATION_ENV' ) || define ( 'APPLICATION_ENV', (getenv ( 'APPLICATION_ENV' ) ? getenv ( 'APPLICATION_ENV' ) : 'cli') );
set_include_path ( implode ( PATH_SEPARATOR, array (
		realpath ( APPLICATION_PATH . '/../library' ),
		get_include_path () 
) ) );

/**
 * Zend_Loader
 */
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance ();
$loader->setFallbackAutoloader ( true );
$loader->suppressNotFoundWarnings ( false );

/**
 * Zend_Application
 */
require_once 'Zend/Application.php';
$application = new Zend_Application ( APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini' );
$application->bootstrap ()->run ();