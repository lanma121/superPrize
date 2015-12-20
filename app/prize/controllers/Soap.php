<?php

/**
 * 
 * @author 1399871902 <@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Mon 24 Aug 2015 05:45:00 PM CST
 */

class Controller_Soap extends Yaf_Controller_Abstract{
	public $actions = array(
		'server' 		=> 'actions/soap/Server.php',
		'client' 		=> 'actions/soap/Client.php'
	);
}