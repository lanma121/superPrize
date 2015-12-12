<?php

/**
 * 
 * @author 1399871902@qq.com
 * @copyright 2015~ (c) 1399871902@qq.com
 * @Time: Mon 24 Aug 2015 05:45:00 PM CST
 */

class Controller_Asyn extends Yaf_Controller_Abstract{
	public $actions = array(
		'code' 			=> 'actions/asyn/Code.php',
		'login' 		=> 'actions/asyn/Login.php',
		'check' 		=> 'actions/asyn/prize/group/Check.php',
		'oper' 			=> 'actions/asyn/prize/group/Oper.php',
		'view' 			=> 'actions/asyn/prize/group/View.php',
		'dele' 			=> 'actions/asyn/prize/group/Dele.php',
	);
}