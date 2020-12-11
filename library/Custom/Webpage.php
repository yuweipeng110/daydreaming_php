<?php

class Custom_Webpage extends Zend_Controller_Action {
	protected $json = "";
	protected $param = null;
	protected $data = array ();

	/**
	 * 初始化(non-PHPdoc)
	 *
	 * @see Zend_Controller_Action::init()
	 */
	public function init(){
		parent::init ();
		$this->json = JsonData::LoadNotDecrypt ( file_get_contents ( "php://input" ) );
		$this->params = $this->getAllParams ();
		if ($this->json) {
			$this->data = Zend_Json::decode ( $this->json );
			// SESSION OK
		}
	}
}