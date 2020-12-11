<?php

class Business_Webpage_Desk extends Data_Explain {

	/**
	 * 验证
	 *
	 * @param unknown $storeName        	
	 * @param unknown $userName        	
	 * @return boolean
	 */
	public function checkAddDesk($storeId, $title) {
		if (isset ( $storeId ) && isset ( $title )) {
			$re1 = Business_Check_Desk::CheckStoreDeskTitle ( $storeId, $title );

			$data = array (
					'deskTitleExists' => $re1
			);
			$this->SetData ( $data );
			if (! $re1) {
				return false;
			}
		}
		return true;
	}

	public function AddDesk($storeId, $title, $isEnabled) {
		$result = false;
		$resultCode = 0;
		if (isset ( $storeId ) && isset ( $title )) {
			if ($this->checkAddDesk ( $storeId, $title )) {
				$desk = new Business_Script_Desk ();
				$store = new Business_User_Store ( $storeId );
				
				$createDesk = $desk->CreateDesk ( $store, $title, $isEnabled );
				
				if ($createDesk != null) {
					
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

	public function EditDesk($deskId, $title, $isEnabled) {
		$result = false;
		$resultCode = 0;
		if (isset ( $deskId )) {
			$desk = new Business_Script_Desk ( $deskId );
			$storeId = $desk->GetStore ()->GetId ();
			
			if (! $this->checkEditDesk ( $deskId, $storeId, $title )) {
				$resultCode = Business_Webpage_Message::CHECK_ERROR;
			}
			
			if ($resultCode == 0) {
				$title = isset ( $title ) ? $title : $desk->GetTitle ();
				$isEnabled = isset ( $isEnabled ) ? $isEnabled : $desk->GetIsEnabled ();
				
				$desk->SetTitle ( $title );
				$desk->SetIsEnabled ( $isEnabled );
				$desk->Save ();
				
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
	 * 验证
	 *
	 * @param number $storeId        	
	 * @param string $storeName        	
	 * @return boolean
	 */
	private function checkEditDesk($deskId, $storeId, $title) {
		if (isset ( $storeName )) {
			$re1 = Business_Check_Desk::CheckStoreDeskTitleOnly ( $deskId, $storeId, $title );
			
			$data = array (
					'deskTitleExists' => $re1 
			);
			$this->SetData ( $data );
			if (! $re1) {
				return false;
			}
		}
		return true;
	}
}