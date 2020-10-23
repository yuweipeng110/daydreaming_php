<?php
class Data_Factory implements Interface_IFactory {
	
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
	protected function SetCode($code) {
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
	protected function SetMessage($message) {
		$this->message = $message;
	}

	public function GetInstance() {
	}
}