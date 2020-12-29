<?php

/**
 * 活动信息表
 * @author xy
 *
 */
class Object_Promotions_Base extends Data_Object {
	
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
	 * 开始时间
	 *
	 * @var DateTime
	 */
	private $startTime = '0000-00-00 00:00:00';

	/**
	 * 获取开始时间
	 *
	 * @return DateTime
	 */
	public function GetStartTime() {
		return $this->startTime;
	}

	/**
	 * 设置开始时间
	 *
	 * @param DateTime $startTime        	
	 */
	public function SetStartTime($startTime) {
		if ($this->startTime != $startTime) {
			$this->startTime = $startTime;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 结束时间
	 *
	 * @var DateTime
	 */
	private $endTime = '0000-00-00 00:00:00';

	/**
	 * 获取结束时间
	 *
	 * @return DateTime
	 */
	public function GetEndTime() {
		return $this->endTime;
	}

	/**
	 * 设置结束时间
	 *
	 * @param DateTime $endTime        	
	 */
	public function SetEndTime($endTime) {
		if ($this->endTime != $endTime) {
			$this->endTime = $endTime;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 充值金额
	 *
	 * @var DECIMAL(10,2)
	 */
	private $rechargeMoney = 0.00;

	/**
	 * 获取充值金额
	 *
	 * @return decimal(10,2)
	 */
	public function GetRechargeMoney() {
		return $this->rechargeMoney;
	}

	/**
	 * 设置充值金额
	 *
	 * @param decimal(10,2) $rechargeMoney        	
	 */
	public function SetRechargeMoney($rechargeMoney) {
		if ($this->rechargeMoney != sprintf ( "%.2f", $rechargeMoney )) {
			$this->rechargeMoney = sprintf ( "%.2f", $rechargeMoney );
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 抵用卷金额
	 *
	 * @var DECIMAL(10,2)
	 */
	private $voucherMoney = 0.00;

	/**
	 * 获取抵用卷金额
	 *
	 * @return decimal(10,2)
	 */
	public function GetVoucherMoney() {
		return $this->voucherMoney;
	}

	/**
	 * 设置抵用卷金额
	 *
	 * @param decimal(10,2) $voucherMoney        	
	 */
	public function SetVoucherMoney($voucherMoney) {
		if ($this->voucherMoney != sprintf ( "%.2f", $voucherMoney )) {
			$this->voucherMoney = sprintf ( "%.2f", $voucherMoney );
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_601" );
		$this->setMemcacheId ( PROJECT . "_601" );
		$this->setZendCacheId ( PROJECT . "_601" );
		$this->setZendCacheDir ( "/A3/601" );
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
			$this->SetTitle ( $data ['F1_A601'] );
			$this->SetStartTime ( $data ['F2_A601'] );
			$this->SetEndTime ( $data ['F3_A601'] );
			$this->SetRechargeMoney ( $data ['F4_A601'] );
			$this->SetVoucherMoney ( $data ['F5_A601'] );
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
				'F1_A601' => $this->GetTitle (),
				'F2_A601' => $this->GetStartTime (),
				'F3_A601' => $this->GetEndTime (),
				'F4_A601' => $this->GetRechargeMoney (),
				'F5_A601' => $this->GetVoucherMoney () 
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