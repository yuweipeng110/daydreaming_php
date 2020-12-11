<?php

class Business_Webpage_Script extends Data_Explain {

	/**
	 * 添加剧本
	 *
	 * @param string $title        	
	 * @param number $storeId        	
	 * @param string $type        	
	 * @param string $amount        	
	 * @param decimal(10,2) $costPrice        	
	 * @param decimal(10,2) $formatPrice        	
	 * @param string $description        	
	 * @param string $applicableNumber        	
	 * @param string $gameTime        	
	 * @param number $isAdapt        	
	 * @param string $adaptContent        	
	 * @return boolean
	 */
	public function AddScript($title, $storeId, $type, $amount, $costPrice, $formatPrice, $description, $applicableNumber, $gameTime, $isAdapt, $adaptContent) {
		$result = false;
		$resultCode = 0;
		if (isset ( $title ) && isset ( $storeId )) {
			if ($this->checkAddScript ( $title )) {
				$script = new Business_Script_Base ();
				$store = new Business_User_Store ( $storeId );
				
				$createScript = $script->CreateScript ( $title, $store, $type, $amount, $costPrice, $formatPrice, $description, $applicableNumber, $gameTime, $isAdapt, $adaptContent );
				
				if ($createScript != null) {
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

	private function checkAddScript($title) {
		return true;
	}

	/**
	 * 修改劇本
	 *
	 * @param unknown $scriptId        	
	 * @param unknown $title        	
	 * @param unknown $type        	
	 * @param unknown $amount        	
	 * @param unknown $costPrice        	
	 * @param unknown $description        	
	 * @param unknown $applicableNumber        	
	 * @param unknown $gameTime        	
	 * @param unknown $isAdapt        	
	 * @param unknown $adaptContent        	
	 * @return boolean
	 */
	public function EditScript($scriptId, $title, $type, $amount, $costPrice, $description, $applicableNumber, $gameTime, $isAdapt, $adaptContent) {
		$result = false;
		$resultCode = 0;
		if (isset ( $scriptId )) {
			$script = new Business_Script_Base ( $scriptId );
			
			if ($resultCode == 0) {
				$costPrice = isset ( $costPrice ) ? $costPrice : $script->GetCostPrice ();
				
				$script->SetTitle ( $title );
				$script->SetType ( $type );
				$script->SetAmount ( $amount );
				$script->SetCostPrice ( $costPrice );
				$script->SetDescription ( $description );
				$script->SetApplicableNumber ( $applicableNumber );
				$script->SetGameTime ( $gameTime );
				$script->SetIsAdapt ( $isAdapt );
				$script->SetAdaptContent ( $adaptContent );
				$script->Save ();
				
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
}