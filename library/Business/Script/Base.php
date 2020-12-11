<?php

class Business_Script_Base extends Object_Script_Base {

	public function CreateScript($title, Business_User_Store $store, $type, $amount, $costPrice, $formatPrice, $description, $applicableNumber, $gameTime, $isAdapt, $adaptContent) {
		if ($this->GetId () == 0) {
			$this->SetTitle ( $title );
			$this->SetStore ( $store );
			$this->SetType ( $type );
			$this->SetAmount ( $amount );
			$this->SetCostPrice ( $costPrice );
			$this->SetFormatPrice ( $formatPrice );
			$this->SetDescription ( $description );
			$this->SetApplicableNumber ( $applicableNumber );
			$this->SetGameTime ( $gameTime );
			$this->SetIsAdapt ( $isAdapt );
			$this->SetAdaptContent ( $adaptContent );
			$this->Save ();
			
			return $this;
		}
		return null;
	}
}