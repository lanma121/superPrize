<?php

/**
 * 
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Thu 20 Aug 2015 04:43:56 PM CST
 */

testNotice();

function testSample(){
	$paf = Arch_Paf::instance('sample');
	$r = $paf->call('passport/create', array('id' => 1, 'bcd' => monkee));
	var_dump($r);
}

function testNotice(){
	$paf = Arch_Paf::instance('notice');
	$r = $paf->call('sms/send', array('module' => 'guirenli', 'tel' => '18165305471', 'txt' => '查一下今天晚上有没有曼联的比赛'));
	var_dump($r);
}
