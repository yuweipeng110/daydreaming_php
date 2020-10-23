<?php
class Alert {
	private $dom;
	public function __construct() {
		$languagePath = MYWEBROOT_PATH . "/data/Message.xml";
// 		$xmlArray = simplexml_load_file ( MYWEBROOT_PATH . "/data/Message.xml" );
// 		$xml = $xmlArray->asXML ();
		$xmlString = file_get_contents ( $languagePath );
		$this->dom = new DOMDocument ();
		$this->dom->loadXML ( $xmlString );
	}
	public function Messsage($messageId) {
		$nodeList = $this->dom->getElementsByTagName ( "string" );
		foreach ( $nodeList as $key => $value ) {
			if ($value->getAttribute ( 'id' ) == $messageId) {
				return $value->nodeValue;
			}
		}
	}
}