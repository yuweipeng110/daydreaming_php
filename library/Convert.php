<?php
class Convert {
	private static $DXSZ = "零壹贰叁肆伍陆柒捌玖";
	private static $DXDW = "毫厘分角元拾佰仟万拾佰仟亿拾佰仟万兆拾佰仟万亿京拾佰仟万亿兆垓";
	private static $SCDW = "元拾佰仟万亿京兆垓";
	private static function ConvertIntToUpper($capValue) {
		// 当前金额
		$currCap = '';
		
		// 结果金额
		$capResult = '';
		
		// 当前单位
		$currentUnit = '';
		
		// 结果单位
		$resultUnit = '';
		
		// 上一位的值
		$prevChar = - 1;
		
		// 当前位的值
		$currChar = 0;
		
		// 位置索引，从'元'开始
		$posIndex = 4;
		
		if ($capValue == 0) {
			return '';
		}
		
		for($i = strlen ( $capValue ) - 1; $i >= 0; $i --) {
			$currChar = substr ( $capValue, $i, 1 );
			if ($posIndex > 30) {
				// 已超出最大精度'垓'。注：可以将30改成22，使之精确到兆亿就足够了
				break;
			} else if ($currChar != 0) {
				// 当前位为非零值，则直接转换成大写金额
				$currCap = mb_substr ( Convert::$DXSZ, $currChar, 1, 'utf-8' ) . mb_substr ( Convert::$DXDW, $posIndex, 1, 'utf-8' );
			} else {
				// 防止转换后出现多余的零,例如：3000020
				switch ($posIndex) {
					case 4 :
						$currCap = '元';
						break;
					case 8 :
						$currCap = '万';
						break;
					case 12 :
						$currCap = '亿';
						break;
					case 17 :
						$currCap = '兆';
						break;
					case 23 :
						$currCap = '京';
						break;
					case 30 :
						$currCap = '垓';
						break;
					default :
						break;
				}
				if ($prevChar != 0) {
					if ($currCap != '') {
						if ($currCap != '元')
							$currCap .= '零';
					} else {
						$currCap = '零';
					}
				}
			}
			
			// die ( var_dump ( $posIndex ) );
			
			// 对结果进行容错处理
			if (strlen ( $capResult ) > 0) {
				$resultUnit = mb_substr ( $capResult, 0, 1, 'utf-8' );
				$currentUnit = mb_substr ( Convert::$DXDW, $posIndex, 1, 'utf-8' );
				if (strpos ( Convert::$SCDW, $resultUnit ) > 0) {
					if (strpos ( Convert::$SCDW, $currentUnit ) > strpos ( Convert::$SCDW, $resultUnit )) {
						$capResult = mb_substr ( $capResult, 1, null, 'utf-8' );
					}
				}
			}
			$capResult = $currCap . $capResult;
			$prevChar = $currChar;
			$posIndex += 1;
			$currCap = '';
		}
		return $capResult;
	}
	private static function ConvertDecToUpper($capValue, $addZero) {
		$currCap = '';
		$capResult = '';
		$prevChar = $addZero ? - 1 : 0;
		$currChar = 0;
		$posIndex = 3;
		
		if ($capValue == 0) {
			return '';
		}
		for($i = 0; $i < strlen ( $capValue ); $i ++) {
			$currChar = substr ( $capValue, $i, 1 );
			if ($currChar != 0) {
				$currCap = mb_substr ( Convert::$DXSZ, $currChar, 1, 'utf-8' ) . mb_substr ( Convert::$DXDW, $posIndex, 1, 'utf-8' );
			} else {
				if (substr ( $capValue, $i ) == 0) {
					break;
				} else if ($prevChar != 0) {
					$currCap = '零';
				}
			}
			$capResult .= $currCap;
			$prevChar = $currChar;
			$posIndex -= 1;
			$currCap = '';
		}
		return $capResult;
	}
	
	/**
	 * 小写金额转大写
	 *
	 * @param 小写金额 $value        	
	 * @return 大写金额 string
	 */
	public static function RmbToUpper($value) {
		$capResult = '';
		
		// 格式化
		$capValue = sprintf ( '%.2f', $value );
		
		// 小数点位置
		$dotPos = strpos ( $capValue, '.' );
		
		// 是否在结果中加'整'
		$addInt = (substr ( $capValue, $dotPos + 1 ) == 0);
		
		if (substr ( $capValue, $dotPos + 1 ) == 0) {
			$addInt = true;
		} elseif (substr ( $capValue, $dotPos + 2 ) == 0) {
			$addInt = true;
		} else {
			$addInt = false;
		}
		
		// 是否在结果中加'负'
		$addMinus = (substr ( $capValue, 0, 1 ) == '-');
		
		// 开始位置,null
		$beginPos = $addMinus ? 1 : 0;
		
		// 整数
		$capInt = substr ( $capValue, $beginPos, $dotPos - $beginPos );
		
		// 小数
		$capDec = substr ( $capValue, $dotPos + 1 );
		
		if ($dotPos > 0) {
			$capResult = Convert::ConvertIntToUpper ( $capInt ) . Convert::ConvertDecToUpper ( $capDec, $capInt != 0 ? true : false );
		} else {
			$capResult = Convert::ConvertIntToUpper ( $capDec );
		}
		if ($addMinus)
			$capResult = '负' . $capResult;
		if ($addInt)
			$capResult .= '整';
		return $capResult;
	}
	
	/**
	 * 金额大写转小写
	 *
	 * @param 大写金额 $value        	
	 * @return 小写金额 string
	 */
	public static function RmbToLower($value) {
		$vResult = 0;
		$vNumber = 0; // 当前数字
		$vTemp = 0;
		
		$addMinus = (mb_substr ( $value, 0, 1, 'utf-8' ) == "负");
		
		for($j = 0; $j < strlen ( $value ) / 3; $j ++) {
			$i = strpos ( Convert::$DXSZ, mb_substr ( $value, $j, 1, 'utf-8' ) ) / 3;
			
			if ($i > 0) {
				$vNumber = $i;
			} else {
				$i = strpos ( Convert::$SCDW, mb_substr ( $value, $j, 1, 'utf-8' ) ) / 3;
				if ($i == 5)
					$i = 8;
				if ($i == 6)
					$i = 12;
				if ($i > 0) {
					if ($i >= 4) {
						$vTemp += $vNumber;
						if ($vTemp == 0) {
							$vTemp = 1;
						}
						$vResult += $vTemp * pow ( 10, $i );
						$vTemp = 0;
					} else {
						$vTemp += $vNumber * pow ( 10, $i );
					}
				} else {
					$i = strpos ( "元角分厘", mb_substr ( $value, $j, 1, 'utf-8' ) ) / 3;
					if ($i > 0) {
						$vTemp += $vNumber;
						$vResult += $vTemp * pow ( 10, - $i );
						$vTemp = 0;
					} else if ($i == 0) {
						$vTemp += $vNumber;
						$vResult += $vTemp;
						$vTemp = 0;
					}
				}
				$vNumber = 0;
			}
		}
		
		return sprintf ( '%.2f', $addMinus ? ($vResult + $vTemp + $vNumber) * - 1 : ($vResult + $vTemp + $vNumber) );
	}
}