<?php
/**
 * 日期序列
 * 
 * @author Finder
 */
class System_Admin_Date extends Data_Object {
	
	/**
	 * 属性是否发生更改
	 *
	 * @var boolean
	 */
	private $isValueChanged = false;
	
	/**
	 * 日期
	 *
	 * @var string
	 */
	private $date = '';

	/**
	 * 获取日期
	 *
	 * @return string
	 */
	public function GetDate() {
		return $this->date;
	}

	/**
	 * 设置日期
	 *
	 * @param string $date        	
	 */
	public function SetDate($date) {
		if ($this->date != $date) {
			$this->date = $date;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 日期起始时间
	 *
	 * @var string
	 */
	private $begin = '';

	/**
	 * 获取日期起始时间
	 *
	 * @return string
	 */
	public function GetBegin() {
		return $this->begin;
	}

	/**
	 * 设置日期起始时间
	 *
	 * @param string $begin        	
	 */
	public function SetBegin($begin) {
		if ($this->begin != $begin) {
			$this->begin = $begin;
			$this->isValueChanged = true;
		}
	}
	
	/**
	 * 日期结束时间
	 *
	 * @var string
	 */
	private $end = '';

	/**
	 * 获取日期结束时间
	 *
	 * @return string
	 */
	public function GetEnd() {
		return $this->end;
	}

	/**
	 * 设置日期结束时间
	 *
	 * @param string $end        	
	 */
	public function SetEnd($end) {
		if ($this->end != $end) {
			$this->end = $end;
			$this->isValueChanged = true;
		}
	}

	/**
	 * 构造函数
	 *
	 * @param number $id        	
	 */
	public function __construct($id = 0) {
		$this->setTableName ( PROJECT . "_103" );
		$this->setMemcacheId ( PROJECT . "_ADMIN_DATE" );
		$this->setZendCacheId ( PROJECT . "_ADMIN_DATE" );
		$this->setZendCacheDir ( "/ADMIN/DATE" );
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
			$this->SetDate ( $data ['F1_A003'] );
			$this->SetBegin ( $data ['F2_A003'] );
			$this->SetEnd ( $data ['F3_A003'] );
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
				'F1_A003' => $this->GetDate (),
				'F2_A003' => $this->GetBegin (),
				'F3_A003' => $this->GetEnd () 
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