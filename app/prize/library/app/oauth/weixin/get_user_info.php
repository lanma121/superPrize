<?php
/**
 * Created by PhpStorm.
 * User: zhp
 * Date: 2015/5/18
 * Time: 17:10
 */
session_start();
include_once( 'config.php' );
require_once("WeiConnectAPI.php");

$wexin = new WeiApi(APP_ID,APP_KEY);
$access_token = $_SESSION['token']['access_token'];
$open_id= $_SESSION['token']['openid'];

$user_info = $wexin->get_userinfo($access_token,$open_id);

$oauth_api_id = $_SESSION['oauth_api_id'];//登录方式ID
$openid = $user_info['openid'];//唯一普通用户标识
$user_name = $user_info['nickname'];//用户昵称c
$head = $user_info['headimgurl'];//用户头像信息

header('Location: http://'.$_SERVER['HTTP_HOST'].'/users/oauth_login.php?action=oauth_callback&username='.$user_name.'&openid='.$openid.'&oauth_api_id='.$oauth_api_id.'&head='.$head);