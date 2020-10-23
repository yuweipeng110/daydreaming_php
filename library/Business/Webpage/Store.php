<?php

class Business_Webpage_Store extends Data_Explain {

	/**
	 * 验证
	 *
	 * @param unknown $storeName        	
	 * @param unknown $userName        	
	 * @return boolean
	 */
	public function checkAddStore($storeName, $userName) {
		if (isset ( $storeName ) && isset ( $userName )) {
			$re1 = Business_Check_Store::CheckStoreName ( $storeName );
			$re2 = Business_Check_SystemUser::CheckSystemUserName ( $userName );
			
			$data = array (
					'storeNameExists' => $re1,
					'userNameExists' => $re2 
			);
			$this->SetData ( $data );
			if (! $re1 || ! $re2) {
				return false;
			}
		}
		return true;
	}

	/**
	 * 添加门店
	 *
	 * @param string $userName        	
	 * @param string $password        	
	 * @param string $storeName        	
	 * @param unknown $status        	
	 * @param string $phone        	
	 * @param string $address        	
	 * @return boolean
	 */
	public function AddStore($userName, $password, $realName, $storeName, $status, $phone, $address) {
		$result = false;
		$resultCode = 0;
		if (isset ( $userName ) && isset ( $password ) && isset ( $storeName ) && isset ( $status ) && isset ( $phone ) && isset ( $address )) {
			if ($this->checkAddStore ( $storeName, $userName )) {
				$store = new Business_User_Store ();
				$createStore = $store->CreateStore ( $storeName, $status, $phone, $address );
				
				$boss = new Business_User_Boss_Base ();
				$createBoss = $boss->CreateBoss ( $store, $userName, $password, $realName );
				if ($createStore != null && $createBoss != null) {
					// 设置店长
					$store->SetStoreBoss ( $createBoss );
					
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

	/**
	 * 验证
	 * @param number $storeId
	 * @param string $storeName
	 * @return boolean
	 */
	private function checkEditStore($storeId,$storeName) {
		if (isset ( $storeName )) {
			$re1 = Business_Check_Store::CheckStoreNameOnly ($storeId, $storeName );
			
			$data = array (
					'storeNameExists' => $re1 
			);
			$this->SetData ( $data );
			if (! $re1) {
				return false;
			}
		}
		return true;
	}

	/**
	 * 修改门店
	 *
	 * @param string $storeId        	
	 * @param string $storeName        	
	 * @param boolean $status        	
	 * @param string $address        	
	 * @return boolean
	 */
	public function EditStore($storeId, $storeName, $status, $address) {
		$result = false;
		$resultCode = 0;
		if (isset ( $storeId )) {
			$store = new Business_User_Store ( $storeId );
			if ($this->checkEditStore ($storeId, $storeName )) {
				$storeName = isset ( $storeName ) ? $storeName : $store->GetName ();
				
				$store->SetName ( $storeName );
			} else {
				$resultCode = Business_Webpage_Message::CHECK_ERROR;
			}
			
			if ($resultCode == 0) {
				$status = isset ( $status ) ? $status : $store->GetStatus ();
				$address = isset ( $address ) ? $address : $store->GetAddress ();
				
				$store->SetStatus ( $status );
				$store->SetAddress ( $address );
				$store->Save ();
				
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