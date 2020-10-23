<?php

class WeiXin {

	public static function getWechat() {
		return new Object_Setting_Wechat ();
	}

	private static function curlConnectionDe($url = null, $data = null) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		if ($data != null) {
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		}
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		return $output;
	}

	private static function curlConnection($url = null, $data = null) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		if ($data != null) {
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		}
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		$jsoninfo = json_decode ( $output, true );
		return $jsoninfo;
	}

	private static function curlDownloadFile($url = null) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_NOBODY, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$output = curl_exec ( $ch );
		$httpInfo = curl_getinfo ( $ch );
		curl_close ( $ch );
		$fileinfo = array_merge ( array (
				'type' => $httpInfo ['content_type'] 
		), array (
				'body' => $output 
		) );
		return $fileinfo;
	}

	public static function jssdkSignatrue($timestamp, $nonceStr) {
		$protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		$sourceParam = array (
				"jsapi_ticket=" . WeiXin::getJssdkTicket (),
				"timestamp=" . $timestamp,
				"noncestr=" . $nonceStr,
				"url=" . $url 
		);
		sort ( $sourceParam, SORT_STRING );
		$sourceStr = implode ( "&", $sourceParam );
		$signature = sha1 ( $sourceStr );
		
		return $signature;
	}

	public static function callbackSignature($signature, $timestamp, $nonce, $echostr) {
		$token = TOKEN_ID;
		$tmpArr = array (
				$token,
				$timestamp,
				$nonce 
		);
		sort ( $tmpArr, SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		
		if ($tmpStr == $signature) {
			return $echostr;
		} else {
			return "";
		}
	}

	public static function setAccessToken() {
		$wechat = self::getWechat ();
		$tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $wechat->GetAppId () . "&secret=" . $wechat->GetAppSecret () . "";
		$jsoninfo = WeiXin::curlConnection ( $tokenUrl );
		$accessToken = $jsoninfo ["access_token"];
		
		$memcache = new Mem ();
		$memcache->open ();
		$memcache->save ( "ACCESS_TOKEN", $accessToken, 3600 );
		$memcache->close ();
		
		return $accessToken;
	}

	public static function getAccessToken() {
		$memcache = new Mem ();
		$memcache->open ();
		$accessToken = $memcache->load ( "ACCESS_TOKEN" );
		if (! $accessToken) {
			$accessToken = WeiXin::setAccessToken ();
		}
		$memcache->close ();
		return $accessToken;
	}

	public static function setJssdkTicket() {
		$tokenUrl = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=" . WeiXin::getAccessToken () . "&type=jsapi";
		$jsoninfo = WeiXin::curlConnection ( $tokenUrl );
		$jssdkTicket = $jsoninfo ["ticket"];
		
		$memcache = new Mem ();
		$memcache->open ();
		$memcache->save ( "JSSDK_TICKET", $jssdkTicket, 3600 );
		$memcache->close ();
		
		return $jssdkTicket;
	}

	public static function getJssdkTicket() {
		$memcache = new Mem ();
		$memcache->open ();
		$jssdkTicket = $memcache->load ( "JSSDK_TICKET" );
		if (! $jssdkTicket) {
			$jssdkTicket = WeiXin::setJssdkTicket ();
		}
		$memcache->close ();
		return $jssdkTicket;
	}

	public static function setIpAddressList() {
		$tokenUrl = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=" . WeiXin::getAccessToken () . "";
		$jsoninfo = WeiXin::curlConnection ( $tokenUrl );
		$ipList = $jsoninfo ["ip_list"];
		
		$memcache = new Mem ();
		$memcache->open ();
		$memcache->save ( "IP_ADDRESS", $ipList, 3600 );
		$memcache->close ();
		
		return $ipList;
	}

	public static function getIpAddressList() {
		$memcache = new Mem ();
		$memcache->open ();
		$ipList = $memcache->load ( "IP_ADDRESS" );
		if (! $ipList) {
			$ipList = WeiXin::setIpAddressList ();
		}
		$memcache->close ();
		return $ipList;
	}

	public static function requestMessage($messageData) {
		$postStr = $messageData;
		if (! empty ( $postStr )) {
			
			// file_put_contents ( LOGDIR . "/request_msg/request.message." . date ( 'Y-m-d', time () ) . ".log", $postStr . "\n-------------------------\n", FILE_APPEND );
			file_put_contents ( LOGDIR . "/request.message." . date ( 'Y-m-d', time () ) . ".log", $postStr . "1\n-------------------------\n", FILE_APPEND );
			
			libxml_disable_entity_loader ( true );
			$messageObject = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			$msgType = trim ( $messageObject->MsgType );
			
			$contentStr = "Nothing Execute";
			$contentData = array ();
			$msgEvent = "";
			if ($msgType == "event") {
				$eventType = trim ( $messageObject->Event );
				switch ($eventType) {
					case "subscribe" :
						$contentStr = "订阅|$msgType|$eventType|$messageObject->FromUserName|$messageObject->ToUserName|$messageObject->CreateTime";
						$contentData = array (
								$messageObject->FromUserName,
								$messageObject->ToUserName,
								$messageObject->CreateTime 
						);
						break;
					case "unsubscribe" :
						$contentStr = "取消订阅|$msgType|$eventType|$messageObject->FromUserName|$messageObject->ToUserName|$messageObject->CreateTime";
						$contentData = array (
								$messageObject->FromUserName,
								$messageObject->ToUserName,
								$messageObject->CreateTime 
						);
						break;
					case "scancode_push" :
						$contentStr = "扫码推事件(无推送)|$msgType|$eventType|$messageObject->EventKey|$messageObject->ScanCodeInfo|$messageObject->ScanType|$messageObject->ScanResult";
						$contentData = array (
								$messageObject->EventKey,
								$messageObject->ScanCodeInfo,
								$messageObject->ScanType,
								$messageObject->ScanResult 
						);
						break;
					case "scancode_waitmsg" :
						$contentStr = "扫码推事件(消息接收中)|$msgType|$eventType|$messageObject->EventKey|$messageObject->ScanCodeInfo|$messageObject->ScanType|$messageObject->ScanResult";
						$contentData = array (
								$messageObject->EventKey,
								$messageObject->ScanCodeInfo,
								$messageObject->ScanType,
								$messageObject->ScanResult 
						);
						break;
					case "pic_sysphoto" :
						$contentStr = "弹出系统拍照发图|$msgType|$eventType|$messageObject->EventKey|$messageObject->SendPicsInfo|$messageObject->Count|$messageObject->PicMd5Sum";
						$contentData = array (
								$messageObject->EventKey,
								$messageObject->SendPicsInfo,
								$messageObject->Count,
								$messageObject->PicMd5Sum 
						);
						break;
					case "pic_photo_or_album" :
						$contentStr = "弹出拍照或者相册发图|$msgType|$eventType|$messageObject->EventKey|$messageObject->SendPicsInfo|$messageObject->Count|$messageObject->PicMd5Sum";
						$contentData = array (
								$messageObject->EventKey,
								$messageObject->SendPicsInfo,
								$messageObject->Count,
								$messageObject->PicMd5Sum 
						);
						break;
					case "pic_weixin" :
						$contentStr = "弹出微信相册发图|$msgType|$eventType|$messageObject->EventKey|$messageObject->SendPicsInfo|$messageObject->Count|$messageObject->PicMd5Sum";
						$contentData = array (
								$messageObject->EventKey,
								$messageObject->SendPicsInfo,
								$messageObject->Count,
								$messageObject->PicMd5Sum 
						);
						break;
					case "location_select" :
						$contentStr = "弹出地理位置选择|$msgType|$eventType|$messageObject->EventKey|$messageObject->SendLocationInfo|$messageObject->Location_X|$messageObject->Location_Y|$messageObject->Scale|$messageObject->Label|$messageObject->Poiname";
						$contentData = array (
								$messageObject->EventKey,
								$messageObject->SendLocationInfo,
								$messageObject->Location_X,
								$messageObject->Location_Y,
								$messageObject->Scale,
								$messageObject->Label,
								$messageObject->Poiname 
						);
						break;
					case "CLICK" :
						$contentStr = "点击按钮|$msgType|$eventType|$messageObject->EventKey";
						$contentData = array (
								$messageObject->EventKey 
						);
						break;
					case "VIEW" :
						$contentStr = "浏览页面|$msgType|$eventType|$messageObject->EventKey";
						$contentData = array (
								$messageObject->EventKey 
						);
						break;
					case "SCAN" :
						$contentStr = "扫码|$msgType|$eventType|$messageObject->EventKey|$messageObject->Ticket";
						$contentData = array (
								$messageObject->EventKey,
								$messageObject->Ticket 
						);
						break;
					case "LOCATION" :
						$contentStr = "上报位置|$msgType|$eventType|$messageObject->EventKey|$messageObject->Latitude|$messageObject->Longitude|$messageObject->Precision";
						$contentData = array (
								$messageObject->EventKey,
								$messageObject->Latitude,
								$messageObject->Longitude,
								$messageObject->Precision 
						);
						break;
					default :
						$contentStr = "其他|$msgType|$eventType|$messageObject->EventKey";
						$contentData = array (
								$messageObject->EventKey 
						);
						break;
				}
				$msgEvent = $eventType;
			} else {
				$megId = trim ( $messageObject->MsgId );
				switch ($msgType) {
					case "text" :
						$contentStr = "文本消息|$msgType|$megId|$messageObject->Content";
						$contentData = array (
								$megId,
								$messageObject->Content 
						);
						break;
					case "image" :
						$contentStr = "图片消息|$msgType|$megId|$messageObject->MediaId|$messageObject->PicUrl";
						$contentData = array (
								$megId,
								$messageObject->MediaId,
								$messageObject->PicUrl 
						);
						break;
					case "voice" :
						$contentStr = "语音消息|$msgType|$megId|$messageObject->MediaId|$messageObject->Format";
						$contentData = array (
								$megId,
								$messageObject->MediaId,
								$messageObject->Format 
						);
						break;
					case "video" :
						$contentStr = "视频消息|$msgType|$megId|$messageObject->MediaId|$messageObject->ThumbMediaId";
						$contentData = array (
								$megId,
								$messageObject->MediaId,
								$messageObject->ThumbMediaId 
						);
						break;
					case "shortvideo" :
						$contentStr = "小视频消息|$msgType|$megId|$messageObject->MediaId|$messageObject->ThumbMediaId";
						$contentData = array (
								$megId,
								$messageObject->MediaId,
								$messageObject->ThumbMediaId 
						);
						break;
					case "location" :
						$contentStr = "地理位置消息|$msgType|$megId|$messageObject->Location_X|$messageObject->Location_Y|$messageObject->Scale|$messageObject->Label";
						$contentData = array (
								$megId,
								$messageObject->Location_X,
								$messageObject->Location_Y,
								$messageObject->Scale,
								$messageObject->Label 
						);
						break;
					case "link" :
						$contentStr = "链接消息|$msgType|$megId|$messageObject->Title|$messageObject->Description|$messageObject->Url";
						$contentData = array (
								$megId,
								$messageObject->Title,
								$messageObject->Description,
								$messageObject->Url 
						);
						break;
					default :
						$contentStr = "其他|$msgType|$megId";
						$contentData = array (
								$megId 
						);
						break;
				}
				$msgEvent = false;
			}
			
			return list ( $messageType, $messageEvent, $messageObj, $messageRes, $messageDes ) = array (
					$msgType,
					$msgEvent,
					$messageObject,
					$contentData,
					$contentStr 
			);
		} else {
			return null;
		}
	}

	public static function responseMessage($fromUsername, $toUsername, $content, $is_subscribe = false) {
		$time = time ();
		$response = $content;
		$keyWords = array (
				'潜水' => '详细安排请加客服微信MSHUANG19M获取',
				'报名' => '详细安排请加客服微信MSHUANG19M获取',
				'美娜多' => '详细安排请加客服微信MSHUANG19M获取',
				'活动' => '详细安排请加客服微信MSHUANG19M获取' 
		);
		$has = false;
		foreach ( $keyWords as $key => $value ) {
			if (strpos ( $content, $key ) != false) {
				$response = $value;
				$has = true;
				break;
			}
		}
		if (! $has) {
			$response = '您好，有疑问请加客服微信MSHUANG19M';
		} elseif ($is_subscribe) {
			$response = $content;
		}
		$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						</xml>";
		$sendType = "text";
		$resultStr = sprintf ( $textTpl, $fromUsername, $toUsername, $time, $sendType, $response );
		file_put_contents ( LOGDIR . "/response_msg/response.message." . date ( 'Y-m-d', time () ) . ".log", $resultStr . "\n-------------------------\n", FILE_APPEND );
		return $resultStr;
	}

	public static function getMenuResource() {
		$menuResource = array (
				"button" => array (
						array (
								"name" => "我要潜水",
								"sub_button" => array (
										array (
												"type" => "view",
												"name" => "潜水主页",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/index" ) 
										),
										array (
												"type" => "view",
												"name" => "新手入口",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/community.article.list?articleCategoryGuid=4AC353AC-A90D-CEAF-77F4-20B80E095EA1" ) 
										),
										array (
												"type" => "view",
												"name" => "智能预定",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/spot.list" ) 
										),
										array (
												"type" => "view",
												"name" => "我要提问",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/message.detail?receiveMemberGuid=00000000-0000-0000-0000-000000000001" ) 
										) 
								) 
						),
						array (
								"name" => "潜水社区",
								"sub_button" => array (
										array (
												"type" => "view",
												"name" => "教练",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/member.coach.list" ) 
										),
										array (
												"type" => "view",
												"name" => "俱乐部",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/club.list" ) 
										),
										array (
												"type" => "view",
												"name" => "达人",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/member.master.list" ) 
										),
										array (
												"type" => "view",
												"name" => "潜水社区",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/community.list" ) 
										) 
								) 
						),
						array (
								"name" => "个人中心",
								"sub_button" => array (
										array (
												"type" => "view",
												"name" => "个人中心",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/my" ) 
										),
										array (
												"type" => "view",
												"name" => "我的消息",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/message.list" ) 
										),
										array (
												"type" => "view",
												"name" => "活动资讯",
												"url" => WeiXin::getAuthCode ( HOSTNAME . "/index/article.class.list?articleCategoryGuid=326A2F03-1BF5-BB56-592E-3B9D8F60E694" ) 
										) 
								) 
						) 
				) 
		);
		return $menuResource;
	}

	public static function getMenuItems() {
		$menuItems = array ();
		$menuResource = WeiXin::getMenuResource ();
		foreach ( $menuResource as $buttons ) {
			foreach ( $buttons as $subButton ) {
				foreach ( $subButton as $menu ) {
					foreach ( $menu as $items ) {
						$menuItems [] = $items;
					}
				}
			}
		}
		return $menuItems;
	}

	public static function getMenuItemFromKey($menuItemKey) {
		$menuItems = WeiXin::getMenuItems ();
		foreach ( $menuItems as $item ) {
			if (isset ( $item ['key'] )) {
				if ($item ['key'] == $menuItemKey) {
					return $item;
				}
			}
		}
		return null;
	}

	public static function clearMenuList() {
		$tokenUrl = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=" . WeiXin::getAccessToken () . "";
		$result = WeiXin::curlConnection ( $tokenUrl );
		return $result;
	}

	public static function createMenuList($data = null) {
		$tokenUrl = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . WeiXin::getAccessToken () . "";
		var_dump ( $data );
		$result = WeiXin::curlConnection ( $tokenUrl, $data );
		return $result;
	}

	public static function downloadMedia($mediaId) {
		$tokenUrl = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=" . WeiXin::getAccessToken () . "&media_id=" . $mediaId . "";
		$result = WeiXin::curlDownloadFile ( $tokenUrl );
		return $result;
	}

	public static function getAuthCode($redirectUri, $state = "") {
		$wechat = self::getWechat ();
		$tokenUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $wechat->GetAppId () . "&redirect_uri=" . urlencode ( $redirectUri ) . "&response_type=code&scope=snsapi_base&state=" . $state . "#wechat_redirect";
		return $tokenUrl;
	}

	public static function getAuthInfo($code) {
		$wechat = self::getWechat ();
		$memcache = new Mem ();
		$memcache->open ();
		$authInfo = $memcache->load ( $code );
		if (! $authInfo) {
			$tokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $wechat->GetAppId () . "&secret=" . $wechat->GetAppSecret () . "&code=" . $code . "&grant_type=authorization_code";
			$authInfo = WeiXin::curlConnection ( $tokenUrl );
			$memcache->open ();
			$memcache->save ( $code, $authInfo, ( int ) $authInfo ['expires_in'] );
		}
		$memcache->close ();
		return $authInfo;
	}

	public static function getUserInfo($openId) {
		$tokenUrl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . WeiXin::getAccessToken () . "&openid=" . $openId . "&lang=zh_CN";
		$result = WeiXin::curlConnection ( $tokenUrl );
		return $result;
	}

	public static function getUserInfoNew($accessToken, $openId) {
		$tokenUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $accessToken . "&openid=" . $openId . "&lang=zh_CN";
		$result = WeiXin::curlConnection ( $tokenUrl );
		return $result;
	}

	public static function getTemplateList() {
		$tokenUrl = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=" . WeiXin::getAccessToken () . "";
		$result = WeiXin::curlConnection ( $tokenUrl );
		return $result;
	}

	public static function sendUserTemplate($openId, $templateData) {
		$tokenUrl = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . WeiXin::getAccessToken () . "";
		$result = WeiXin::curlConnection ( $tokenUrl, $templateData );
		return $result;
	}

	public static function setWechatPayment($wechatOpenId, $totalFee, $notiftyUrl, $body, $order_id) {
		$prepayData = self::wechatPayment ( $wechatOpenId, $totalFee, $notiftyUrl, $body, $order_id );
		
		if (! isset ( $prepayData ['trade_type'] ) || ! isset ( $prepayData ['prepay_id'] )) {
			return $prepayData;
		}
		
		if (strtolower ( $prepayData ['trade_type'] ) == 'native') {
			return $prepayData ['code_url'];
		}
		
		$payment = array ();
		$payment ["timestamp"] = time ();
		$payment ["nonceStr"] = $prepayData ['nonce_str'];
		$payment ["package"] = "prepay_id=" . $prepayData ['prepay_id'];
		$payment ["signType"] = "MD5";
		
		$paySignStr = "appId=" . APP_ID . "&nonceStr=" . $payment ["nonceStr"] . "&package=" . $payment ["package"] . "&signType=" . $payment ["signType"] . "&timeStamp=" . $payment ["timestamp"] . "&key=" . MCH_KEY;
		$payment ["paySign"] = strtoupper ( md5 ( $paySignStr ) );
		
		return $payment;
	}

	public static function setWechatAppPayment($totalFee, $notiftyUrl, $body, $order_id) {
		$prepayData = self::wechatAppPayment ( $totalFee, $notiftyUrl, $body, $order_id );
		
		if (! isset ( $prepayData ['trade_type'] ) || ! isset ( $prepayData ['prepay_id'] )) {
			return $prepayData;
		}
		
		if (strtolower ( $prepayData ['trade_type'] ) == 'native') {
			return $prepayData ['code_url'];
		}
		$payment = array ();
		$payment ["appId"] = APP_ID;
		$payment ["partnerId"] = MCH_ID;
		$payment ["prepayId"] = $prepayData ['prepay_id'];
		$payment ["timeStamp"] = time ();
		$payment ["nonceStr"] = $prepayData ['nonce_str'];
		$payment ["packageValue"] = "Sign=WXPay";
		$payment ["signType"] = "MD5";
		
		$paySignStr = "appid=" . APP_ID . "&noncestr=" . $payment ["nonceStr"] . "&package=" . $payment ["packageValue"] . "&partnerid=" . MCH_ID . "&prepayid=" . $payment ["prepayId"] . "&timestamp=" . $payment ["timeStamp"] . "&key=" . MCH_KEY;
		$payment ["sign"] = strtoupper ( md5 ( $paySignStr ) );
		// var_dump($paySignStr);
		// print_r($prepayData);
		// print_r($payment);
		return $payment;
	}

	public static function wechatAppPayment($totalFee, $notiftyUrl, $body, $attach) {
		$tokenUrl = "https://api.mch.weixin.qq.com/pay/unifiedorder";
		
		$tempData = array ();
		$tempData ['appid'] = APP_ID;
		$tempData ['attach'] = $attach;
		$tempData ['mch_id'] = MCH_ID;
		$tempData ['nonce_str'] = Func::RandomCode ( 32 );
		$tempData ['notify_url'] = $notiftyUrl;
		$tempData ['out_trade_no'] = uniqid () . time ();
		$tempData ['spbill_create_ip'] = $_SERVER ['REMOTE_ADDR'];
		$tempData ['total_fee'] = $totalFee * 100;
		$tempData ['trade_type'] = "APP";
		$tempData ['body'] = $body;
		$tempData ['sign'] = self::getSignature ( $tempData, 'md5', array (
				'key' => MCH_KEY 
		) );
		file_put_contents ( LOGDIR . "/set.wechat.pay.debug" . date ( 'Y-m-d', time () ) . ".log", var_export ( $tempData, true ) . "\n-------------------------\n", FILE_APPEND );
		$data = self::arrayToXml ( $tempData );
		$curlResult = self::curlConnectionDe ( $tokenUrl, $data );
		// print_r($tempData);
		$arrData = XmlData::XmlToArray ( $curlResult );
		file_put_contents ( LOGDIR . "/set.result.wechat.pay.debug" . date ( 'Y-m-d', time () ) . ".log", var_export ( $arrData, true ) . "\n-------------------------\n", FILE_APPEND );
		
		return $arrData;
	}

	public static function wechatPayment($wechatOpenId, $totalFee, $notiftyUrl, $body, $order_id) {
		$tokenUrl = "https://api.mch.weixin.qq.com/pay/unifiedorder";
		
		$tempData = array ();
		$tempData ['openid'] = $wechatOpenId;
		$tempData ['body'] = $body;
		$tempData ['out_trade_no'] = uniqid () . time ();
		$tempData ['total_fee'] = $totalFee * 100;
		$tempData ['notify_url'] = $notiftyUrl;
		$tempData ['trade_type'] = "JSAPI";
		$tempData ['attach'] = $order_id;
		$tempData ['appid'] = APP_ID;
		$tempData ['mch_id'] = MCH_ID;
		$tempData ['nonce_str'] = Func::RandomCode ( 32 );
		$tempData ['spbill_create_ip'] = $_SERVER ['REMOTE_ADDR'];
		$tempData ['sign'] = self::getSignature ( $tempData, 'md5', array (
				'key' => MCH_KEY 
		) );
		file_put_contents ( LOGDIR . "/set.wechat.pay.debug" . date ( 'Y-m-d', time () ) . ".log", var_export ( $tempData, true ) . "\n-------------------------\n", FILE_APPEND );
		// $tmpArr = array (
		// "appid" => APP_ID,
		// "attach" => "pay_test",
		// "body" => "test",
		// "mch_id" => MCH_ID,
		// "nonce_str" => Func::RandomKeys ( 32 ),
		// "notify_url" => $notiftyUrl,
		// "openId" => $wechatOpenId,
		// "out_trade_no" => "1415659990",
		// "spbill_create_ip" => $_SERVER ['REMOTE_ADDR'],
		// "total_fee" => $totalFee,
		// "trade_type" => "JSAPI"
		// );
		$data = self::arrayToXml ( $tempData );
		
		$curlResult = self::curlConnectionDe ( $tokenUrl, $data );
		
		$arrData = XmlData::XmlToArray ( $curlResult );
		file_put_contents ( LOGDIR . "/set.result.wechat.pay.debug" . date ( 'Y-m-d', time () ) . ".log", var_export ( $arrData, true ) . "\n-------------------------\n", FILE_APPEND );
		
		return $arrData;
	}

	public static function arrayToXml($arrayData = array()) {
		$xmlDataString = '<xml>';
		foreach ( $arrayData as $index => $value ) {
			if (is_numeric ( $value )) {
				$xmlDataString .= '<' . $index . '>' . $value . '</' . $index . '>';
			} else {
				$xmlDataString .= '<' . $index . "><![CDATA[" . $value . "]]></" . $index . '>';
			}
		}
		$xmlDataString .= '</xml>';
		
		return $xmlDataString;
	}

	/**
	 * 获取签名字符
	 *
	 * @param array $signData        	
	 * @param string $signType        	
	 * @param array $signAttach        	
	 * @return string
	 */
	public static function getSignature($signData = array(), $signType = 'md5', $signAttach = array()) {
		ksort ( $signData, SORT_STRING );
		if ($signAttach && is_array ( $signAttach )) {
			$signData = array_merge ( $signData, $signAttach );
		}
		foreach ( $signData as $index => $value ) {
			if (is_numeric ( $index ) || empty ( $value )) {
				unset ( $signData [$index] );
				continue;
			}
			$signData [$index] = $index . '=' . strval ( $value );
		}
		$signDataStr = implode ( '&', $signData );
		if (in_array ( $signType, array (
				'md5',
				'sha1' 
		) )) {
			return strtoupper ( $signType ( $signDataStr ) );
		}
		
		return $signDataStr;
	}
}