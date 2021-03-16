<?php

/**
 * 剧本信息表
 * @author xy
 *
 */
class Object_Script_Base extends Data_Object {
	
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
	 * 门店对象
	 *
	 * @var Object_User_Store
	 */
	private $store = null;

	/**
	 * 获取门店对象
	 *
	 * @return Object_User_Store NULL
	 */
	public function GetStore() {
		$store = new Object_User_Store ( $this->store );
		if ($store->GetId () > 0) {
			return $store;
		} else {
			return null;
		}
	}

	/**
	 * 设置门店对象
	 *
	 * @param Object_User_Store $store        	
	 * @throws Exception
	 */
	public function SetStore(Object_User_Store $store) {
		if (! is_null ( $store )) {
			if (! is_null ( $this->store )) {
				if ($this->store != $store->GetId ()) {
					$this->store = $store->GetId ();
					$this->isValueChanged = true;
				}
			} else {
				$this->store = $store->GetId ();
				$this->isValueChanged = true;
			}
		} else {
			throw new Exception ( "store OBJECT IS NULL" );
		}
	}
	
	/**
	 * 类型
	 *
	 * @var string
	 */
	private $type = "";

	/**
	 * 获取类型
	 *
	 * @return string
	 */
	public function GetType() {
		return $this->type;
	}

	/**
	 * 设置类型
	 *
	 * @param string $type        	
	 */
	public function SetType($type) {
		if ($this->type != $type) {
			$this->type = $type;
			$this->isValueChanged = true;
		}
	}
	private $amount = 0;

	/**
	 * 获取数量
	 *
	 * @return number
	 */
	public function GetAmount() {
		return (int) $this->amount;
	}

	/**
	 * 设置数量
	 *
	 * @param number $amount        	
	 */
	public function SetAmount($amount) {
		if ($this->amount != $amount) {
			$this->amount = $amount;
			$this->isValueChanged = true;
		}
	}
	private $image = "";

	/**
	 * 获取图片地址
	 *
	 * @return string
	 */
	public function GetImage() {
		return $this->image;
	}

	/**
	 * 设置图片地址
	 *
	 * @param string $image        	
	 */
	public function SetImage($image) {
		if ($this->image != $image) {
			$this->image = $image;
			$this->isValueChanged = true;
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
	 * 开本价
	 *
	 * @var decimal(10,2)
	 */
	private $formatPrice = 0.00;

	/**
	 * 获取开本价
	 *
	 * @return decimal(10,2)
	 */
	public function GetFormatPrice() {
		return sprintf ( "%.2f", $this->formatPrice );
	}

	/**
	 * 设置开本价
	 *
	 * @param decimal(10,2) $formatPrice        	
	 */
	public function SetFormatPrice($formatPrice) {
		if ($this->formatPrice != sprintf ( "%.2f", $formatPrice )) {
			$this->formatPrice = sprintf ( "%.2f", $formatPrice );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 描述
	 * @var string
	 */
	private $description = "";

	/**
	 * 获取描述
	 *
	 * @return string
	 */
	public function GetDescription() {
		return $this->description;
	}

	/**
	 * 设置描述
	 *
	 * @param string $description        	
	 */
	public function SetDescription($description) {
		if ($this->description != $description) {
			$this->description = $description;
			$this->isValueChanged = true;
		}
	}
	private $applicableNumber = "";

	/**
	 * 获取适用人数
	 *
	 * @return string
	 */
	public function GetApplicableNumber() {
		return $this->applicableNumber;
	}

	/**
	 * 设置适用人数
	 *
	 * @param string $applicableNumber        	
	 */
	public function SetApplicableNumber($applicableNumber) {
		if ($this->applicableNumber != $applicableNumber) {
			$this->applicableNumber = $applicableNumber;
			$this->isValueChanged = true;
		}
	}
	private $gameTime = 0;

	/**
	 * 获取推荐游戏时间
	 *
	 * @return string
	 */
	public function GetGameTime() {
		return (int) $this->gameTime;
	}

	/**
	 * 设置推荐游戏时间
	 *
	 * @param string $gameTime        	
	 */
	public function SetGameTime($gameTime) {
		if ($this->gameTime != $gameTime) {
			$this->gameTime = $gameTime;
			$this->isValueChanged = true;
		}
	}
	private $isAdapt = 0;

	/**
	 * 获取是否改编
	 *
	 * @return number
	 */
	public function GetIsAdapt() {
		return (int) $this->isAdapt;
	}

	/**
	 * 设置是否改编
	 *
	 * @param number $isAdapt        	
	 */
	public function SetIsAdapt($isAdapt) {
		if ($this->isAdapt != $isAdapt) {
			$this->isAdapt = $isAdapt;
			$this->isValueChanged = true;
		}
	}
	private $adaptContent = "";

	/**
	 * 获取改编内容
	 *
	 * @return string
	 */
	public function GetAdaptContent() {
		return $this->adaptContent;
	}

	/**
	 * 设置改编内容
	 *
	 * @param string $adaptContent        	
	 */
	public function SetAdaptContent($adaptContent) {
		if ($this->adaptContent != $adaptContent) {
			$this->adaptContent = $adaptContent;
			$this->isValueChanged = true;
		}
	}
	private $content = "";

	/**
	 * 获取改编内容
	 *
	 * @return string
	 */
	public function GetContent() {
		return $this->content;
	}

	/**
	 * 设置改编内容
	 *
	 * @param string $content        	
	 */
	public function SetContent($content) {
		if ($this->content != $content) {
			$this->content = $content;
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_301" );
		$this->setMemcacheId ( PROJECT . "_301" );
		$this->setZendCacheId ( PROJECT . "_301" );
		$this->setZendCacheDir ( "/A3/301" );
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
			$this->SetTitle ( $data ['F1_A301'] );
			$this->store = $data ['F2_A301'];
			$this->SetType ( $data ['F3_A301'] );
			$this->SetAmount ( $data ['F4_A301'] );
			$this->SetImage ( $data ['F5_A301'] );
			$this->SetCostPrice ( $data ['F6_A301'] );
			$this->SetFormatPrice ( $data ['F7_A301'] );
			$this->SetDescription ( $data ['F8_A301'] );
			$this->SetApplicableNumber ( $data ['F9_A301'] );
			$this->SetGameTime ( $data ['F10_A301'] );
			$this->SetIsAdapt ( $data ['F11_A301'] );
			$this->SetAdaptContent ( $data ['F12_A301'] );
			$this->SetContent ( $data ['F13_A301'] );
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
				'F1_A301' => $this->GetTitle (),
				'F2_A301' => $this->store,
				'F3_A301' => $this->GetType (),
				'F4_A301' => $this->GetAmount (),
				'F5_A301' => $this->GetImage (),
				'F6_A301' => $this->GetCostPrice (),
				'F7_A301' => $this->GetFormatPrice (),
				'F8_A301' => $this->GetDescription (),
				'F9_A301' => $this->GetApplicableNumber (),
				'F10_A301' => $this->GetGameTime (),
				'F11_A301' => $this->GetIsAdapt (),
				'F12_A301' => $this->GetAdaptContent (),
				'F13_A301' => $this->GetContent () 
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