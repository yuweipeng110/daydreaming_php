<?php
header ( "Content-type:text/html;charset=utf-8" );

class Service_CheckController extends Zend_Controller_Action {

	private $application;

	private $alert;

	private $dom;

	public function init() {
		parent::init ();
		
		$this->_helper->viewRenderer->setNoRender ();
		$this->alert = new Alert ();
		$this->application = new Zend_Session_Namespace ( "application" );
		$this->application->setExpirationSeconds ( 86400 );
		
		$this->dom = XmlData::LoadDecryption ( file_get_contents ( "php://input" ) );
		if (! $this->dom) {
			$message = array (
					"error" => $this->alert->Messsage ( 'PARAMETER_ERROR' ) 
			);
			echo XmlData::ResultEncryption ( $message );
			exit ();
		}
	}

	private function getFirstElementByTagName($tagName) {
		return $this->dom->getElementsByTagName ( $tagName )->item ( 0 )->nodeValue;
	}

	public function connectionAction() {
		$ApplicationInfo = array (
				"SERVICE_NAME" => $_SERVER ['SERVER_NAME'],
				"HTTP_HOST" => $_SERVER ['HTTP_HOST'],
				"REMOTE_ADDR" => $_SERVER ['REMOTE_ADDR'],
				"SERVER_ADDR" => $_SERVER ["SERVER_ADDR"],
				"SOCKET_UDPSENDPORT" => SOCKET_UDPSENDPORT,
				"SOCKET_UDPSERVICEPORT" => SOCKET_UDPSERVICEPORT,
				"SOCKET_TCPSENDPORT" => SOCKET_TCPSENDPORT,
				"SOCKET_TCPSERVICEPORT" => SOCKET_TCPSERVICEPORT 
		);
		
		echo XmlData::ResultEncryption ( $ApplicationInfo );
	}
	
	// -----------------------------------------------------------------------
	public function enumDataAction() {
		$enumData = array ();
		
		$deviceTypeCollection = array ();
		foreach ( Business_Device_List::GetDeviceTypeSubsetList () as $id ) {
			$deviceTypeData = array ();
			$deviceObject = new Business_Device_DeviceType ( $id );
			$deviceTypeData ['Id'] = $deviceObject->GetId ();
			$deviceTypeData ['TypeName'] = $deviceObject->GetTypeName ();
			$deviceTypeCollection [] = $deviceTypeData;
		}
		$enumData ['DeviceTypeList'] = $deviceTypeCollection;
		
		if ($enumData) {
			echo XmlData::ResultEncryption ( $enumData );
		} else {
			$message = array (
					"error" => $this->alert->Messsage ( 'LOAD_NULL' ) 
			);
			echo XmlData::ResultEncryption ( $message );
		}
	}

	public function deviceRegisterAction() {
		$deviceTypeId = $this->getFirstElementByTagName ( 'DEVICE_TYPE_ID' );
		$serialNum = $this->getFirstElementByTagName ( 'SERIAL_NUM' );
		$deviceModel = $this->getFirstElementByTagName ( 'DEVICE_MODEL' );
		$deviceIP = $this->getFirstElementByTagName ( 'DEVICE_IP' );
		$deviceMAC = $this->getFirstElementByTagName ( 'DEVICE_MAC' );
		$devicePlace = $this->getFirstElementByTagName ( 'DEVICE_PLACE' );
		
		$deviceTypeInstance = new Business_Device_DeviceType ( $deviceTypeId );
		
		if ($deviceTypeInstance != null) {
			$deviceInstance = new Business_Device_Base ();
			$result = $deviceInstance->CreateDevice ( $deviceTypeInstance, $serialNum, $deviceModel, $deviceIP, $deviceMAC, $devicePlace );
			
			if ($result) {
				$message = array (
						"deviceId" => $deviceInstance->GetId () 
				);
				echo XmlData::ResultEncryption ( $message );
			} else {
				$message = array (
						"error" => $deviceInstance->GetMessage () 
				);
				echo XmlData::ResultEncryption ( $message );
			}
		} else {
			$message = array (
					"error" => $this->alert->Messsage ( 'LOAD_NULL' ) 
			);
			echo XmlData::ResultEncryption ( $message );
		}
	}
}