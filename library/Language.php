<?php
class Language {
	private $branchGuid;
	private $cacheKey;
	private $dom;
	public function __construct() {
		$this->cacheKey = "language";
		$languageDir = LANGUAGEDIR . "/zh-CN/admin" ;
		$languageFile = "Language.xml";
		$languagePath = $languageDir . "/" . $languageFile;
		if (! file_exists ( $languagePath )) {
			mkdir ( $languageDir, 0777, true );
			$this->createXml ( $languagePath );
		}
		$xmlString = file_get_contents ( $languagePath );
		$this->dom = new DOMDocument ();
		$this->dom->loadXML ( $xmlString );
	}
	public function Message($messageName) {
		$nodeList = $this->dom->getElementsByTagName ( "string" );
		foreach ( $nodeList as $key => $value ) {
			if ($value->getAttribute ( 'id' ) == $messageName) {
				return $value->nodeValue;
			}
		}
	}
	private function createXml($filename) {
		$string = "<?xml version='1.0' encoding='utf-8'?><root></root>";
		$dom = new DOMDocument ();
		$dom->loadXML ( $string );
		$dom->save ( $filename );
	}
}