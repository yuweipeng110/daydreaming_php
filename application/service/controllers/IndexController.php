<?php
header ( "Content-type:text/html;charset=utf-8" );

class Service_IndexController extends Zend_Controller_Action {

	private $application;

	private $alert;

	private $dom;

	/**
	 * 设备对象
	 *
	 * @var Business_Device_Base
	 */
	private $device;
	
	


	public function init() {
		parent::init ();
		$this->_helper->viewRenderer->setNoRender ();
		
		$this->dom = XmlData::LoadDecryption ( file_get_contents ( "php://input" ) );
		$this->alert = new Alert ();
		if (! $this->dom) {
			$message = array (
					"error" => $this->alert->Messsage ( 'PARAMETER_ERROR' ) 
			);
			echo XmlData::ResultEncryption ( $message );
			exit ();
		}
		
		// $serviceId = ( int ) ($this->getFirstElementByTagName ( 'SERVICE_ID' ));
		// $deviceId = $serviceId;
		// $this->device = new Business_Device_Base ( $deviceId );
		// file_put_contents ( "/home/wwwroot/hospital_xy/log/index.log", $this->device->GetId() . date("Y-m-d H:i:s") . "\n", FILE_APPEND );
		// file_put_contents ( "/home/wwwroot/hospital_xy/log/init.log", "data", FILE_APPEND );
		
		$this->application = new Zend_Session_Namespace ( "application" );
		if (isset ( $this->application->serviceBaseInfo )) {
			$sessionId = $this->getFirstElementByTagName ( 'SERVICE_SESSIONID' );
			if ($this->application->serviceBaseInfo ['SERVICE_SESSIONID'] == $sessionId) {
				$deviceId = ( int ) ($this->application->serviceBaseInfo ['SERVICE_ID']);
				$this->device = new Business_Device_Base ( $deviceId );
				$controllerName = $this->getRequest ()->getControllerName ();
				$actionName = $this->getRequest ()->getActionName ();
				$url = $controllerName . "/" . $actionName;
				file_put_contents ( "/home/wwwroot/hospital_xy/log/index.log", $this->device->GetId () . $url . date ( "Y-m-d H:i:s" ) . "\n", FILE_APPEND );
			} else {
				$message = array (
						"error" => $this->alert->Messsage ( 'PARAMETER_ERROR' ) 
				);
				echo XmlData::ResultEncryption ( $message );
				exit ();
			}
		} else {
			$message = array (
					"error" => $this->alert->Messsage ( 'PARAMETER_ERROR' ) 
			);
			echo XmlData::ResultEncryption ( $message );
			exit ();
		}
	}

	private function getFirstElementByTagName($tagName) {
		if ($this->dom->getElementsByTagName ( $tagName )->length > 0) {
			return $this->dom->getElementsByTagName ( $tagName )->item ( 0 )->nodeValue;
		} else {
			return null;
		}
	}
	
	// -----------------------------------------------------------------------
	public function indexAction() {
	}
	
	// -----------------------------------------------------------------------
	public function stayOnlineAction() {
		$status = $this->getFirstElementByTagName ( 'SERVICE_STATUS' );
		$this->device->SetOnline ( $status, strtotime ( date ( "Y-m-d H:i:s" ) ) );
		file_put_contents ( "/home/wwwroot/hospital_xy/log/stayOnlineAction.log", "xxxxx====" . $this->device->GetId () ."=====". $status . date ( "Y-m-d H:i:s" ) . "\n", FILE_APPEND );
		
		$message = array (
				"success" => $this->alert->Messsage ( 'LOAD_SUCCESS' ) 
		);
		echo XmlData::ResultEncryption ( $message );
	}
	
	// -----------------------------------------------------------------------
	public function networkStructureCheckAction() {
		$this->device->notification->CheckServiceHolePunchMessage ( $this->device->GetId () );
		file_put_contents ( "/home/wwwroot/hospital_xy/log/networkStructureCheckAction.log", "xxxxx====" . $this->device->GetId () . date ( "Y-m-d H:i:s" ) . "\n", FILE_APPEND );
		
		$message = array (
				"success" => $this->alert->Messsage ( 'LOAD_SUCCESS' ) 
		);
		echo XmlData::ResultEncryption ( $message );
	}

	public function holePunchCheckAction() {
		$this->device->notification->CheckServiceRelayServerMessage ( $this->device->GetId () );
		file_put_contents ( "/home/wwwroot/hospital_xy/log/holePunchCheckAction.log", "aaaaa====" . $this->device->GetId () . date ( "Y-m-d H:i:s" ) . "\n", FILE_APPEND );
		
		$message = array (
				"success" => $this->alert->Messsage ( 'LOAD_SUCCESS' ) 
		);
		echo XmlData::ResultEncryption ( $message );
	}
	
	// -----------------------------------------------------------------------
	public function setSocketServicePortAction() {
		$localIpEndPointDom = $this->dom->getElementsByTagName ( 'SERVICE_LOCALIPENDPOINT' )->item ( 0 )->childNodes;
		$localIpEndPointArray = array ();
		foreach ( $localIpEndPointDom as $ipEndPointNode ) {
			if ($ipEndPointNode->nodeName == 'LIST') {
				$localIpEndPointArray [] = $ipEndPointNode->getElementsByTagName ( 'IP' )->item ( 0 )->nodeValue . ":" . $ipEndPointNode->getElementsByTagName ( 'PORT' )->item ( 0 )->nodeValue;
			}
		}
		$this->device->SetUserLocalIpEndpoint ( implode ( ",", $localIpEndPointArray ) );
		
		$natIpEndPointDom = $this->dom->getElementsByTagName ( 'SERVICE_NATIPENDPOINT' )->item ( 0 )->childNodes;
		$natIpEndPointArray = array ();
		foreach ( $natIpEndPointDom as $ipEndPointNode ) {
			if ($ipEndPointNode->nodeName == 'LIST') {
				$natIpEndPointArray [] = $ipEndPointNode->getElementsByTagName ( 'IP' )->item ( 0 )->nodeValue . ":" . $ipEndPointNode->getElementsByTagName ( 'PORT' )->item ( 0 )->nodeValue;
			}
		}
		$this->device->SetUserNatIpEndpoint ( implode ( ",", $natIpEndPointArray ) );
		
		$this->device->Save ();
		
		file_put_contents ( "/home/wwwroot/hospital_xy/log/setSocketServicePortAction.log", implode ( ",", $localIpEndPointArray ) . "\n", FILE_APPEND );
		$message = array (
				"success" => $this->alert->Messsage ( 'LOAD_SUCCESS' ) 
		);
		echo XmlData::ResultEncryption ( $message );
	}
	
	// -----------------------------------------------------------------------
	public function setDeviceClientCloseAction() {
		if ($this->device->SaveDeviceStatus ( 4 )) {
			
			$message = array (
					"success" => $this->alert->Messsage ( 'LOAD_SUCCESS' ) 
			);
			echo XmlData::ResultEncryption ( $message );
		} else {
			$message = array (
					"error" => $this->alert->Messsage ( 'LOAD_NULL' ) 
			);
			echo XmlData::ResultEncryption ( $message );
		}
	}
}