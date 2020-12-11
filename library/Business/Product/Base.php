<?php
class Business_Product_Base extends Object_Product_Base{
	
	public function CreateProduct(){
		if($this->GetId() == 0){
			
			return $this;
		}
		return null;
	}
}