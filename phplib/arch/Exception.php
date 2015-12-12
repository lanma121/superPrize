<?php
/**
 * 标准异常
 *
 * 异常会自动记录日志
 *
 * @author hufeng<@yunsupport.com>
 * @copyright 2014-2015 @ yunsupport.com
 */
class Arch_Exception extends Exception
{
	const WARNING = 'warning';
	const FATAL = 'fatal';
    public function __construct($message, $argv = null, $level = Arch_Exception::WARNING){
		if($level == Arch_Exception::WARNING){
			Arch_Log::warning($message, $argv);
		}else{
			Arch_Log::fatal($message, $argv);
		}
        parent::__construct($message, 0, null);
    }
}

