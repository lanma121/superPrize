<?php
	/**
	 * 微信登录
	 */
    include_once(__DIR__.'/weixin/config.php' );
    require_once(__DIR__."/weixin/WeiConnectAPI.php");

	class App_Oauth_Weixin
	{
		static public function weixinLogin(){
			$wexin = new WeiApi(APP_ID,APP_KEY);
			$code_url = $wexin->getAuthorizeURL(WB_CALLBACK_URL);
			header('Location: '.$code_url);
		}

		static public function getWeixinInstance(){
			$weixin = new WeiApi(APP_ID,APP_KEY);
			return $weixin;	
		}
	
	}
