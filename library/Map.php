<?php
class Map {

	/**
	 * 射线法计算点是否在多边形内
	 *
	 * @param string $p
	 *        	待判断的点坐标，格式：'111.676801,40.822199'
	 * @param string $poly
	 *        	多边形顶点，数组成员的格式同 p：
	 *        	Array (
	 *        	'111.608961,40.851019',
	 *        	'111.598325,40.792056',
	 *        	'111.740042,40.79293',
	 *        	'111.731705,40.888989',
	 *        	'111.728256,40.877208'
	 *        	);
	 * @return boolean
	 */
	public static function IsPointInPolygon($p, $poly) {
		$poly = array_values ( $poly );
		$count = count ( $poly );
		$positionArr = explode ( ",", $p );
		$px = ( float ) $positionArr [0];
		$py = ( float ) $positionArr [1];
		$flag = false;
		
		for($i = 0, $j = $count - 1; $i < $count; $j = $i, $i ++) {
			$polyI = explode ( ",", $poly [$i] );
			$polyJ = explode ( ",", $poly [$j] );
			$sx = ( float ) $polyI [0];
			$sy = ( float ) $polyI [1];
			$tx = ( float ) $polyJ [0];
			$ty = ( float ) $polyJ [1];
			
			// 点与多边形顶点重合
			if ($px == $sx && $py == $sy || $px == $tx && $py == $ty) {
				return true;
			}
			
			// 判断线段两端点是否在射线两侧
			if ($sy < $py && $ty >= $py || $sy >= $py && $ty < $py) {
				
				// 线段上与射线 Y 坐标相同的点的 X 坐标
				$x = $sx + ($py - $sy) * ($tx - $sx) / ($ty - $sy);
				
				// 点在多边形的边上
				if ($x == $px) {
					return true;
				}
				
				// 射线穿过多边形的边界
				if ($x > $px)
					$flag = ! $flag;
			}
		}
		return $flag;
	}

	/**
	 * 计算两组经纬度坐标 之间的距离
	 * params ：lat1 纬度1； lng1 经度1； lat2 纬度2； lng2 经度2； len_type （1:m or 2:km);
	 * return m or km
	 */
	public static function GetGaodeDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1) {
		$earthRadius = 6378.137; // 地球半径
		$pi = 3.1415926;
		$radLat1 = $lat1 * $pi / 180.0;
		$radLat2 = $lat2 * $pi / 180.0;
		$a = $radLat1 - $radLat2;
		$b = ($lng1 * $pi / 180.0) - ($lng2 * $pi / 180.0);
		$s = 2 * asin ( sqrt ( pow ( sin ( $a / 2 ), 2 ) + cos ( $radLat1 ) * cos ( $radLat2 ) * pow ( sin ( $b / 2 ), 2 ) ) );
		$s = $s * $earthRadius;
		$s = round ( $s * 1000 );
		if ($len_type > 1) {
			$s /= 1000;
		}
		return (string) round ( $s, 2 );
	}

	/**
	 * 计算两组经纬度坐标之间的距离
	 *
	 * @param string $lat1
	 *        	纬度1
	 * @param string $lng1
	 *        	经度1
	 * @param string $lat2
	 *        	纬度2
	 * @param string $lng2
	 *        	经度2
	 * @param number $len_type
	 *        	（1:m or 2:km);
	 * @return number
	 */
	public static function GetBaiduDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1) {
		$earthRadius = 6371000; // 地球半径
		$pk = 180 / 3.14169;
		$a1 = $lat1 / $pk;
		$a2 = $lng1 / $pk;
		$b1 = $lat2 / $pk;
		$b2 = $lng2 / $pk;
		$t1 = cos ( $a1 ) * cos ( $a2 ) * cos ( $b1 ) * cos ( $b2 );
		$t2 = cos ( $a1 ) * sin ( $a2 ) * cos ( $b1 ) * sin ( $b2 );
		$t3 = sin ( $a1 ) * sin ( $b1 );
		$tt = acos ( $t1 + $t2 + $t3 );
		
		$s = $earthRadius * $tt;
		if ($len_type > 1) {
			$s /= 1000;
		}
		return (string) round ( $s, 2 );
	}

	/**
	 * 计算距离
	 *
	 * @param string $positionA        	
	 * @param string $positionB        	
	 * @return float
	 */
	public static function GetDistance($positionA, $positionB, $len_type = 1) {
		$positionA_arr = explode ( ',', $positionA );
		
		$lat1 = $positionA_arr [0];
		$lng1 = $positionA_arr [1];
		
		$positionB_arr = explode ( ',', $positionB );
		$lat2 = $positionB_arr [0];
		$lng2 = $positionB_arr [1];
		
		return self::GetGaodeDistance ( $lat1, $lng1, $lat2, $lng2, $len_type ) == null ? "" : self::GetGaodeDistance ( $lat1, $lng1, $lat2, $lng2, $len_type );
	}
	
	// /**
	// * 计算距离
	// *
	// * @param string $positionA
	// * @param string $positionB
	// * @return float
	// */
	// public static function GetDistance($positionA, $positionB) {
	// $positionA_arr = explode ( ',', $positionA );
	
	// $x1 = $positionA_arr [0];
	// $y1 = $positionA_arr [1];
	
	// $positionB_arr = explode ( ',', $positionB );
	// $x2 = $positionB_arr [0];
	// $y2 = $positionB_arr [1];
	
	// $result = sprintf ( '%.2f', (sqrt ( (($x1 - $x2) * ($x1 - $x2)) + (($y1 - $y2) * ($y1 - $y2)) )) * 100000 );
	// return $result;
	// }
	
	/**
	 * 计算距离
	 *
	 * @param array $positionList        	
	 * @return multitype:multitype:unknown Ambigous <number, string>
	 */
	public static function GetDistanceList($positionList) {
		$objectList = array ();
		for($i = 0; $i < count ( $positionList ); $i ++) {
			$object = array ();
			$long = 0;
			if ($i > 0) {
				$positionA = $positionList [$i - 1];
				$positionB = $positionList [$i];
				$long = self::GetDistance ( $positionA, $positionB );
			}
			$object ['position'] = $positionList [$i];
			$object ['long'] = $long;
			$objectList [] = $object;
		}
		return $objectList;
	}

	/**
	 * 计算距离
	 *
	 * @param array $positionList        	
	 * @return multitype:multitype:unknown Ambigous <number, string>
	 */
	public static function GetDistanceList1($positionList) {
		$objectList = array ();
		$tmpPositionA = 0;
		foreach ( $positionList as $key => $value ) {
			$object = array ();
			$long = 0;
			if ($tmpPositionA == $value) {
				$positionA = $tmpPositionA;
				$positionB = $value;
				$long = self::GetDistance ( $positionA, $positionB );
			}
			$object ['position'] = $value;
			$object ['long'] = $long;
			$objectList [$key] = $object;
			
			$tmpPositionA = $value;
		}
		print_r ( $objectList );
		die ( "asd" );
	}
}