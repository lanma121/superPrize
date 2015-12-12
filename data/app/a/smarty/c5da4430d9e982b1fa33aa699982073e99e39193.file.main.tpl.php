<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-05 14:38:53
         compiled from "D:\client\php\pdp\template\a\page\index\login\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:52945662428e3b03d2-46919654%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5da4430d9e982b1fa33aa699982073e99e39193' => 
    array (
      0 => 'D:\\client\\php\\pdp\\template\\a\\page\\index\\login\\main.tpl',
      1 => 1449297098,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '52945662428e3b03d2-46919654',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5662428e477784_87571866',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5662428e477784_87571866')) {function content_5662428e477784_87571866($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="/a/static/css/login.css" rel="stylesheet" />
	<?php echo '<script'; ?>
 type="text/javascript" src="/a/static/util/royalerp.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="/a/static/util/jquery.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="/a/static/util/unajax.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="/a/static/util/dialog.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="/a/static/util/upfile.js"><?php echo '</script'; ?>
>
</head>
<body>
	<div id="login_bg">
		<div id="main">
			<form action="/a/index/login" method="post">
				<div class="main1">管理员</div>
				<div class="main2">
					<b><span>系统管理员登录</span></b>
					<font>Information for xabaili company</font>
				</div>
				<div class="main3">
					<div class="main3_1"><img src="/a/static/images/001.jpg"/></div>
					<div class="main3_2">
						<div class="main3_3">
							<table cellspacing="0" cellpadding="0">
								<tr>
		   							<td width="150">用户名</td>
		   							<td colspan="2"><input style="margin:0;" type="text" name="userName" id="userName"/></td>
	   							</tr>	
	   							<tr>
		   							<td width="150">密&nbsp;&nbsp;码</td>
		   							<td colspan="2"><input style="margin:0;" type="password" name="passWord" id="passWord"/></td>
	   							</tr>
	   							<tr>
								   	<td></td>
								   	<td>
								   		<input style="width:20px;float:left;margin:0;" type="radio" name="way" value="1" checked onclick="javascript:findWay(1)"/><span style="float:left;margin:0;">邮箱</span>
								   		<input style="width:20px;float:left;margin:0;" type="radio" name="way" value="2" onclick="javascript:findWay(2)"/><span style="float:left;margin:0;">手机</span>
								   	</td>
							   	</tr>
							   	<tr>
									<td align="left"><span id="checkType" style="text-align:left;margin:0;">邮&nbsp;&nbsp;箱</span></td>
									<td><input style="width:100px;float:left;margin:0;" type="text" name="condition" id="condition"/></td>
		  							<td><input style="width:70px;margin:0;CURSOR:pointer;" name="获取验证码" type="button" value="获取验证码" onclick="getCode();"/></td>
	   							</tr>
	   							<tr>
	   								<td align="left"><span style="text-align:left;">验证码</span></td>
	   								<td colspan="2"><input style="width:50px; margin:0;"  type="text" name="authInput" id="authInput"/></td>
	   							</tr>
							</table>
						</div>
					</div>
					<div id="btn" style="margin-left:140px;">
						<input name="提交" type="button" value="登 录" onclick="Login();"/>
						<input name="重置" type="reset" value="取 消" />
					</div>	
				</div>
			</form>
		</div>
	</div>
	<?php echo '<script'; ?>
 type="text/javascript" src="/a/static/page/index/login/login.js"><?php echo '</script'; ?>
>
</body>
</html>
<?php }} ?>
