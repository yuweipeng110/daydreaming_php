<?php
header ( "Content-type:text/html;charset=utf-8" );

class ServiceController extends Zend_Controller_Action {

	public function init() {
		$sapi_type = php_sapi_name ();
		if ($sapi_type == "cli") {
			$this->_helper->viewRenderer->setNoRender ();
		} else {
			echo "Welcome to system services, use the command line to run the relevant procedures.\n";
			die ();
		}
	}

	public function swooleTestAction() {
		file_put_contents ( "/home/xy/daydreaming/log/swoole-test.log", file_get_contents ( "php://input" ) . "\n", FILE_APPEND );
		// nohup sudo -u www-data php /home/wwwroot/hospital_yu/public/service.php socket.udp.holepunch > /home/wwwroot/hospital_yu/log/udp.log 2>&1 &
		// 创建Server对象，监听 127.0.0.1:9502端口，类型为SWOOLE_SOCK_UDP
		$serv = new swoole_server ( "127.0.0.1", 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP );
		// $serv = new swoole_server("127.0.0.1", 9502, SWOOLE_PREOESS, SWOOLE_SOCK_IDP);
		// 监听数据接收事件
		$serv->on ( 'Packet', function ($serv, $data, $clientInfo) {
			$serv->sendto ( $clientInfo ['address'], $clientInfo ['port'], "Server " . $data );
			var_dump ( $clientInfo );
		} ); 
		
		// 启动服务器
		$serv->start ();
	}

	/**
	 * complete
	 */
	public function socketUdpHolepunchAction() {
		// nohup sudo -u www-data php /home/wwwroot/hospital_yu/public/service.php socket.udp.holepunch > /home/wwwroot/hospital_yu/log/udp.log 2>&1 &
		$sapi_type = php_sapi_name ();
		if ($sapi_type == "cli") {
			echo "Socket Service Running... on " . SOCKET_IPADDRESS . ":" . SOCKET_UDPSERVICEPORT . " " . date ( 'Y-m-d H:i:s' ) . "\n";
			$socket = socket_create ( AF_INET, SOCK_DGRAM, SOL_UDP ) or die ( "Unable to create Socket\n" );
			socket_bind ( $socket, SOCKET_IPADDRESS, SOCKET_UDPSERVICEPORT ) or die ( "Unable to bind Socket\n" );
			$clientIp = "0.0.0.0";
			$clientPort = "0";
			
			ob_flush ();
			flush ();
			
			$i = 1;
			$isError = false;
			while ( ! $isError ) {
				try {
					socket_recvfrom ( $socket, $content, 1024, 0, $clientIp, $clientPort );
					if ($content == "") {
					} else if ($content == "*#0324#") {
						$buf = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
						$buf .= "<root>\n";
						$buf .= "	<I>" . Format::FormatStreamEncrypt ( $clientIp ) . "</I>\n";
						$buf .= "	<P>" . Format::FormatStreamEncrypt ( $clientPort ) . "</P>\n";
						$buf .= "	<II>" . $clientIp . "</II>\n";
						$buf .= "	<PP>" . $clientPort . "</PP>\n";
						$buf .= "</root>\n";
						if (socket_sendto ( $socket, $buf, strlen ( $buf ), 0, $clientIp, $clientPort ) === false) {
							$error_message = $content . "====" . "$clientIp : $clientPort : " . date ( "Y-m-d H:i:s" ) . " : UDP NAT ADDRESS CONFIRM ERROR : $i : " . socket_strerror ( socket_last_error () ) . "\n";
							echo $error_message;
						}
						$success_message = $content . "====" . "$clientIp : $clientPort : " . date ( "Y-m-d H:i:s" ) . " : UDP NAT ADDRESS CONFIRM SUCCESS\n";
						echo $success_message;
					} else {
						$error_message = $content . "====" . "$clientIp : $clientPort : " . date ( "Y-m-d H:i:s" ) . " : SOCKET SERVICE ERROR\n";
						echo $error_message;
					}
				} catch ( Exception $e ) {
					$isError = true;
					$error_message = "$clientIp : $clientPort : " . date ( "Y-m-d H:i:s" ) . " : SOCKET SERVICE ERROR : $e\n";
					echo $e->getMessage () . "|" . $e->getCode () . "|" . $e->getFile () . "|" . $e->getLine () . "\n";
				}
				$i ++;
				
				ob_flush ();
				flush ();
			}
			socket_close ( $socket );
			$socket = null;
			$this->_helper->redirector ( "socketUdpHolepunch", "service" );
			
			if ($isError) {
				$this->_helper->redirector ( "socketUdpHolepunch", "service" );
			}
		} else {
			echo "You are not using CLI PHP\n";
		}
	}
}