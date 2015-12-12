<?php

/**
 * ID分配
 *
 * 短ID分配使用数据库事务来进行分配
 * 部分逻辑依赖配置文件:arch.ini
 *
 * 配置必须包含:
 * [id]
 * db=yourdbname
 * table=yourdbtable
 * ns=namespace
 *
 * 建表语句如下:
 *
 * CREATE TABLE `arch_id` (name char(32) not null primary key, id bigint unsigned not null);
 * 
 * 为什么要用数据库?
 * 1. 分布式ID分配,ID的位数太长
 * 2. 集中式的分配,服务独立出去迁移比较麻烦
 * 3. 分段式相对来讲比较复杂
 *
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Wed 12 Nov 2014 10:55:50 PM CST
 */

class Arch_ID
{
	const MAGIC = 0x1000ACEF;
	private $opt = array();

	/**
	 * 快速生成ID
	 *
	 * @param string $name
	 * @param boolean $isEncode
	 *
	 * @return int
	 */
	public static function g($name, $isEncode = true){
		$aid = new Arch_ID();
		return $aid->alloc($name, $isEncode);
	}

	public function __construct(){
		if(Arch_Yaml::isExist('arch', 'id')){
			$this->opt = Arch_Yaml::get('arch', 'id');
		}else{
			$this->opt = Core_Conf::getConf('arch:id');
		}
		$this->db = Blue_DB::instance($this->opt['db']);
	}

	public function alloc($name, $isEncode = true){
		$this->db->startTrans();
		$name = $this->opt['ns'] . '.' . $name;
		$ret = $this->db->selectOne($this->opt['table'], sprintf('name="%s"', $this->db->escape($name)), 'id', 'for update');
		if(empty($ret)){
			$id = 1;
		}else{
			$id = intval($ret['id']);
		}
		$this->db->replace($this->opt['table'], array('name' => $name, 'id' => $id + 1));
		$this->db->commit();

		if($isEncode){
			return $this->encode($id);
		}else{
			return $id;
		}
	}

	public function encode($id){
		return ($id << 2) ^ self::MAGIC;
	}

	public function decode($id){
		return ($id ^ self::MAGIC) >> 2;
	}
}
