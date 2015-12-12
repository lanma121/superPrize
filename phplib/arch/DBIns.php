<?php
/**
 * DB连接的实际对象
 *
 * 对DB连接的实际对象
 * 处理常见的操作
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Mon 10 Nov 2014 07:51:25 PM CST
 */

class Arch_DBIns
{
	/**
	 * 连接的配置
	 */
	private $opt = array(
		'host' => '',
		'user' => '',
		'pw' => '',
		'db' => '',
		'port' => 0,
		'cTimeout' => 5,
		'charset' => 'UTF-8'
	);

	/**
	 * 实际的MYSQLI对象
	 */
	private $ins = null;

	/**
	 * 初始化
	 *
	 * 这里不会自动连接,只会生成一个对象
	 * 实际的连接使用:
	 *	$ins->connect();
	 *
	 * @param string $host
	 * @param string $name
	 * @param string $pw
	 * @param string $db
	 * @param int $port
	 */
	public function __construct($host, $user, $pw, $db, $port){
		$this->ins = mysqli_init();
		$this->opt['host'] = $host;
		$this->opt['user'] = $user;
		$this->opt['pw'] = $pw;
		$this->opt['db'] = $db;
		$this->opt['port'] = $port;
	}

	/**
	 * 设置字符集
	 *
	 * 一般在连接之前进行设置
	 * 也可以在连接之后设置
	 *
	 * @param string $encode
	 */
	public function setCharset($encode){
		$this->opt['charset'] = $encode;
		$this->ins->set_charset($encode);
	}

	/**
	 * 设置连接超时时间
	 *
	 * @param int $sec 超时时间,单位:秒
	 */
	public function setConnectTimeout($sec){
		$this->ins->options(MYSQLI_OPT_CONNECT_TIMEOUT, $sec);
	}

	/**
	 * 处理连接
	 *
	 * @throws Core_Exception_Fatal 连接失败,会抛出异常
	 */
	public function connect(){
		if(false == $this->ins->real_connect($this->opt['host'], $this->opt['user'], $this->opt['pw'], $this->opt['db'], $this->opt['port'])){
			$this->opt['err'] = $this->ins->connect_error;
			throw new Arch_Exception("DB connect fail", $this->opt);
		}
		$this->ins->set_charset($this->opt['charset']);
		$this->ins->autocommit(TRUE);
	}

	/**
	 * 执行SELECT查询
	 *
	 * 这里不支持联表查询,子查询等
	 *
	 * @param string $table
	 * @param string $cond	查询条件,字符串形式
	 * @param array $fields 查询字段
	 * @param string $opt	查询选项,比如:limit 10,10
	 *
	 * @return array
	 */
	public function select($table, $cond, $fields = null, $opt = ''){
		$fields = is_array($fields) ? implode(',', $fields) : $fields;
		$sql = sprintf('SELECT %s FROM `%s` WHERE %s %s', empty($fields) ? '*' : $fields,
	
			$table, empty($cond) ? '1' : $cond, $opt);
	
		$result = $this->query($sql);
		if(empty($result)){
			throw new Arch_Exception("Execute sql fail",
				array("sql" => $sql, 'err' => $this->ins->error));
		}
		$data = array();
		while($row = $result->fetch_assoc()){
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * 执行SELECT查询,获取单行
	 *
	 * 这里不支持联表查询,子查询等
	 *
	 * @param string $table
	 * @param string $cond	查询条件,字符串形式
	 * @param array $fields 查询字段
	 * @param string $opt	查询选项
	 *
	 * @return array
	 */
	public function selectOne($table, $cond, $fields = null, $opt = ''){
		$fields = is_array($fields) ? implode(',', $fields) : $fields;
		$opt = 'LIMIT 1 ' . $opt;
		$sql = sprintf('SELECT %s FROM `%s` WHERE %s %s', empty($fields) ? '*' : $fields,
			$table, empty($cond) ? '1' : $cond, $opt);
		$result = $this->query($sql);
		if(empty($result)){
			throw new Arch_Exception("Execute sql fail",
				array("sql" => $sql, 'err' => $this->ins->error));
		}
		while($row = $result->fetch_assoc()){
			return $row;
		}
		return array();
	}

	/**
	 * 查询条数
	 *
	 * @param string $table
	 * @param string $cond	查询条件,字符串形式
	 * @param string $opt	查询选项,比如:limit 10,10
	 *
	 * @return int
	 */
	public function selectCount($table, $cond, $opt = ''){
		$fields = is_array($fields) ? implode(',', $fields) : $fields;
		$sql = sprintf('SELECT count(1) as n FROM `%s` WHERE %s %s',
			$table, empty($cond) ? '1' : $cond, $opt);
		$result = $this->query($sql);
		if(empty($result)){
			throw new Arch_Exception("Execute sql fail",
				array("sql" => $sql, 'err' => $this->ins->error));
		}
		$data = array();
		$n = 0;
		while($row = $result->fetch_assoc()){
			$n = intval($row['n']);
			break;
		}
		return $n;
	}
	/**
	/**
	 * 写入操作
	 *
	 * @param string $table
	 * @param array $data 要更新的数据
	 * @param boolean $isIgnore 是否是忽略模式,INSERT INGORE ...
	 * @param string $opt 附加SQL语句
	 */
	public function insert($table, $data, $isIgnore = false, $opt = ''){
		$sql = sprintf('INSERT %s INTO `%s` SET %s%s', 
			($isIgnore ? 'IGNORE' : ''), $table, $this->escapeData($data), $opt);
		$this->query($sql);
	}

	/**
	 * 替换写入模式
	 *
	 * 与insert的区别是,主键或者unique部分有冲突,则会直接替换
	 *
	 * @param string $table
	 * @param array $data
	 * @param string $opt
	 */
	public function replace($table, $data, $opt = ''){
		$sql = sprintf('REPLACE INTO `%s` SET %s%s', $table, $this->escapeData($data), $opt);
		$this->query($sql);
	}

	/**
	 * 执行UPDATE操作
	 *
	 * @param string $table
	 * @param string $cond
	 * @param array $data 要更新的数据
	 * @param string $opt 附加SQL语句
	 */
	public function update($table, $cond, $data, $opt = ''){
		$sql = sprintf('UPDATE `%s` SET %s WHERE %s%s',
			$table, $this->escapeData($data), $cond, $opt);
	
		$this->query($sql);
	}

	/**
	 * 删除数据
	 *
	 * 如果失败会抛出异常
	 *
	 * @param string $table
	 * @param string $cond
	 * @param string $opt 附加SQL语句
	 */
	public function delete($table, $cond, $opt = ''){
		$sql = sprintf('DELETE FROM `%s` WHERE %s%s', $table, $cond, $opt);
		$this->query($sql);
	}

	/**
	 * 执行实际的SQL
	 *
	 * @param string $sql 执行的SQL语句
	 *
	 * @return mixed 
	 */
	public function query($sql){
		$result = $this->ins->query($sql);

		if($result === FALSE){
			throw new Arch_Exception("DB Execute Error", array('msg' => $this->ins->error, 'errno' => $this->ins->errno, 'sql' => $sql));
		}

		return $result;
	}

	/**
	 * 执行sql语句
	 *
	 * 只执行不返回结果,执行失败则抛出异常
	 *
	 * @param string $sql
	 */
	public function execute($sql){
		return $this->query($sql);
	}

	/**
	 * 开启事务
	 *
	 * 此操作会启动事务
	 * 原理是禁止自动提交
	 */
	public function startTrans(){
		$this->ins->autocommit(FALSE);
	}

	/**
	 * 回滚事务
	 *
	 * 此操作会终止事务
	 */
	public function rollback(){
		$this->ins->rollback();
		$this->endTrans();
	}

	/**
	 * 事务提交
	 *
	 * 此操作会终止事务
	 */
	public function commit(){
		$this->ins->commit();
		$this->endTrans();
	}

	/**
	 * 终止事务
	 *
	 * 原理实际上是开启自动提交
	 */
	public function endTrans(){
		$this->ins->autocommit(TRUE);
	}

	/**
	 * 针对query和execute的结果,进行数组话输出
	 *
	 * 仅对select查询有效
	 *
	 * @param resource $result
	 *
	 * @return array
	 */
	public function fetchAll($result){
		$ret = array();
		while($row = $result->fetch_assoc()){
			$ret[] = $row;
		}
		return $ret;
	}


	/**
	 * 转义数组,用于insert\update等SQL拼装
	 *
	 * @param array $data 必须是数组
	 *
	 * @return string
	 */
	public function escapeData($data){
		if(is_array($data)){
			$rows = array();
			foreach($data as $k => $v){
				$rows[] = sprintf('`%s`="%s"', $k, $this->escape($v));
			}
			return implode(',', $rows);
		}
		return $data;
	}

	/**
	 * 转义可能会发生出错的语句
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	public function escape($str){
		return $this->ins->real_escape_string($str);
	}
}

