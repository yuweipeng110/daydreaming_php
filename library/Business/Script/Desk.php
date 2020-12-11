<?php

class Business_Script_Desk extends Object_Script_Desk {

	public function CreateDesk(Business_User_Store $store, $title, $isEnabled) {
		if ($this->GetId () == 0) {
			if (! is_null ( $store )) {
				$this->SetTitle ( $title );
				$this->SetIsEnabled ( $isEnabled );
				$this->SetStore ( $store );
				$this->Save();
				
				return $this;
			}
		}
		return null;
	}
}