<?php

class IndexController extends Zend_Controller_Action {
	private $timeout = 600;

	public function init() {
		$this->_helper->viewRenderer->setNoRender ();
		/* Initialize action controller here */
	}

	private function getMenuList(System_Admin_User $user) {
		$selfMenu = array ();
		
		if ($user->GetId () > 1) {
			// 用户所属分组所有权限
			$groupCongregation = new System_Admin_Congregation ( $user );
			foreach ( $groupCongregation->GetItems () as $valueCongregation ) {
				$groupRelation = new System_Admin_Purview ( $valueCongregation->GetOrganize () );
				foreach ( $groupRelation->GetMenus () as $valueMenu ) {
					$selfMenu [] = $valueMenu->GetId ();
				}
			}
			
			$userRelation = new System_Admin_Relation ( $user );
			foreach ( $userRelation->GetMenus () as $valueMenu ) {
				$selfMenu [] = $valueMenu->GetId ();
			}
			
			print_r ( $selfMenu );
		} else {
			
			$group = new System_Admin_Group ();
			foreach ( $group->GetItems () as $value ) {
				$selfMenu [] = $this->GetMenuField ( $value, $value->GetChildren () );
			}
		}
		
		print_r ( $selfMenu );
	}
	
	public function index1Action(){
		$startDate = '2020-12-01';
		$endDate = '2020-12-31';
		print_r(Business_Statistics_Account::GetAccountDayStatisticsFromDate($startDate, $endDate));
		
		$user = new Business_User_Base ( 6 );
		var_dump('balanceMoney:',$user->GetBalance());
		var_dump('voucherMoney:',$user->GetVoucherBalance());
		die('x');
	}

	public function indexAction() {
// 		$user = new Business_User_Base ( 6 );
// 		$changeMoney = 60 * -1;
// 		$changeMode = new Business_Enum_Money('ORDER_OUT');
// 		$changeType = 1;
// 		$result = $user->AddMoney($changeMoney, $changeMode,$changeType);
// 		var_dump($result);
// 		die('x');
		$user = new Business_User_Base ( 6 );
		$changeMoney = 500;
		$changeType = 1;
		$changeMode = new Business_Enum_Money ( 'MANUAL_IN' );
		$result = $user->AddMoney ( $changeMoney, $changeMode,$changeType );
		var_dump ( $result );
		die ( 'xx' );
// 		$user = new Business_User_Base ( 7 );
// 		$changeMoney = 1000;
// 		$changeMode = new Business_Enum_Money ( 'MANUAL_IN' );
// 		$user->AddMoney ( $changeMoney, $changeMode );
// 		die ( 'xx' );
		$now = sprintf ( "%.0f", Func::GetMillisecond () / 1000 );
		$timestamp = ( int ) time ();
		$timeResult = $now - $timestamp;
		var_dump ( $now );
		var_dump ( $timestamp );
		var_dump ( $timeResult );
		var_dump ( - 1 * $this->timeout );
		var_dump ( 1 * $this->timeout );
		if ($timeResult > - 1 * $this->timeout && $timeResult < 1 * $this->timeout) {
			var_dump ( 'SUCCESS' );
		}
		die ( 'x' );
		$user = new Business_User_Base ( 6 );
		var_dump ( "杀手排名：" . $user->GetKillerRanking () );
		var_dump ( "杀手积分：" . $user->GetKillerIntegral () );
		var_dump ( "杀手称号：" . $user->GetKillerTitle () );
		// die('x');
		var_dump ( "侦探排名：" . $user->GetDetectiveRanking () );
		var_dump ( "侦探积分：" . $user->GetDetectiveIntegral () );
		var_dump ( "侦探称号：" . $user->GetDetectiveTitle () );
		var_dump ( "总排名：" . $user->GetTotalRanking () );
		var_dump ( "总积分：" . $user->GetTotalIntegral () );
		var_dump ( "总称号：" . $user->GetTotalTitle () );
		// print_r ( $userIntegralRankList );
		die ( 'x' );
		
		// $userObject = Object_User_Indexing::GetUserObejctFromAdminUserId ( 31 );
		// var_dump($userObject->GetId());
		// die('xx');
		
		var_dump ( Format::FormatStreamDecrypt ( '9p1s6/K0ChhdBaMsHMUunw==' ) );
		var_dump ( Format::FormatStreamDecrypt ( 'FgxxXYtjp1UirnNCok35OA==' ) );
		$userName = 'xiaoyu';
		$password = '123';
		
		$signin = new Business_Webpage_Signin ();
		$result = $signin->LoginCheck ( $userName, $password );
		
		$message = array (
				"code" => $signin->GetCode (),
				"msg" => $signin->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($signin->GetData ()) {
			$message ['data'] = $signin->GetData ();
		}
		var_dump ( $result );
		var_dump ( $message );
		die ( 'x' );
		// $storeId = 1;
		// $scriptId = 2;
		// $deskId = 2;
		// $hostId = 1;
		// $orderOperatorId = 1;
		// $remark = '备注';
		// $detailList = array (
		// array (
		// 'userId' => 6,
		// 'isPay' => 0
		// ),
		// array (
		// 'userId' => 7,
		// 'isPay' => 0
		// ),
		// );
		
		// $order = new Business_Webpage_Order ();
		// $result = $order->AddOrder ( $storeId, $scriptId, $deskId, $hostId, $orderOperatorId, $remark, $detailList );
		
		// $message = array (
		// "code" => $order->GetCode (),
		// "msg" => $order->GetMessage (),
		// "time" => date ( 'Y-m-d H:i:s' )
		// );
		// if ($order->GetData ()) {
		// $message ['data'] = $order->GetData ();
		// }
		// var_dump($result);
		// print_r($message);
		// die('x');
		$orderId = 2;
		$settlementOperatorId = 1;
		$paymentMethod = 1;
		$detailList = array (
				array (
						'orderDetailId' => 2,
						'discount' => 0.5 
				) 
		);
		$detailIntegralList = array (
				array (
						'orderDetailId' => 2,
						'orderDetailIntegralList' => array (
								array (
										'roleId' => 2,
										'integral' => 2 
								),
								array (
										'roleId' => 3,
										'integral' => 1 
								) 
						) 
				),
				array (
						'orderDetailId' => 2,
						'orderDetailIntegralList' => array (
								array (
										'roleId' => 2,
										'integral' => 2 
								),
								array (
										'roleId' => 3,
										'integral' => 1 
								) 
						) 
				) 
		);
		
		$order = new Business_Webpage_Order ();
		$result = $order->SetOrderSettlement ( $orderId, $settlementOperatorId, $paymentMethod, $detailList, $detailIntegralList );
		
		$message = array (
				"code" => $order->GetCode (),
				"msg" => $order->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		if ($order->GetData ()) {
			$message ['data'] = $order->GetData ();
		}
		var_dump ( $result );
		print_r ( $message );
		die ( 'x' );
		
		die ();
	}
	private $m = 1;

	function fbnq($n, $flag) {
		sleep ( 1 );
		var_dump ( 'n:' . $n );
		var_dump ( 'm::' . $this->m );
		var_dump ( 'flag::' . $flag );
		var_dump ( 'date:' . date ( 'H;i:s' ) );
		$this->m ++;
		
		if ($n <= 0)
			return 0;
		if ($n == 1 || $n == 2)
			return 1;
		
		$r1 = $this->fbnq ( $n - 1, 'left' );
		$r2 = $this->fbnq ( $n - 2, 'right' );
		
		var_dump ( 'r1:' . $r1 );
		var_dump ( 'r2:' . $r2 );
		return $r1 + $r2;
	}
	
	// 4
	
	// r: 3 c => r 1 + r2 1 => r: r1 1 + r2 1
	public function testAction() {
		var_dump ( "result:" . $this->fbnq ( 4 ) );
		die ();
		$order = new Business_Script_Order ( 1 );
		$a = Business_Script_Tool::GetOrderFieldData ( 1 );
		print_r ( $a );
		die ( 'x' );
		$detailList = array (
				array (
						'user' => 1,
						'isMakeUp' => 0,
						array (
								'roleId' => 1,
								'integral' => 100 
						) 
				) 
		);
		$order->addOrderDetail ( $order, $detailList );
		
		$storeId = 1;
		$scriptId = 1;
		$deskId = 1;
		$orderOperatorId = 1;
		$remark = "123321";
		
		$detailList = array (
				array (
						'user' => 1,
						'isPay' => 0 
				) 
		);
		$order = new Business_Webpage_Order ();
		$result = $order->AddOrder ( $storeId, $scriptId, $deskId, $orderOperatorId, $remark, $detailList );
		
		$message = array (
				"code" => $order->GetCode (),
				"msg" => $order->GetMessage (),
				"time" => date ( 'Y-m-d H:i:s' ) 
		);
		print_r ( $message );
		die ();
	}

	public function test1Action() {
		$redis = new Redis ();
		$redis->connect ( '127.0.0.1', 6379 );
		$redis->auth ( '123456' );
		echo "Connection to server successfully";
		$redis_name = 'secKill3';
		
		// 模拟100人请求秒杀(高压力)
		for($i = 0; $i < 100; $i ++) {
			$uid = rand ( 10000000, 99999999 );
			// 获取当前队列已经拥有的数量,如果人数少于十,则加入这个队列
			$num = 10;
			if ($redis->lLen ( $redis_name ) < $num) {
				$redis->rPush ( $redis_name, $uid );
				echo $uid . "秒杀成功 $i" . "<br>";
			} else {
				// 如果当前队列人数已经达到10人,则返回秒杀已完成
				echo "秒杀已结束 $i<br>";
			}
		}
		// 关闭redis连接
		$redis->close ();
		// $redis->set("tutorial-name", "Redis tutorial");
		// var_dump( $redis->get("tutorial-name"));
		
		$storeId = 1;
		
		$deskList = Business_Script_List::GetEnabledDeskList ( $storeId );
		
		$listCollection = Business_Script_Tool::GetDeskOrderListFieldData ( $deskList );
		
		// print_r($deskList);
		// print_r($listCollection);
		die ( 'x' );
	}

	protected function curl($url, $postFields = null) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_FAILONERROR, false );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		
		$postBodyString = "";
		$encodeArray = Array ();
		$postMultipart = false;
		
		if (is_array ( $postFields ) && 0 < count ( $postFields )) {
			
			foreach ( $postFields as $k => $v ) {
				if ("@" != substr ( $v, 0, 1 )) 				// 判断是不是文件上传
				{
					
					$postBodyString .= "$k=" . urlencode ( $this->characet ( $v, $this->postCharset ) ) . "&";
					$encodeArray [$k] = $this->characet ( $v, $this->postCharset );
				} else 				// 文件上传用multipart/form-data，否则用www-form-urlencoded
				{
					$postMultipart = true;
					$encodeArray [$k] = new \CURLFile ( substr ( $v, 1 ) );
				}
			}
			unset ( $k, $v );
			curl_setopt ( $ch, CURLOPT_POST, true );
			if ($postMultipart) {
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $encodeArray );
			} else {
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, substr ( $postBodyString, 0, - 1 ) );
			}
		}
		
		if (! $postMultipart) {
			$headers = array (
					'content-type: application/x-www-form-urlencoded;charset=' . $this->postCharset 
			);
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		}
		
		$reponse = curl_exec ( $ch );
		
		if (curl_errno ( $ch )) {
			
			throw new Exception ( curl_error ( $ch ), 0 );
		} else {
			$httpStatusCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
			if (200 !== $httpStatusCode) {
				throw new Exception ( $reponse, $httpStatusCode );
			}
		}
		
		curl_close ( $ch );
		return $reponse;
	}
}