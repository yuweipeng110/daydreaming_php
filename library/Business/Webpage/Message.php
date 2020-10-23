<?php

class Business_Webpage_Message {

	/**
	 * 200 成功
	 *
	 * @var number
	 */
	const SUCCESS = 10200;

	/**
	 * 400 参数错误
	 *
	 * @var number
	 */
	const PARAMETER_ERROR = 10400;

	/**
	 * 401 没有权限
	 *
	 * @var number
	 */
	const PERMISSIONS_ERROR = 10401;

	/**
	 * 502 服务端逻辑错误
	 *
	 * @var number
	 */
	const LOGIC_ERROR = 10502;

	/**
	 * 505 验证失败
	 *
	 * @var number
	 */
	const CHECK_ERROR = 10505;

	public static function getMessage($resultCode) {
		$resultMessage = '';
		switch ($resultCode) {
			case self::SUCCESS :
				$resultMessage = '成功';
				break;
			case self::PARAMETER_ERROR :
				$resultMessage = '失败，参数错误 ';
				break;
			case self::PERMISSIONS_ERROR :
				$resultMessage = '失败，没有权限 ';
				break;
			case self::LOGIC_ERROR :
				$resultMessage = '失败，服务端逻辑错误';
				break;
			case self::CHECK_ERROR :
				$resultMessage = '失败，验证失败';
				break;
		}
		return $resultMessage;
	}
}