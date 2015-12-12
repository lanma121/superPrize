<?php

/**
 * 
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Thu 17 Sep 2015 02:48:44 PM CST
 */


$stat = new Arch_Stat('guirenli');

//1. 获取20150917当天 事件为5 的用户有多少个
$opt = array(
	'query' => 'app:"guirenli"',
	//'filter' => 'date=20150917 AND event=5',
	'aggregate' => array(
		'key' => array(
			array(
				'group_key' => 'key',
				'agg_fun' => 'count()',
				'max_group' => '3'
			),
		)
	),
	'start' => 0,
	'hits' => 0
);
$r = $stat->query($opt);
var_dump($r);
