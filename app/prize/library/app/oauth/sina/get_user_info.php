<?php
	session_start();
	include_once( 'config.php' );
	include_once( 'saetv2.ex.class.php' );
	
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	$user_message = $c->show_user_by_id($uid);//根据ID获取用户等基本信息
	/*$_SESSION['oauth_user_id'] = $uid;
	$_SESSION['oauth_user_name'] = $user_message['screen_name'];*/
    $oauth_api_id = $_SESSION['oauth_api_id'];
    $head = urlencode($user_message['profile_image_url']);
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/users/oauth_login.php?action=oauth_callback&username='.$user_message['screen_name'].'&openid='.$uid.'&oauth_api_id='.$oauth_api_id.'&head='.$head);
	
?>


