<?php

	/**
	 * 微博登录
	 */
	include_once( __DIR__.'/sina/config.php' );
	include_once( __DIR__.'/sina/saetv2.ex.class.php' );
	class App_Oauth_Sina
	{
		static public function sinaLogin(){
			$sinaObj = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
			$code_url = $sinaObj->getAuthorizeURL( WB_CALLBACK_URL );
			header('Location: '.$code_url);
		}

		static public function getSaeTOAuthInstance($access_token = NULL, $refresh_token = NULL){
			$oauth = new SaeTOAuthV2( WB_AKEY , WB_SKEY, $access_token, $refresh_token);	
			return $oauth;
		}

		static public function getSaeTClientInstance($access_token, $refresh_token = NULL){
			$client = new SaeTClientV2( WB_AKEY , WB_SKEY , $access_token, $refresh_token);
			return $client;
		}

		static public function getOauthToken($oauth, $code){
			$keys = array();
			$keys['code'] = $code;
			$keys['redirect_uri'] = WB_CALLBACK_URL;
			try {
				$token = $oauth->getAccessToken( 'code', $keys ) ;
			} catch (OAuthException $e) {
				return false;
			}
			return $token;
		}

	}

?>
