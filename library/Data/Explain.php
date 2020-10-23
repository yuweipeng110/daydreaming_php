<?php
class Data_Explain {
	
	/**
	 * code
	 *
	 * @var number
	 */
	private $code = 0;

	/**
	 * 获取code
	 *
	 * @return number
	 */
	public function GetCode() {
		return $this->code;
	}

	/**
	 * 设置code
	 *
	 * @param number $code        	
	 */
	public function SetCode($code) {
		$this->code = $code;
	}
	
	/**
	 * 说明
	 *
	 * @var string
	 */
	private $message = '';

	/**
	 * 获取说明
	 *
	 * @return string
	 */
	public function GetMessage() {
		return $this->message;
	}

	/**
	 * 设置说明
	 *
	 * @param string $message        	
	 */
	public function SetMessage($message) {
		$this->message = $message;
	}
	
	private $data = array();
	
	public function GetData(){
		return $this->data;
	}
	
	public function SetData($data){
		$this->data = $data;
	}
}