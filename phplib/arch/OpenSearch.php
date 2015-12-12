<?php
/**
 * 阿里云分布式搜索的接口
 * 
 * @author hufeng<@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Thu 06 Aug 2015 10:22:58 AM CST
 */

require_once(__dir__ . "/OpenSearch/CloudsearchClient.php");
require_once(__dir__ . "/OpenSearch/CloudsearchIndex.php");
require_once(__dir__ . "/OpenSearch/CloudsearchDoc.php");
require_once(__dir__ . "/OpenSearch/CloudsearchSearch.php");

class Arch_OpenSearch
{
	private $ak;
	private $sk;
	private $host;
	private $ins;
	private $module;

	public function __construct($module){
		$ini = Arch_Yaml::get('opensearch', $module, true);

		if(empty($ini)){
			throw new Arch_Exception('opensearch配置文件不存在');
		}

		$this->module = $ini['module'];
		$this->ak = $ini['ak'];
		$this->sk = $ini['sk'];
		$this->host = $ini['host'];
		$this->ins = new CloudsearchClient($this->ak, $this->sk, array('host' => $this->host), 'aliyun');
	}

	/**
	 * 单条数据更新 若不存在 则update 否则insert
	 *
	 * @param string $table
	 * @param array  $data
	 *
	 * @return
	 */
	public function update($table, $data){
		$doc = new CloudsearchDoc($this->module, $this->ins);
		$item = array(
			'cmd' => 'update',
			'fields' => $data
		);
		$r = $doc->add(array($item), $table);
		$this->checkResponse($r);
	}

	public function add($table, $query){
		$doc = new CloudsearchDoc($this->module, $this->ins);

		$r = $doc->add($query, $table);
		$this->checkResponse($r);
	}

	/**
	 * 查询
	 *
	 * 这里详细的查询，请参考：
	 *
	 * https://docs.aliyun.com/#/pub/opensearch/sdk/php&sdk-doc-cloudsearchsearch
	 *
	 * @param string $query
	 *
	 * @return array
	 */
	public function query($opt){
		$se = new CloudsearchSearch($this->ins);

		$opt['format'] = 'json';
		$opt['indexes'] = array($this->module);

		$r = $se->search($opt);
		$r = $this->checkResponse($r);
		return $r['result'];
	}

	/**
	 * 单条数据删除
	 *
	 * 直接删除
	 *
	 * @param string $table
	 * @param array $data
	 */
	public function delete($table, $data){
		$doc = new CloudsearchDoc($this->module, $this->ins);
		$item = array(
			'cmd' => 'delete',
			'fields' => $data
		);
		$r = $doc->add(array($item), $table);

		$this->checkResponse($r);
	}

	private function checkResponse($res){
		$res = json_decode($res, true);
		if(empty($res)){
			throw new Arch_Exception('OpenSearch response format error');
		}

		if($res['status'] != 'OK'){
			throw new Arch_Exception($res['errors'][0]['message']);
		}

		return $res;
	}
}

/*

$access_key = 'ZaBuBlBh57hZtNHO';
$secret = 'LiYFNSpwCXacp3lJNLhjnZLyidNnzJ';
$host = 'http://intranet.opensearch-cn-beijing.aliyuncs.com';


$ins = new CloudsearchClient($access_key, $secret, array('host' => $host), 'aliyun');
/*
$doc = new CloudsearchDoc('test', $ins);

$item = array();
$item['cmd'] = 'ADD';
$item['fields'] = array(
	'id' => 1,
	'passid' => 2,
	'fid' => 3,
	'tags' => array('你好', '不好')
);


$r = $doc->add(json_encode(array($item)), 'friend');

var_dump($r);


$se = new CloudsearchSearch($ins);

$opt = array(
	'query' => "tags:'你好'",
	'fetch_fields' => array('id', 'fid'),
	'indexes' => array('test'),
	'format' => 'json',

);
$r = $se->search($opt);

var_dump($r);
 */
