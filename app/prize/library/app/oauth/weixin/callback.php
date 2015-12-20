<?php
session_start();

include_once( 'config.php' );
require_once("WeiConnectAPI.php");

$wexin = new WeiApi(APP_ID,APP_KEY);

if (isset($_REQUEST['code'])) {
    $keys = array();
    $keys['code'] = $_REQUEST['code'];
   // $keys['redirect_uri'] = WB_CALLBACK_URL;
    try {
        $token = $wexin->getAccessToken( 'code', $keys ) ;
    } catch (OAuthException $e) {
    }
}
//print_r($token.'-'.$_REQUEST['code']);die();
if ($token) {
    $_SESSION['token'] = $token;
   // setcookie( 'weibojs_'.$wexin->client_id, http_build_query($token) );
    header('Location: get_user_info.php');
//授权完成,<a href="weibolist.php">进入你的微博列表页面</a><br />
} else {//授权失败
    header('Location: http://www.xabaili.com/users/login.php');
}
	

