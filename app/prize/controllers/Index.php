<?php

/**
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Mon 24 Aug 2015 05:45:00 PM CST
 */

class Controller_Index extends Yaf_Controller_Abstract{
	public $actions = array(
		'index' 		=> 'actions/index/Index.php',
		'detail' 		=> 'actions/index/Detail.php',
		'flash' 		=> 'actions/index/Flash.php',
		'notice' 		=> 'actions/index/Notice.php',
		'valid' 		=> 'actions/index/Valid.php',
		'uload' 		=> 'actions/index/Uload.php',
		'open' 		=> 'actions/index/Open.php'
	);
}
