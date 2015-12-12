<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-06 00:39:13
         compiled from "D:\client\php\pdp\template\a\widgets\header\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:260595662e221667702-38703815%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '158f739ece83bd701659df8287f8ab23bea21c6c' => 
    array (
      0 => 'D:\\client\\php\\pdp\\template\\a\\widgets\\header\\header.tpl',
      1 => 1449333524,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '260595662e221667702-38703815',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5662e22168e818_62878607',
  'variables' => 
  array (
    'dllk' => 0,
    'modules' => 0,
    'item' => 0,
    'admin' => 0,
    'time' => 0,
    'key' => 0,
    'menus' => 0,
    'limit' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5662e22168e818_62878607')) {function content_5662e22168e818_62878607($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="/a/static/css/style.css" />
	<link type="text/css" rel="stylesheet" href="/a/static/css/bootstrap.css"  />
	<link type="text/css" rel="stylesheet" href="/a/static/css/bootstrap-responsive.css" />
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
	<input type="hidden" id="dllk" value="<?php echo $_smarty_tpl->tpl_vars['dllk']->value;?>
"/>
	<!--头部-->
	<div class="warp_bg">
		<div class="tou_top">
		
			<div id="top_right">
				<ul class="shouye">
					<?php if ($_smarty_tpl->tpl_vars['modules']->value) {?>
					<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['modules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<li><a href="/a/index/index?mo=<?php echo $_smarty_tpl->tpl_vars['item']->value['key'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></li>
					<?php } ?>
					<?php }?>
				</ul>
			</div>
			
			<div id="top_left">
				<div id="logo">
					<span>管理员后台</span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="position_bai">
		<div id="user_position"><?php echo $_smarty_tpl->tpl_vars['admin']->value;?>
<span onclick="logout()" style="cursor:pointer;">[注销]</span></div>
		<div id="position_title">
			<span>
				<a><?php echo $_smarty_tpl->tpl_vars['time']->value;?>
</a>
			</span>
		</div>
	</div>
	
	<div id="left_12">
		<div id="left_123">
			<div id="left_title"><span><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</span></div>
			<?php if ($_smarty_tpl->tpl_vars['menus']->value) {?>
			<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
			<div>
				<div id="bolck_a" class="ft_lt">
					<div class="xiaobiaoti_bg">
						<img src="/a/static/images/022.gif" style="margin-top:4px; margin-right:5px;" />
						<span><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</span>
					</div>
					<div id="xiaobiaoti_kuang">
						<?php if ($_smarty_tpl->tpl_vars['item']->value['childs']) {?>
						<?php  $_smarty_tpl->tpl_vars['limit'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['limit']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['childs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['limit']->key => $_smarty_tpl->tpl_vars['limit']->value) {
$_smarty_tpl->tpl_vars['limit']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['limit']->key;
?>
						<ul>
							<li class="left_main1">
								<a href="<?php echo $_smarty_tpl->tpl_vars['limit']->value['link'];?>
">
									<img src="/a/static/images/023.gif" style="margin-right:5px;border:0px;" />
									<span><?php echo $_smarty_tpl->tpl_vars['limit']->value['title'];?>
</span>
								</a>
							</li>
						</ul>
						<?php } ?>
						<?php }?>
					</div>
				</div>
			</div>
			<?php } ?>
			<?php }?>
		</div>
		<div id="right"><?php }} ?>
