<?php

class Business_Webpage_User extends Data_Explain {

	/**
	 * 添加玩家
	 *
	 * @return boolean
	 */
	public function AddPlayer($storeId, $nickname, $sex, $phone, $remark) {
		$result = false;
		$resultCode = 0;
		if (isset ( $storeId ) && isset ( $nickname ) && isset ( $phone )) {
			if ($this->checkPlayerPhone ( $phone )) {
				$player = new Business_User_Player_Base ();
				$store = new Business_User_Store ( $storeId );
				
// 				$createPlayer = true;
				$createPlayer = $player->CreatePlayer ( $store, $nickname, $sex, $phone, $remark );
				
				if ($createPlayer != null) {
					
					$resultCode = Business_Webpage_Message::SUCCESS;
					$result = true;
				} else {
					$resultCode = Business_Webpage_Message::LOGIC_ERROR;
				}
			} else {
				$resultCode = Business_Webpage_Message::CHECK_ERROR;
			}
		} else {
			$resultCode = Business_Webpage_Message::PARAMETER_ERROR;
		}
		$resultMessage = Business_Webpage_Message::getMessage ( $resultCode );
		
		$this->SetCode ( $resultCode );
		$this->SetMessage ( $resultMessage );
		
		return $result;
	}

	private function checkPlayerPhone($phone) {
		if (isset ( $phone )) {
			$re1 = Business_Check_User::CheckPhone ( $phone );
			
			$data = array (
					'phoneExists' => $re1 
			);
			$this->SetData ( $data );
			if (! $re1) {
				return false;
			}
		}
		return true;
	}

	public function EditPlayer($playerId, $nickname, $sex, $phone, $remark) {
		$result = false;
		$resultCode = 0;
		if (isset ( $playerId )) {
			$player = new Business_User_Player_Base ( $playerId );
			if ($phone != $player->GetPhone ()) {
				if (! $this->checkPlayerPhone ( $phone )) {
					$resultCode = Business_Webpage_Message::CHECK_ERROR;
				}
			}
			
			if ($resultCode == 0) {
				$nickname = isset ( $nickname ) ? $nickname : $player->GetNickname ();
				$sex = isset ( $sex ) ? $sex : $player->GetSex ();
				$phone = isset ( $phone ) ? $phone : $player->GetPhone ();
				$remark = isset ( $remark ) ? $remark : $player->GetRemark ();
				
				$player->SetNickname ( $nickname );
				$player->SetSex ( $sex );
				$player->SetPhone ( $phone );
				$player->SetRemark ( $remark );
				$player->Save ();
				
				$resultCode = Business_Webpage_Message::SUCCESS;
				$result = true;
			}
		} else {
			$resultCode = Business_Webpage_Message::PARAMETER_ERROR;
		}
		$resultMessage = Business_Webpage_Message::getMessage ( $resultCode );
		
		$this->SetCode ( $resultCode );
		$this->SetMessage ( $resultMessage );
		return $result;
	}

	/**
	 * 账户充值
	 * 
	 * @param number $userId
	 *        	用户ID
	 * @param decimal(10,2) $rechargeAmount
	 *        	充值金额
	 * @return boolean
	 */
	public function AccountRecharge($userId, $rechargeAmount) {
		$result = false;
		$resultCode = 0;
		if (isset ( $userId ) && isset ( $rechargeAmount )) {
			$user = new Business_User_Base ( $userId );
			
			$changeMoney = $rechargeAmount;
			$changeMode = new Business_Enum_Money ( 'MANUAL_IN' );
			$changeType = 1;
			$result = $user->AddMoney ( $changeMoney, $changeMode, $changeType );
			
			if ($result != null) {
				
				$resultCode = Business_Webpage_Message::SUCCESS;
				$result = true;
			} else {
				$resultCode = Business_Webpage_Message::LOGIC_ERROR;
			}
		} else {
			$resultCode = Business_Webpage_Message::PARAMETER_ERROR;
		}
		$resultMessage = Business_Webpage_Message::getMessage ( $resultCode );
		
		$this->SetCode ( $resultCode );
		$this->SetMessage ( $resultMessage );
		return $result;
	}
}