<?php

/**
 * 产品信息表
 * @author xy
 *
 */
class Object_Product_Base extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 名称
	 *
	 * @var string
	 */
	private $title = '';

	/**
	 * 获取名称
	 *
	 * @return string
	 */
	public function GetTitle() {
		return $this->title;
	}

	/**
	 * 设置名称
	 *
	 * @param string $title        	
	 */
	public function SetTitle($title) {
		if ($this->title != $title) {
			$this->title = $title;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 类别对象
	 *
	 * @var Object_Product_Category
	 */
	private $category = null;

	/**
	 * 获取类别对象
	 *
	 * @return Object_Product_Category NULL
	 */
	public function GetCategory() {
		$category = new Object_Product_Category ( $this->category );
		if ($category->GetId () > 0) {
			return $category;
		} else {
			return null;
		}
	}

	/**
	 * 设置类别对象
	 *
	 * @param Object_Product_Category $category        	
	 * @throws Exception
	 */
	public function SetCategory(Object_Product_Category $category) {
		if (! is_null ( $category )) {
			if (! is_null ( $this->category )) {
				if ($this->category != $category->GetId ()) {
					$this->category = $category->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->category = $category->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "category OBJECT IS NULL" );
		}
	}
	
	/**
	 * 成本价
	 *
	 * @var decimal(10,2)
	 */
	private $costPrice = 0.00;

	/**
	 * 获取成本价
	 *
	 * @return decimal(10,2)
	 */
	public function GetCostPrice() {
		return sprintf ( "%.2f", $this->costPrice );
	}

	/**
	 * 设置成本价
	 *
	 * @param decimal(10,2) $costPrice        	
	 */
	public function SetCostPrice($costPrice) {
		if ($this->costPrice != sprintf ( "%.2f", $costPrice )) {
			$this->costPrice = sprintf ( "%.2f", $costPrice );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 零售价
	 *
	 * @var DECIMAL(10,2)
	 */
	private $salePrice = 0.00;

	/**
	 * 获取零售价
	 *
	 * @return DECIMAL(10,2)
	 */
	public function GetSalePrice() {
		return sprintf ( "%.2f", $this->salePrice );
	}

	/**
	 * 设置零售价
	 *
	 * @param DECIMAL(10,2) $salePrice        	
	 */
	public function SetSalePrice($salePrice) {
		if ($this->salePrice != sprintf ( "%.2f", $salePrice )) {
			$this->salePrice = sprintf ( "%.2f", $salePrice );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 产品计量单位
	 *
	 * @var string
	 */
	private $units = "";

	/**
	 * 获取计量单位
	 *
	 * @return string
	 */
	public function GetUnits() {
		return urldecode ( $this->units );
	}

	/**
	 * 设置计量单位
	 *
	 * @param string $units        	
	 */
	public function SetUnits($units) {
		if ($this->units != urlencode ( $units )) {
			$this->units = urlencode ( $units );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 产品是否可用
	 *
	 * @var number
	 */
	private $isEnabled = 0;

	/**
	 * 获取产品是否可用
	 *
	 * @return number
	 */
	public function GetIsEnabled() {
		return (int) $this->isEnabled;
	}

	/**
	 * 设置产品是否可用
	 *
	 * @param number $isEnabled        	
	 */
	public function SetIsEnabled($isEnabled) {
		if ($this->isEnabled != $isEnabled) {
			$this->isEnabled = $isEnabled;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 类型
	 *
	 * @var number
	 */
	private $type = 0;

	/**
	 * 获取类型
	 *
	 * @return number
	 */
	public function GetType() {
		return (int) $this->type;
	}

	/**
	 * 设置类型
	 *
	 * @param number $type        	
	 */
	public function SetType($type) {
		if ($this->type != $type) {
			$this->type = $type;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 所需积分
	 * 
	 * @var number
	 */
	private $integral = 0;

	/**
	 * 获取所需积分
	 *
	 * @return number
	 */
	public function GetIntegral() {
		return (int) $this->integral;
	}

	/**
	 * 设置所需积分
	 *
	 * @param number $integral        	
	 */
	public function SetIntegral($integral) {
		if ($this->integral != $integral) {
			$this->integral = $integral;
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_401" );
		$this->setMemcacheId ( PROJECT . "_401" );
		$this->setZendCacheId ( PROJECT . "_401" );
		$this->setZendCacheDir ( "/A4/401" );
		$this->setCacheType ( 3 );
		
		parent::__construct ( $id );
		
		try {
			$data = $this->GetInstance ( false );
			$this->SetObjectProperty ( $data );
			$this->isValueChanged = false;
		} catch ( Exception $ex ) {
			$data = $this->GetInstance ( true );
			$this->SetObjectProperty ( $data );
			$this->isValueChanged = false;
		}
	}

	/**
	 * 设定对象相关属性
	 */
	private function SetObjectProperty($data) {
		if ($data != null) {
			$this->SetId ( $data ['ID'] );
			$this->SetTitle ( $data ['F1_A401'] );
			$this->category = $data ['F2_A401'];
			$this->SetCostPrice ( $data ['F3_A401'] );
			$this->SetSalePrice ( $data ['F4_A401'] );
			$this->SetUnits ( $data ['F5_A401'] );
			$this->SetIsEnabled ( $data ['F6_A401'] );
			$this->SetType ( $data ['F7_A401'] );
			$this->SetIntegral ( $data ['F8_A401'] );
			$this->SetOtime ( $data ['OTIME'] );
		} else {
			$this->SetId ( 0 );
		}
		$this->isValueChanged = false;
	}

	/**
	 * 保存
	 *
	 * @see Interface_IData::Save()
	 */
	public function Save() {
		if (! $this->isValueChanged)
			return;
		$data = array (
				'F1_A401' => $this->GetTitle (),
				'F2_A401' => $this->category,
				'F3_A401' => $this->GetCostPrice (),
				'F4_A401' => $this->GetSalePrice (),
				'F5_A401' => $this->GetUnits (),
				'F6_A401' => $this->GetIsEnabled (),
				'F7_A401' => $this->GetType (),
				'F8_A401' => $this->GetIntegral () 
		);
		$this->SafeParam ( $data );
		$this->table->setTable ( $this->getTableName () );
		if ($this->GetId () > 0) {
			$where = $this->db->quoteInto ( ' ID= ? ', $this->GetId () );
			$this->table->update ( $data, $where );
		} else {
			$data ['OTIME'] = date ( 'Y-m-d H:i:s' );
			$this->SetId ( $this->table->insert ( $data ) );
		}
		parent::Save ();
		$this->isValueChanged = false;
	}

	/**
	 * 删除
	 *
	 * @see Data_Object::Destroy()
	 */
	public function Destroy() {
		$this->table->setTable ( $this->getTableName () );
		$where = $this->db->quoteInto ( ' ID= ? ', $this->GetId () );
		$this->table->delete ( $where );
		parent::Destroy ();
	}
}