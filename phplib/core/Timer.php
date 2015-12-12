<?php
/**
 * 计时器
 * 
 * 用于记录两次操作之间的间隔时间
 * 
 * @author monkee(@yunsupport.com)
 */

class Core_Timer
{
	static private $start = 0;
	static private $end = 0;
	static public function startRecord(){
		self::$start = (int) (microtime(TRUE) * 1000);
	}
	
	static public function endRecord(){
		self::$end = (int) (microtime(TRUE) * 1000);
	}
	
	static public function getResult(){
		return (self::$end) - (self::$start);
	}
}
