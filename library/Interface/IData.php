<?php
interface Interface_IData {
	
	/**
	 * 获取对象ID
	 *
	 * @return int
	 */
	function GetId();
	
	/**
	 * 获取入库时间
	 */
	function GetOtime();
	
	/**
	 *
	 * @param number $id        	
	 */
	function __construct($id = 0);
	
	/**
	 * 将对象保存到数据库及相关缓存
	 */
	function Save();
	
	/**
	 * 从数据库及相关缓存中删除对象
	 */
	function Destroy();
}