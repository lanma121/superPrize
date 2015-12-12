<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Fri 07 Nov 2014 11:14:54 PM CST
 */

class Blue_Dao
{
	private $table = '';
	private $dbW = null;
	private $dbR = null;

	public function __construct($dbw, $dbr, $table){
		$this->dbW = Blue_DB::instance($dbw);
		$this->dbR = Blue_DB::instance($dbr);
		$this->table = $table;
	}

	public function get($id, $key = 'id'){
		if(empty($id)){
			return array();
		}

		return $this->selectOne(sprintf('`%s`=%d', $key, $id));
	}

	/**
	 * 常见的批量查询
	 *
	 * @param array $ids
	 *
	 * @return array
	 */
	public function gets($ids, $key = 'id'){
		if(empty($ids)){
			return array();
		}

		return $this->select(sprintf('`%s` IN (%s)', $key, implode(',', $ids)));
	}

	/**
	 * 执行SELECT查询
	 *
	 * @param string $cond 查询条件
	 * @param mixed $fields	查询字段
	 * @param string $opt	查询的附加选项
	 *
	 * @return array
	 */
	public function select($cond, $fields = array(), $opt = ''){
		return $this->dbR->select($this->table, $cond, $fields, $opt);
	}

	public function selectOne($cond, $fields = array(), $opt = ''){
		return $this->dbR->selectOne($this->table, $cond, $fields, $opt);
	}

	public function selectCount($cond, $opt = ''){
		return $this->dbR->selectCount($this->table, $cond, $opt);
	}

	/**
	 * 执行写入语句
	 *
	 * @param array $data
	 * @param boolean $isIgnore
	 * @param string $opt 附加的语句,用于for update等
	 *
	 * @return boolean
	 */
	public function insert($data, $isIgnore = false, $opt = ''){
		return $this->dbW->insert($this->table, $data, $isIgnore, $opt);
	}

	/**
	 * 执行写入语句，使用replac
	 *
	 * @param array $data
	 * @param string $opt 附加的语句,用于for update等
	 *
	 * @return boolean
	 */
	public function replace($data, $opt = ''){
		return $this->dbW->replace($this->table, $data, $opt);
	}

	/**
	 * 更新操作
	 *
	 * @param string $cond
	 * @param array $data
	 * @param string $opt 附加语句
	 */
	public function update($cond, $data, $opt = ''){
		return $this->dbW->update($this->table, $cond, $data);
	}

	/**
	 * 删除操作
	 *
	 * @param string $cond
	 * @param string $opt 附加语句
	 */
	public function delete($cond, $opt = ''){
		return $this->dbW->delete($this->table, $cond, $opt);
	}

	/**
	 * 获取table名称
	 *
	 * @return string
	 */
	public function getTable(){
		return $this->table;
	}

	/**
	 * SQL转义
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	public function escape($str){
		return $this->dbR->escape($str);
	}

	public function execute($sql){
		return $this->dbW->execute($sql);
	}

	/**
	 * 返回execute执行select后的结果
	 *
	 * @param resource $res
	 *
	 * @return array
	 */
	public function fetchAll($res){
		return $this->dbW->fetchAll($res);
	}

	public function startTrans(){
	}

	public function cancle(){
	}

	public function commit(){
	}
}

