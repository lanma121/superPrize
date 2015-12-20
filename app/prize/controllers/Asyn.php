<?php

/**
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Mon 24 Aug 2015 05:45:00 PM CST
 */

class Controller_Asyn extends Yaf_Controller_Abstract{
	public $actions = array(
		'userlogin' 	=> 'actions/asyn/user/Login.php',
		'userinfo' 		=> 'actions/asyn/user/Info.php',
		'userdraw'		=> 'actions/asyn/user/Draw.php',
		'checkdraw'		=> 'actions/asyn/prize/check/Draw.php',
		'luckdraw'		=> 'actions/asyn/prize/luck/Draw.php',
		'checkstart'	=> 'actions/asyn/prize/check/Start.php',
		'checkstatus'	=> 'actions/asyn/prize/check/Status.php',
		'startprize'	=> 'actions/asyn/prize/start/Prize.php',
		'markflash'		=> 'actions/asyn/prize/mark/Flash.php',
		'checkflash'	=> 'actions/asyn/prize/check/Flash.php'
	);
}