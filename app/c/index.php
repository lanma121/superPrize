<?php
/**
 * 入口文件
 *
 * Nginx请解析到该文件上
 *
 * @author hufeng(@yunbix.com)
 */
$app = Core_Init::init('c');
$app->run();
