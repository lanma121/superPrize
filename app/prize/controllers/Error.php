<?php

/**
 * 
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: 2015年11月23日 星期一 15时50分27秒
 */
class Controller_Error extends Yaf_Controller_Abstract
{
	public function errorAction(){
		$exp = $this->getRequest()->getException();
		$code = $exp->getCode();
		if($code === YAF_ERR_NOTFOUND_CONTROLLER || $code === YAF_ERR_NOTFOUND_ACTION){
			Core_Log::warning($exp->getMessage());
			header('HTTP/1.1 403 Forbidden');
		}else{
			Core_Log::fatal($exp->getMessage());
			header('HTTP/1.1 500 Internal Server Error');
		}
	}
}

