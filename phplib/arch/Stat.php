<?php
/**
 * 事件统计的SDK
 *
 * 用户Event-Stat系统
 *
 * 依赖：OpenSearch接口
 * 
 * @author hufeng<@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Thu 17 Sep 2015 02:44:05 PM CST
 */

class Arch_Stat
{
	private $os;
	public function __construct($module){
		$opt = Arch_Yaml::get('stat', $module, true);
		$this->os = new Arch_OpenSearch($opt['opensearch']);
	}

	public function query($opt){
		return $this->os->query($opt);
	}
}

