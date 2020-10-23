<?php

/**
 * 分页对象
 * 
 * @author Finder
 *
 */
class Paginate {
	
	/**
	 * 原始数据
	 *
	 * @var multitype
	 */
	private $data = array ();
	
	/**
	 * 获取原始数据
	 *
	 * @return multitype:
	 */
	public function Data() {
		return $this->data;
	}
	
	/**
	 * 每页行数
	 *
	 * @var number
	 */
	private $rows = 0;
	
	/**
	 * 获取每页行数
	 *
	 * @return number
	 */
	public function PageRows() {
		return $this->pageRows;
	}
	
	/**
	 * 条目数量
	 *
	 * @var number
	 */
	private $dataCount = 0;
	
	/**
	 * 获取条目数量
	 *
	 * @return number
	 */
	public function DataCount() {
		return $this->dataCount;
	}
	
	/**
	 * 页数
	 *
	 * @var number
	 */
	private $pageCount;
	
	/**
	 * 获取页数
	 *
	 * @return number
	 */
	public function PageCount() {
		return $this->pageCount;
	}
	
	/**
	 * 当前页
	 *
	 * @var number
	 */
	private $currentPage = 0;
	
	/**
	 * 获取当前页
	 *
	 * @return number
	 */
	public function CurrentPage() {
		return $this->currentPage;
	}
	
	/**
	 * 当前页数据
	 *
	 * @var multitype
	 */
	private $currentRecord = array ();
	
	/**
	 * 获取当前页数据
	 *
	 * @return multitype:
	 */
	public function CurrentRecord() {
		return $this->currentRecord;
	}
	
	/**
	 * 上一页
	 *
	 * @var number
	 */
	private $previous = 0;
	
	/**
	 * 获取上一页
	 *
	 * @return number
	 */
	public function Previous() {
		return $this->previous;
	}
	
	/**
	 * 下一页
	 *
	 * @var number
	 */
	private $next = 0;
	
	/**
	 * 获取下一页
	 *
	 * @return number
	 */
	public function Next() {
		return $this->next;
	}
	
	/**
	 * 分页数据
	 *
	 * @var multitype
	 */
	private $control = null;
	
	/**
	 * 获取分页数据
	 *
	 * @return multitype:
	 */
	public function Control() {
		return $this->control;
	}
	
	/**
	 * 实例化分页对象
	 *
	 * @param array $arrayData
	 *        	原始数据
	 * @param int $pageRows
	 *        	每页行数
	 * @param int $currentPage
	 *        	当前页数
	 */
	public function __construct($arrayData, $pageRows = 20, $currentPage = 1) {
		if (is_array ( $arrayData )) {
			$this->data = $arrayData;
			
			// 计算每页数据量
			$this->pageRows = $pageRows <= 0 ? 1 : $pageRows;
			
			// 计算数据量
			$this->dataCount = count ( $this->Data () );
			
			// 计算页数
			$pageCount = ( int ) ($this->DataCount () / $this->PageRows ());
			if (($this->DataCount () % $this->PageRows () > 0)) {
				$pageCount ++;
			}
			$this->pageCount = $pageCount;
			
			// 计算当前页码
			if ($this->PageCount () <= 0) {
				$currentPage = 1;
			} else {
				if ($currentPage < 1) {
					$currentPage = 1;
				} elseif ($currentPage > $this->PageCount ()) {
					$currentPage = $this->PageCount ();
				}
			}
			$this->currentPage = $currentPage;
			
			// 计算上一页页码
			if ($this->CurrentPage () > 1) {
				$this->previous = $this->CurrentPage () - 1;
			} else {
				$this->previous = 1;
			}
			
			// 计算下一页页码
			if ($this->CurrentPage () < $this->PageCount ()) {
				$this->next = $this->CurrentPage () + 1;
			} else {
				$this->next = $this->PageCount ();
			}
			
			// 计算当前页数据
			$index = ($this->CurrentPage () - 1) * $this->PageRows ();
			$length1 = $this->PageRows () * $this->CurrentPage ();
			$length2 = $this->DataCount ();
			for($i = $index; $i < $length1 && $i < $length2; $i ++) {
				$this->currentRecord [] = $this->data [$i];
			}
		}
	}
}