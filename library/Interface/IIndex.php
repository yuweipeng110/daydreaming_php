<?php
interface Interface_IIndex {
	
	/**
	 * 获取索引
	 *
	 * @return int
	 */
	function GetIndex();
	
	/**
	 * 获取对象
	 */
	function GetId();
	
	/**
	 * 实例化
	 *
	 * @param string $tableName        	
	 * @param string $columnName        	
	 * @param string $index        	
	 */
	function __construct($tableName = null, $columnName = null, $index = null);
	
	/**
	 * 将对象保存到数据库及相关缓存
	 */
	function Save();
	
	/**
	 * 从数据库及相关缓存中删除对象
	 */
	function Destroy();
}