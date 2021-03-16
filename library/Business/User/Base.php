<?php

class Business_User_Base extends Object_User_Base {

	public function __construct($id = 0) {
		parent::__construct ( $id );
		
		$userIntegralRanking = $this->getUserIntegralRanking ();
		$userIntegralRanking = $userIntegralRanking [0];
		$this->killerRanking = $userIntegralRanking ['KILLER_RANKING'];
		$this->killerIntegral = $userIntegralRanking ['KILLER_INTEGRAL'];
		$this->detectiveRanking = $userIntegralRanking ['DETECTIVE_RANKING'];
		$this->detectiveIntegral = $userIntegralRanking ['DETECTIVE_INTEGRAL'];
		$this->popleRanking = $userIntegralRanking ['PEOPLE_RANKING'];
		$this->popleIntegral = $userIntegralRanking ['PEOPLE_INTEGRAL'];
		$this->totalRanking = $userIntegralRanking ['TOTAL_RANKING'];
		$this->totalIntegral = $userIntegralRanking ['TOTAL_INTEGRAL'];
	}

	private function getUserIntegralRanking() {
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		
		$sql = "CALL V_USER_INTEGRAL_RANKING (" . $this->GetId () . ");";
		$query = $db->query ( $sql );
		$data = array ();
		do {
			$rowset = $query->fetchAll ();
			if ($rowset) {
				$data [] = $rowset;
			}
		} while ( $query->nextRowset () );
		if (count ( $data ) > 0) {
			return $data [count ( $data ) - 1];
		} else {
			return array (
					'KILLER_RANKING' => 0,
					'KILLER_INTEGRAL' => 0,
					'DETECTIVE_RANKING' => 0,
					'DETECTIVE_INTEGRAL' => 0,
					'PEOPLE_RANKING' => 0,
					'PEOPLE_INTEGRAL' => 0,
					'TOTAL_RANKING' => 0,
					'TOTAL_INTEGRAL' => 0 
			);
		}
	}

	/**
	 * 添加系统用户
	 *
	 * @param string $userName        	
	 * @param string $password        	
	 * @return System_Admin_User
	 */
	protected function addSystemUser($userName, $password) {
		$systemUser = new System_Admin_User ();
		$systemUser->SetUserName ( $userName );
		$systemUser->SetPassword ( $password );
		$systemUser->Save ();
		
		return $systemUser;
	}

	/**
	 * 添加系统导航 admin使用
	 *
	 * @param string $title        	
	 * @param string $url        	
	 * @param number $parentId        	
	 * @return boolean
	 */
	protected function addSystemMenu($title, $url, $parentId = 0) {
		if ($this->GetId () > 0 && $this->GetSystemUser ()->GetId () == 1) {
			// $systemUser = $this->GetSystemUser ();
			$menu = new System_Admin_Menu ();
			$newParent = new System_Admin_Menu ( $parentId );
			$menu->SetParentMenu ( $newParent );
			$menu->SetTitle ( $title );
			$menu->SetUrl ( $url );
			$menu->Save ();
			
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 更新系统导航 admin使用
	 *
	 * @param number $menuId        	
	 * @param string $title        	
	 * @param string $url        	
	 * @param number $parentId        	
	 * @return boolean
	 */
	protected function editSystemMenu($menuId, $title, $url, $parentId = 0) {
		if ($this->GetId () > 0 && $this->GetSystemUser ()->GetId () == 1) {
			$menu = new System_Admin_Menu ( $menuId );
			$newParent = new System_Admin_Menu ( $parentId );
			$menu->SetParentMenu ( $newParent );
			$menu->SetTitle ( $title );
			$menu->SetUrl ( $url );
			$menu->Save ();
			
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 获取系统导航
	 *
	 * @return array
	 */
	protected function getSystemMenuList() {
		$selfMenu = array ();
		$user = $this->GetSystemUser ();
		if ($this->GetId () > 0 && $user != null) {
			$groupCongregation = new System_Admin_Congregation ( $user );
			foreach ( $groupCongregation->GetItems () as $valueCongregation ) {
				$groupRelation = new System_Admin_Purview ( $valueCongregation->GetOrganize () );
				foreach ( $groupRelation->GetMenus () as $valueMenu ) {
					$selfMenu [] = Business_Tool_Func::getMenuField ( $valueMenu, $valueMenu->GetChildren () );
					// $selfMenu [] = $valueMenu->GetId ();
				}
			}
			
			$userRelation = new System_Admin_Relation ( $user );
			foreach ( $userRelation->GetMenus () as $valueMenu ) {
				$selfMenu [] = Business_Tool_Func::getMenuField ( $valueMenu, $valueMenu->GetChildren () );
			}
		}
		return $selfMenu;
	}

	public function GetIntegral() {
		if ($this->GetId () == 0) {
			return false;
		}
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$sql = "SELECT SUM(F2_A802) AS INTEGRAL FROM A_802 WHERE F1_A802 =  " . $this->GetId ();
		
		$result = $db->query ( $sql );
		$data = $result->fetchAll ();
		
		$integral = 0;
		if (count ( $data ) > 0) {
			$integral = $data [0] ['INTEGRAL'] == null ? 0 : $data [0] ['INTEGRAL'];
		}
		return $integral;
	}

	public function AddIntegral($changeIntegral, Business_Enum_Integral $changeMode, Business_User_Role $role) {
		if ($role->GetId () == 0) {
			return false;
		}
		if ($changeIntegral > $role->GetMaxAddIntegral ()) {
			return false;
		}
		$remarkIncrease = "";
		$remarkReduce = "";
		
		if (array_key_exists ( $changeMode->getValue (), Business_Enum_Integral::getDescriptionList () )) {
			$remarkIncrease = $changeMode->getValue ();
			$remarkReduce = $changeMode->getValue ();
		}
		
		if ($changeIntegral < 0) {
			$remarkIncrease = "";
		} else {
			$remarkReduce = "";
		}
		if ($this->GetIntegral () + $changeIntegral < 0) {
			return false;
		}
		
		$integral = new Business_Account_Integral ();
		$integralInstance = $integral->CreateIntegral ( $this, $changeIntegral, $remarkIncrease, $remarkReduce, $role );
		
		return $integralInstance == null ? false : true;
	}

	public function GetBalance() {
		if ($this->GetId () == 0) {
			return false;
		}
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$sql = "SELECT SUM(F2_A801) AS MONEY FROM A_801 WHERE F1_A801 = " . $this->GetId () . " AND F6_A801 = 1";
		
		$result = $db->query ( $sql );
		$data = $result->fetchAll ();
		
		$money = 0;
		if (count ( $data ) > 0) {
			$money = $data [0] ['MONEY'] == null ? 0 : $data [0] ['MONEY'];
		}
		return sprintf ( "%.2f", $money );
	}

	public function GetVoucherBalance() {
		if ($this->GetId () == 0) {
			return false;
		}
		$table = new Custom_Adapter ();
		$db = $table->getAdapter ();
		$sql = "SELECT SUM(F2_A801) AS MONEY FROM A_801 WHERE F1_A801 = " . $this->GetId () . " AND F6_A801 = 2";
		
		$result = $db->query ( $sql );
		$data = $result->fetchAll ();
		
		$money = 0;
		if (count ( $data ) > 0) {
			$money = $data [0] ['MONEY'] == null ? 0 : $data [0] ['MONEY'];
		}
		return sprintf ( "%.2f", $money );
	}

	public function AddMoney($changeMoney, Business_Enum_Money $changeMode, $changeType, Business_Option_PaymentMethod $paymentMethod = null, Business_Promotions_Base $promotions = null, Business_Script_Order $order = null) {
		if ($this->GetId () == 0) {
			return false;
		}
		$remarkIncrease = "";
		$remarkReduce = "";
		
		if (array_key_exists ( $changeMode->getValue (), Business_Enum_Money::getDescriptionList () )) {
			$remarkIncrease = $changeMode->getValue ();
			$remarkReduce = $changeMode->getValue ();
		}
		
		if ($changeMoney < 0) {
			$remarkIncrease = "";
		} else {
			$remarkReduce = "";
		}
		if ($this->GetBalance () + $this->GetVoucherBalance () + $changeMoney < 0) {
			return false;
		}
		$moneyInstance = null;
		
		// balance pay
		$voucherMoney = 0;
		if ($changeMoney < 0 && $this->GetBalance () + $changeMoney < 0) {
			$voucherMoney = $this->GetBalance () + $changeMoney;
			$balanceChangeMoney = $this->GetBalance () * - 1;
			$changeMoney = $balanceChangeMoney;
		}
		
		if ($changeMoney != 0) {
			// 账户流水
			$account = new Business_Account_Money ();
			$moneyInstance = $account->CreateMoney ( $this, $changeMoney, $remarkIncrease, $remarkReduce, $changeType, $paymentMethod, $promotions, $order );
			// 门店营收
			if($changeMode->getValue() == "MANUAL_IN"){
				$revenue = new Business_Account_Revenue ();
				$store = new Business_User_Store ( $this->GetStore ()->GetId () );
				$revenueChangeType = $order == null ? 1 : 2;
				$revenue->CreateRevenue ( $this, abs($changeMoney), $remarkIncrease, $remarkReduce, $revenueChangeType, $store,$order, $paymentMethod );
			}
		}
		
		// voucher pay
		if ($voucherMoney != 0 && $voucherMoney < 0) {
			$account = new Business_Account_Money ();
			$remarkIncrease = "";
			$remarkReduce = $changeMode->getValue ();
			$changeType = 2;
			$voucherPaymentMethod = new Business_Option_PaymentMethod ( 4 );
			
			$account->CreateMoney ( $this, $voucherMoney, $remarkIncrease, $remarkReduce, $changeType, $paymentMethod, $promotions, $order );
		}
		
		// 活动赠送虚拟钱币
		if ($changeMoney > 0) {
			$account->DetectPromotionsVoucherProcess ( $this, $changeMoney );
		}
		
		return $moneyInstance == null ? false : true;
	}
	private $killerRanking = 0;

	/**
	 * 获取杀手排名
	 *
	 * @return number
	 */
	public function GetKillerRanking() {
		return floor ( $this->killerRanking );
	}
	private $killerIntegral = 0;

	/**
	 * 获取杀手积分
	 *
	 * @return string
	 */
	public function GetKillerIntegral() {
		return floor ( $this->killerIntegral );
	}

	/**
	 * 获取杀手排名称号
	 *
	 * @return string
	 */
	public function GetKillerTitle() {
		$title = "";
		$roleId = 2;
		$rankList = Business_User_List::GetRankListByRole ( $roleId );
		
		foreach ( $rankList as $rankId ) {
			$rank = new Business_User_Rank ( $rankId );
			if ($rank->GetFullRanking () == 0 && $this->GetKillerIntegral () >= $rank->GetIntegral ()) {
				$title = $rank->GetTitle ();
			} else {
				break;
			}
			
			if ($this->GetKillerRanking () <= 3 && $this->GetKillerRanking () == $rank->GetFullRanking ()) {
				$title = $rank->GetTitle ();
				break;
			}
		}
		
		return $title;
	}
	private $detectiveRanking = 0;

	/**
	 * 获取侦探排名
	 *
	 * @return number
	 */
	public function GetDetectiveRanking() {
		return floor ( $this->detectiveRanking );
	}
	private $detectiveIntegral = 0;

	/**
	 * 获取侦探积分
	 *
	 * @return number
	 */
	public function GetDetectiveIntegral() {
		return floor ( $this->detectiveIntegral );
	}

	/**
	 * 获取侦探排名称号
	 *
	 * @return string
	 */
	public function GetDetectiveTitle() {
		$title = "";
		$roleId = 3;
		$rankList = Business_User_List::GetRankListByRole ( $roleId );
		
		foreach ( $rankList as $rankId ) {
			$rank = new Business_User_Rank ( $rankId );
			if ($rank->GetFullRanking () == 0 && $this->GetDetectiveIntegral () >= $rank->GetIntegral ()) {
				$title = $rank->GetTitle ();
			} else {
				break;
			}
			
			if ($this->GetDetectiveRanking () <= 3 && $this->GetDetectiveRanking () == $rank->GetFullRanking ()) {
				$title = $rank->GetTitle ();
				break;
			}
		}
		
		return $title;
	}
	private $popleRanking = 0;

	/**
	 * 获取路人排名
	 *
	 * @return number
	 */
	public function GetPeopleRanking() {
		return floor ( $this->popleRanking );
	}
	private $popleIntegral = 0;

	/**
	 * 获取路人积分
	 *
	 * @reutrn number
	 */
	public function GetPeopleIntegral() {
		return floor ( $this->popleIntegral );
	}

	/**
	 * 获取路人排名称号
	 *
	 * @return string
	 */
	public function GetPeopleTitle() {
		$title = "";
		$roleId = 4;
		$rankList = Business_User_List::GetRankListByRole ( $roleId );
		
		foreach ( $rankList as $rankId ) {
			$rank = new Business_User_Rank ( $rankId );
			if ($rank->GetFullRanking () == 0 && $this->GetPeopleIntegral () >= $rank->GetIntegral ()) {
				$title = $rank->GetTitle ();
			} else {
				break;
			}
			
			if ($this->GetPeopleRanking () <= 3 && $this->GetPeopleRanking () == $rank->GetFullRanking ()) {
				$title = $rank->GetTitle ();
				break;
			}
		}
		
		return $title;
	}
	private $totalRanking = 0;

	/**
	 * 获取总排名
	 *
	 * @return number
	 */
	public function GetTotalRanking() {
		return floor ( $this->totalRanking );
	}
	private $totalIntegral = 0;

	/**
	 * 获取总积分
	 *
	 * @return number
	 */
	public function GetTotalIntegral() {
		return floor ( $this->totalIntegral );
	}

	/**
	 * 获取总积分排名称号
	 *
	 * @return string
	 */
	public function GetTotalTitle() {
		$title = "";
		$roleId = 1;
		$rankList = Business_User_List::GetRankListByRole ( $roleId );
		
		foreach ( $rankList as $rankId ) {
			$rank = new Business_User_Rank ( $rankId );
			if ($rank->GetFullRanking () == 0 && $this->GetTotalIntegral () >= $rank->GetIntegral ()) {
				$title = $rank->GetTitle ();
			} else {
				break;
			}
			
			if ($this->GetTotalRanking () <= 3 && $this->GetTotalRanking () == $rank->GetFullRanking ()) {
				$title = $rank->GetTitle ();
				break;
			}
		}
		
		return $title;
	}

	/**
	 * 可用积分
	 *
	 * @return number
	 */
	public function GetActiveIntegral() {
		return 0;
	}
}