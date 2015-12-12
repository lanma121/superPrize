<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-06 05:57:39
         compiled from "D:\client\php\pdp\template\a\page\prize\group\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:86135662de9e6c7769-38062882%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e0eec278be83bd584ff150fd9771b90cbfb2489' => 
    array (
      0 => 'D:\\client\\php\\pdp\\template\\a\\page\\prize\\group\\main.tpl',
      1 => 1449349162,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '86135662de9e6c7769-38062882',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5662de9e6ea9e5_95609249',
  'variables' => 
  array (
    'list' => 0,
    'item' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5662de9e6ea9e5_95609249')) {function content_5662de9e6ea9e5_95609249($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("a/widgets/header/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<input type="hidden" id="oid" value="0"/>
<input type="hidden" id="oname"/>
<input type="hidden" id="oremark"/>
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" id="viwe_table">
	<tr id="xuankuang"><td height="19"><img src="/a/static/images/024.jpg"/>当前的位置：奖品分类<span id="msgTitle">添加</span>分类</td></tr>
	<tr>
		<td height="200" bgcolor="#FFFFFF" valign="top">
			<table width="100%" align="center" border="0" cellspacing="1" cellpadding="0" class="baifenbai1">
				<tr> 
					<td colspan="2" height="10" >&nbsp;</td>
				</tr>
				<tr> 
					<td class="main2_left" align="center">类别名称：</td>
					<td class="main_right">
						<input name="groupName" id="groupName" type="text" size="33" onblur="checkName()"/>
						<span id="msgName"></span>
					</td>
				</tr>
				<tr id="market_name_id"> 
					<td class="main2_left" align="center" height="25">类别备注：</td>
					<td class="main_right" height="25">
						<textarea rows="5" cols="30" name="groupMark" id="groupMark" onblur="checkMark()"></textarea>
						<span id="msgMark"></span>
					</td>
				</tr>
				<tr> 
					<td height="67" align="right">&nbsp;</td>
					<td height="67" >
						<input type="button" class="tab_btn" id="add" value="添加" onclick="oper()"/>&nbsp;&nbsp;
						<input type="button" class="tab_btn" id="cal" value="返回" onclick="window.location.reload();"/>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" class="baifenbai" id="list_table">
	<tr id="xuankuang">
		<td height="18" colspan="10">&nbsp;<img src="/a/static/images/024.jpg"/>当前的位置：分类列表</td>
		<td align="left"><a href="javascript:addGroup()">添加分类 </a></td>
	</tr>
	<tr>
		<td colspan="50" id="tab_out_bg" width="100%">
			<table  class="baifenbai" cellpadding="0" cellspacing="1">
				<tr style="background-image:url(/a/static/images/019.jpg); font-weight:bold;" height=27 align="center">
					<td width="5%">ID</td>
					<td width="10%">类别名称</td>
					<td width="15%">类别备注</td>
					<td width="5%">添加日期</td>
					<td width="5%">修改日期</td>
					<td width="5%">操作</td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['list']->value) {?>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
				<tr align="center" bgcolor="#FFFFFF" height="24">
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_group_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_group_remark'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_group_adate'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_group_edate'];?>
</td>
					<td>
						<a href="javascript:editGroup(<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">编辑</a>
						<a href="javascript:delGroup(<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">删除</a>
					</td>
				</tr>
				<?php } ?>
				<?php }?>
			</table>
			<?php if ($_smarty_tpl->tpl_vars['list']->value) {?>
			<table class="baifenbai" style="background-color:#D5F2DB">
				<tr>
					<td align="center">
					<?php if ($_smarty_tpl->tpl_vars['page']->value['nc']!=1) {?>
						<?php if ($_smarty_tpl->tpl_vars['page']->value['has_prev']!=0) {?>
			            	<a class="pagebox_pre_nolink" href="/a/prize/group?rn=<?php echo $_smarty_tpl->tpl_vars['page']->value['rn'];?>
&pn=<?php echo $_smarty_tpl->tpl_vars['page']->value['pn']-1;?>
">上一页</a>
						<?php }?>
						<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['page']->value['display_pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
							<a class="<?php if ($_smarty_tpl->tpl_vars['page']->value['pn']==$_smarty_tpl->tpl_vars['item']->value) {?> pagebox_num_nonce current<?php } else { ?> pagebox_num <?php }?>" href="<?php if ($_smarty_tpl->tpl_vars['page']->value['pn']==$_smarty_tpl->tpl_vars['item']->value) {?> javascript:void(0) <?php } else { ?> /a/prize/group?rn=<?php echo $_smarty_tpl->tpl_vars['page']->value['rn'];?>
&pn=<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
 <?php }?>"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</a>
						<?php } ?>
						<?php if ($_smarty_tpl->tpl_vars['page']->value['has_next']!=0) {?>
			            	<a class="pagebox_next" id="pagelist" href="/a/prize/group?rn=<?php echo $_smarty_tpl->tpl_vars['page']->value['rn'];?>
&pn=<?php echo $_smarty_tpl->tpl_vars['page']->value['pn']+1;?>
"> 下一页</a>
			            <?php }?>
					<?php }?>
					</td>
				</tr>
			</table>
			<?php }?>
		</td>
	</tr>
</table>
<?php echo '<script'; ?>
 type="text/javascript" src="/a/static/page/prize/group/group.js"><?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("a/widgets/footer/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
