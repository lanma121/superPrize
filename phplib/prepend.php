<?php
/**
 * PDP的预载入文件
 *
 * PHP每次执行的时候都需要先载入这个文件
 *
 * 本文件被放置在目录：
 * 	   $pdpdir/phplib/prepend.php
 * 
 * 1. 定义基础变量
 * 2. 注册全局类库路径
 * 
 * @author 胡峰 <hufeng@yunsupport.com>
 * @version 1.0.0
 * @package core
 * @copyright 2014-2015 yunsupport.com
 */
 


 //定义基础变量
define('ROOT', realpath(dirname(__FILE__) . '/../'));
define('DIR_DAT', ROOT . '/data/');
define('DIR_LOG', ROOT . '/log/');
define('DIR_CONF', ROOT . '/conf/');
define('PHPLIB', ROOT . '/phplib/');

define('DIR_APP', ROOT . '/app/');

define('PDP_VERSION', '1.0.0');
define('PDP_ROOT', ROOT);
define('PDP_DIR_APP', DIR_APP);
define('PDP_DIR_DAT', DIR_DAT);
define('PDP_DIR_LOG', DIR_LOG);
define('PDP_DIR_CONF', DIR_CONF);
define('PDP_ROOT_PHPLIB', PHPLIB);

Yaf_Loader::getInstance(NULL, PDP_ROOT_PHPLIB);

