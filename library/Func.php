<?php

class Func {

	/**
	 * 毫秒时间戳
	 *
	 * @return number
	 */
	public static function GetMillisecond($date = null) {
		$microtime = microtime ();
		if (! is_null ( $date )) {
			$microtime = strtotime ( date ( 'Y-m-d H:i:s', strtotime ( $date ) ) );
		}
		list ( $t1, $t2 ) = explode ( ' ', $microtime );
		return ( float ) sprintf ( '%.0f', (floatval ( $t1 ) + floatval ( $t2 )) * 1000 );
	}

	/**
	 * 获取IP地址
	 */
	public static function GetIp() {
		if (getenv ( 'HTTP_CLIENT_IP' )) {
			$IP = getenv ( 'HTTP_CLIENT_IP' );
		} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
			$IP = getenv ( 'HTTP_X_FORWARDED_FOR' );
		} elseif (getenv ( 'HTTP_X_FORWARDED' )) {
			$IP = getenv ( 'HTTP_X_FORWARDED' );
		} elseif (getenv ( 'HTTP_FORWARDED_FOR' )) {
			$IP = getenv ( 'HTTP_FORWARDED_FOR' );
		} elseif (getenv ( 'HTTP_FORWARDED' )) {
			$IP = getenv ( 'HTTP_FORWARDED' );
		} else {
			$IP = $_SERVER ['REMOTE_ADDR'];
		}
		return $IP;
	}

	/**
	 * 截取字符串
	 *
	 * @param 被截取字符串 $string
	 * @param 截取长度 $sublen
	 * @param 起始位置 $start
	 * @param 编码格式 $code
	 * @return string
	 */
	public static function CutString($string, $sublen, $start = 0, $code = 'UTF-8') {
		if ($code == 'UTF-8') {
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all ( $pa, $string, $t_string );
			if (count ( $t_string [0] ) - $start > $sublen)
				return join ( '', array_slice ( $t_string [0], $start, $sublen ) ) . "...";
			return join ( '', array_slice ( $t_string [0], $start, $sublen ) );
		} else {
			$start = $start * 2;
			$sublen = $sublen * 2;
			$strlen = strlen ( $string );
			$tmpstr = '';
			for($i = 0; $i < $strlen; $i ++) {
				if ($i >= $start && $i < ($start + $sublen)) {
					if (ord ( substr ( $string, $i, 1 ) ) > 129) {
						$tmpstr .= substr ( $string, $i, 2 );
					} else {
						$tmpstr .= substr ( $string, $i, 1 );
					}
				}
				if (ord ( substr ( $string, $i, 1 ) ) > 129)
					$i ++;
			}
			if (strlen ( $tmpstr ) < $strlen)
				$tmpstr .= "...";
			return $tmpstr;
		}
	}

	/**
	 * 获取定长的随机数
	 *
	 * @param int $length
	 * @return string
	 */
	public static function RandomKeys($length) {
		$randomKey = "";
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for($i = 0; $i < $length; $i ++) {
			$randomKey .= $pattern [mt_rand ( 0, 61 )];
		}
		return $randomKey;
	}

	/**
	 * 获取定长的随机数(数字)
	 *
	 * @param int $length
	 * @return string
	 */
	public static function RandomNumber($length) {
		$randomKey = "";
		$pattern = '1234567890';
		for($i = 0; $i < $length; $i ++) {
			$randomKey .= $pattern [mt_rand ( 0, 9 )];
		}
		return $randomKey;
	}

	/**
	 * 获取定长的随机数
	 *
	 * @param int $length
	 * @return string
	 */
	public static function RandomCode($length) {
		$randomKey = "";
		$pattern = '23456789abcdefghjkmnpqrstuvwxyz';
		for($i = 0; $i < $length; $i ++) {
			$randomKey .= $pattern [mt_rand ( 0, 30 )];
		}
		return $randomKey;
	}

	/**
	 * 获取数字区间随机数
	 *
	 * @param 起始数 $start
	 * @param 结束数 $end
	 * @return number
	 */
	public static function RandomDuration($start, $end) {
		$randomKey = mt_rand ( $start, $end );
		return $randomKey;
	}

	/**
	 * 获取GUID
	 *
	 * @return string
	 */
	public static function Guid() {
		$charid = strtoupper ( md5 ( uniqid ( mt_rand (), true ) ) );
		$hyphen = chr ( 45 );
		$guid = substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 );
		return $guid;
	}

	/**
	 * 获取时长
	 *
	 * @param unknown $seconds
	 * @return string
	 */
	public static function GetTimmingLong($seconds) {
		if ($seconds > 3600) {
			$hours = intval ( $seconds / 3600 );
			$minutes = $seconds % 3600;
			if ($hours < 100) {
				$time = substr ( "00" . $hours, - 2 ) . ":" . gmstrftime ( '%M:%S', $minutes );
			} else {
				$time = $hours . ":" . gmstrftime ( '%M:%S', $minutes );
			}
		} else {
			$time = gmstrftime ( '%H:%M:%S', $seconds );
		}
		return $time;
	}

	/**
	 * 获取分页参数
	 *
	 * @return array
	 */
	public static function GetPageParameter() {
		$parameter = array (
				'10' => 10,
				'20' => 20,
				'50' => 50,
				'100' => 100
		);

		return $parameter;
	}

	/**
	 * 获取时间差
	 *
	 * @param number $timeStamp
	 * @param number $timeStamp_1
	 * @return number
	 */
	public static function GetTimeDifference($timeStamp, $timeStamp_1) {
		$rok = 0;
		if (substr ( date ( 'Y-m-d H:i:s', $timeStamp ), 11, 2 ) >= 0) {
			$rok = 1;
		}
		$datediff = strtotime ( date ( 'Y-m-d', $timeStamp ) ) - strtotime ( date ( 'Y-m-d', $timeStamp_1 ) );
		$result = intval ( $datediff / 86400 ) + $rok;
		return $result;
	}

	/**
	 * 时间加减计算
	 *
	 * @param string $part
	 * @param number $n
	 * @param date $date
	 * @return string
	 */
	public static function DateAdd($part, $n, $date) {
		switch ($part) {
			case "y" :
				$val = date ( "Y-m-d H:i:s", strtotime ( $date . " +$n year" ) );
				break;
			case "m" :
				$val = date ( "Y-m-d H:i:s", strtotime ( $date . " +$n month" ) );
				break;
			case "w" :
				$val = date ( "Y-m-d H:i:s", strtotime ( $date . " +$n week" ) );
				break;
			case "d" :
				$val = date ( "Y-m-d H:i:s", strtotime ( $date . " +$n day" ) );
				break;
			case "h" :
				$val = date ( "Y-m-d H:i:s", strtotime ( $date . " +$n hour" ) );
				break;
			case "n" :
				$val = date ( "Y-m-d H:i:s", strtotime ( $date . " +$n minute" ) );
				break;
			case "s" :
				$val = date ( "Y-m-d H:i:s", strtotime ( $date . " +$n second" ) );
				break;
		}
		return $val;
	}

	/**
	 * 友好的时间显示
	 *
	 * @param int $sTime
	 *        	待显示的时间
	 * @param string $type
	 *        	类型. normal | mohu | full | ymd | other
	 * @param string $alt
	 *        	已失效
	 * @return string
	 */
	public static function FriendlyDate($sTime, $type = 'normal', $alt = 'false') {
		if (! $sTime)
			return '';
			// sTime=源时间，cTime=当前时间，dTime=时间差
		$cTime = time ();
		$dTime = $cTime - $sTime;
		$dDay = intval ( date ( "z", $cTime ) ) - intval ( date ( "z", $sTime ) );
		// $dDay = intval($dTime/3600/24);
		$dYear = intval ( date ( "Y", $cTime ) ) - intval ( date ( "Y", $sTime ) );
		// normal：n秒前，n分钟前，n小时前，日期
		if ($type == 'normal') {
			if ($dTime < 60) {
				if ($dTime < 10) {
					return '刚刚'; // by yangjs
				} else {
					return intval ( floor ( $dTime / 10 ) * 10 ) . "秒前";
				}
			} elseif ($dTime < 3600) {
				return intval ( $dTime / 60 ) . "分钟前";
				// 今天的数据.年份相同.日期相同.
			} elseif ($dYear == 0 && $dDay == 0) {
				// return intval($dTime/3600)."小时前";
				return '今天' . date ( 'H:i', $sTime );
			} elseif ($dYear == 0) {
				return date ( "m月d日 H:i", $sTime );
			} else {
				return date ( "Y-m-d H:i", $sTime );
			}
		} elseif ($type == 'mohu') {
			if ($dTime < 60) {
				return $dTime . "秒前";
			} elseif ($dTime < 3600) {
				return intval ( $dTime / 60 ) . "分钟前";
			} elseif ($dTime >= 3600 && $dDay == 0) {
				return intval ( $dTime / 3600 ) . "小时前";
			} elseif ($dDay > 0 && $dDay <= 7) {
				return intval ( $dDay ) . "天前";
			} elseif ($dDay > 7 && $dDay <= 30) {
				return intval ( $dDay / 7 ) . '周前';
			} elseif ($dDay > 30) {
				return intval ( $dDay / 30 ) . '个月前';
			}
			// full: Y-m-d , H:i:s
		} elseif ($type == 'full') {
			return date ( "Y-m-d , H:i:s", $sTime );
		} elseif ($type == 'ymd') {
			return date ( "Y-m-d", $sTime );
		} else {
			if ($dTime < 60) {
				return $dTime . "秒前";
			} elseif ($dTime < 3600) {
				return intval ( $dTime / 60 ) . "分钟前";
			} elseif ($dTime >= 3600 && $dDay == 0) {
				return intval ( $dTime / 3600 ) . "小时前";
			} elseif ($dYear == 0) {
				return date ( "Y-m-d H:i:s", $sTime );
			} else {
				return date ( "Y-m-d H:i:s", $sTime );
			}
		}
	}

	/**
	 * 数字转换中文
	 *
	 * @param number $num
	 * @return string
	 */
	public static function NumberToChinese($num) {
		$chiNum = array (
				'零',
				'一',
				'二',
				'三',
				'四',
				'五',
				'六',
				'七',
				'八',
				'九'
		);
		$chiUni = array (
				'',
				'十',
				'百',
				'千',
				'万',
				'亿',
				'十',
				'百',
				'千'
		);

		$chiStr = '';
		$num_str = ( string ) $num;
		$count = strlen ( $num_str );
		$last_flag = true; // 上一个 是否为0
		$zero_flag = true; // 是否第一个
		$temp_num = null; // 临时数字
		$chiStr = ''; // 拼接结果
		if ($count == 2) { // 两位数
			$temp_num = $num_str [0];
			$chiStr = $temp_num == 1 ? $chiUni [1] : $chiNum [$temp_num] . $chiUni [1];
			$temp_num = $num_str [1];
			$chiStr .= $temp_num == 0 ? '' : $chiNum [$temp_num];
		} else if ($count > 2) {
			$index = 0;
			for($i = $count - 1; $i >= 0; $i --) {
				$temp_num = $num_str [$i];
				if ($temp_num == 0) {
					if (! $zero_flag && ! $last_flag) {
						$chiStr = $chiNum [$temp_num] . $chiStr;
						$last_flag = true;
					}
				} else {
					$chiStr = $chiNum [$temp_num] . $chiUni [$index % 9] . $chiStr;
					$zero_flag = false;
					$last_flag = false;
				}
				$index ++;
			}
		} else {
			$chiStr = $chiNum [$num_str [0]];
		}
		return $chiStr;
	}

	/**
	 * 计算年龄
	 *
	 * @param date $birthday
	 * 			2000-01-01
	 * @return boolean number
	 */
	public static function Birthday($birthday) {
		$age = strtotime ( $birthday );
		if ($age === false) {
			return false;
		}
		list ( $y1, $m1, $d1 ) = explode ( "-", date ( "Y-m-d", $age ) );
		$now = strtotime ( "now" );
		list ( $y2, $m2, $d2 ) = explode ( "-", date ( "Y-m-d", $now ) );
		$age = $y2 - $y1;
		if (( int ) ($m2 . $d2) < ( int ) ($m1 . $d1))
			$age -= 1;
		return $age;
	}

	/**
	 * 获取高速缓存对象列表
	 *
	 * @return multitype:mixed
	 */
	public static function GetMemcachedItems() {
		$memcache = new Memcache ();
		$memcache->connect ( MEMCACHE_IPADDRESS, MEMCACHE_PORT );
		$cacheItems = Func::GetCacheItems ();
		$items = $cacheItems ['items'];
		$memcachedItems = array ();
		foreach ( $items as $server => $entries ) {
			foreach ( $entries as $slabId => $slab ) {
				$items = Func::DumpCacheSlab ( $server, $slabId, $slab ['number'] );
				foreach ( $items ['ITEM'] as $itemKey => $itemInfo ) {
					$item = Zend_Json::decode ( $memcache->get ( $itemKey ) );
					$memcachedItems [$itemKey] = $item;
				}
			}
		}
		$memcache->close ();
		return $memcachedItems;
	}

	public static function SendMemcacheCommands($command) {
		$MEMCACHE_SERVERS [] = MEMCACHE_IPADDRESS . ':' . MEMCACHE_PORT;
		$result = array ();

		foreach ( $MEMCACHE_SERVERS as $server ) {
			$strs = explode ( ':', $server );
			$host = $strs [0];
			$port = $strs [1];
			$result [$server] = Func::SendMemcacheCommand ( $host, $port, $command );
		}
		return $result;
	}

	public static function SendMemcacheCommand($server, $port, $command) {
		$s = @fsockopen ( $server, $port );
		if (! $s) {
			die ( "Cant connect to:" . $server . ':' . $port );
		}

		fwrite ( $s, $command . "\r\n" );

		$buf = '';
		while ( (! feof ( $s )) ) {
			$buf .= fgets ( $s, 256 );
			if (strpos ( $buf, "END\r\n" ) !== false) {
				// stat says end
				break;
			}
			if (strpos ( $buf, "DELETED\r\n" ) !== false || strpos ( $buf, "NOT_FOUND\r\n" ) !== false) {
				// delete says these
				break;
			}
			if (strpos ( $buf, "OK\r\n" ) !== false) {
				// flush_all says ok
				break;
			}
		}
		fclose ( $s );
		return Func::ParseMemcacheResults ( $buf );
	}

	public static function ParseMemcacheResults($str) {
		$res = array ();
		$lines = explode ( "\r\n", $str );
		$cnt = count ( $lines );
		for($i = 0; $i < $cnt; $i ++) {
			$line = $lines [$i];
			$l = explode ( ' ', $line, 3 );
			if (count ( $l ) == 3) {
				$res [$l [0]] [$l [1]] = $l [2];
				if ($l [0] == 'VALUE') {
					// next line is the value
					$res [$l [0]] [$l [1]] = array ();
					list ( $flag, $size ) = explode ( ' ', $l [2] );
					$res [$l [0]] [$l [1]] ['stat'] = array (
							'flag' => $flag,
							'size' => $size
					);
					$res [$l [0]] [$l [1]] ['value'] = $lines [++ $i];
				}
			} elseif ($line == 'DELETED' || $line == 'NOT_FOUND' || $line == 'OK') {
				return $line;
			}
		}
		return $res;
	}

	public static function DumpCacheSlab($server, $slabId, $limit) {
		list ( $host, $port ) = explode ( ':', $server );
		$resp = Func::SendMemcacheCommand ( $host, $port, 'stats cachedump ' . $slabId . ' ' . $limit );

		return $resp;
	}

	public static function GetCacheItems() {
		$items = Func::SendMemcacheCommands ( 'stats items' );
		$serverItems = array ();
		$totalItems = array ();
		foreach ( $items as $server => $itemlist ) {
			$serverItems [$server] = array ();
			$totalItems [$server] = 0;
			if (! isset ( $itemlist ['STAT'] )) {
				continue;
			}

			$iteminfo = $itemlist ['STAT'];

			foreach ( $iteminfo as $keyinfo => $value ) {
				if (preg_match ( '/items\:(\d+?)\:(.+?)$/', $keyinfo, $matches )) {
					$serverItems [$server] [$matches [1]] [$matches [2]] = $value;
					if ($matches [2] == 'number') {
						$totalItems [$server] += $value;
					}
				}
			}
		}
		return array (
				'items' => $serverItems,
				'counts' => $totalItems
		);
	}

	function getMemcacheStats($total = true) {
		$resp = Func::SendMemcacheCommands ( 'stats' );
		if ($total) {
			$res = array ();
			foreach ( $resp as $server => $r ) {
				foreach ( $r ['STAT'] as $key => $row ) {
					if (! isset ( $res [$key] )) {
						$res [$key] = null;
					}
					switch ($key) {
						case 'pid' :
							$res ['pid'] [$server] = $row;
							break;
						case 'uptime' :
							$res ['uptime'] [$server] = $row;
							break;
						case 'time' :
							$res ['time'] [$server] = $row;
							break;
						case 'version' :
							$res ['version'] [$server] = $row;
							break;
						case 'pointer_size' :
							$res ['pointer_size'] [$server] = $row;
							break;
						case 'rusage_user' :
							$res ['rusage_user'] [$server] = $row;
							break;
						case 'rusage_system' :
							$res ['rusage_system'] [$server] = $row;
							break;
						case 'curr_items' :
							$res ['curr_items'] += $row;
							break;
						case 'total_items' :
							$res ['total_items'] += $row;
							break;
						case 'bytes' :
							$res ['bytes'] += $row;
							break;
						case 'curr_connections' :
							$res ['curr_connections'] += $row;
							break;
						case 'total_connections' :
							$res ['total_connections'] += $row;
							break;
						case 'connection_structures' :
							$res ['connection_structures'] += $row;
							break;
						case 'cmd_get' :
							$res ['cmd_get'] += $row;
							break;
						case 'cmd_set' :
							$res ['cmd_set'] += $row;
							break;
						case 'get_hits' :
							$res ['get_hits'] += $row;
							break;
						case 'get_misses' :
							$res ['get_misses'] += $row;
							break;
						case 'evictions' :
							$res ['evictions'] += $row;
							break;
						case 'bytes_read' :
							$res ['bytes_read'] += $row;
							break;
						case 'bytes_written' :
							$res ['bytes_written'] += $row;
							break;
						case 'limit_maxbytes' :
							$res ['limit_maxbytes'] += $row;
							break;
						case 'threads' :
							$res ['rusage_system'] [$server] = $row;
							break;
					}
				}
			}
			return $res;
		}
		return $resp;
	}
	//自定义函数手机号隐藏中间四位
	function hphone($str){
	    $str=$str;
	    $resstr=substr_replace($str,'****',3,4);
	    return $resstr;
	}
	//隐藏身份证号中间
	function hidcard($str){
	    $resstr=substr_replace($str,'****',4,10);
	    return $resstr;
	}
}