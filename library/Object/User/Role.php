<?php

/**
 * 段位类型枚举表
 * @author xy
 *
 */
class Object_User_Role extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 名稱
	 *
	 * @var string
	 */
	private $title = "";

	/**
	 * 获取名稱
	 *
	 * @return string
	 */
	public function GetTitle() {
		return $this->title;
	}

	/**
	 * 设置名稱
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
	 * 最大增加积分
	 *
	 * @var number
	 */
	private $maxAddIntegral = 0;

	/**
	 * 获取最大增加积分
	 *
	 * @return number
	 */
	public function GetMaxAddIntegral() {
		return (int) $this->maxAddIntegral;
	}

	/**
	 * 设置最大增加积分
	 *
	 * @param number $maxAddIntegral        	
	 */
	public function SetMaxAddIntegral($maxAddIntegral) {
		if ($this->maxAddIntegral != $maxAddIntegral) {
			$this->maxAddIntegral = $maxAddIntegral;
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param string $guid        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_210" );
		$this->setMemcacheId ( PROJECT . "_210" );
		$this->setZendCacheId ( PROJECT . "_210" );
		$this->setZendCacheDir ( "/A2/210" );
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
			$this->SetTitle ( $data ['F1_A210'] );
			$this->SetMaxAddIntegral ( $data ['F2_A210'] );
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
				'F1_A210' => $this->GetTitle (),
				'F2_A210' => $this->GetMaxAddIntegral () 
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