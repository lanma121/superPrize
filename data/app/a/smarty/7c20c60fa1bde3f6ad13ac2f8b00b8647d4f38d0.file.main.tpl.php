<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-06 07:22:35
         compiled from "D:\client\php\pdp\template\a\page\prize\list\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:281285662e6bdbe7b12-00409634%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7c20c60fa1bde3f6ad13ac2f8b00b8647d4f38d0' => 
    array (
      0 => 'D:\\client\\php\\pdp\\template\\a\\page\\prize\\list\\main.tpl',
      1 => 1449357751,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '281285662e6bdbe7b12-00409634',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5662e6bdc12aa7_23902968',
  'variables' => 
  array (
    'auto' => 0,
    'statusList' => 0,
    'status' => 0,
    'i' => 0,
    'item' => 0,
    'autoList' => 0,
    'code' => 0,
    'list' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5662e6bdc12aa7_23902968')) {function content_5662e6bdc12aa7_23902968($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\client\\php\\pdp\\phplib\\blue\\view\\smarty\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("a/widgets/header/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<table border="0" cellspacing="0" cellpadding="0" class="baifenbai" id="list_table">
	<tr id="xuankuang">
		<td height="18" colspan="10">&nbsp;<img src="/a/static/images/024.jpg"/>当前的位置：奖品列表</td>
		<td align="center"><a href="javascript:addPrize()">添加奖品</a></td>
		<td align="right">
			<span>奖品状态:</span>
			<select onchange="window.location.href='/a/prize/list?&auto=<?php echo $_smarty_tpl->tpl_vars['auto']->value;?>
&status='+this.value;">
				<?php if ($_smarty_tpl->tpl_vars['statusList']->value) {?>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['statusList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
				<?php if ($_smarty_tpl->tpl_vars['status']->value==$_smarty_tpl->tpl_vars['i']->value) {?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" selected><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
				<?php } else { ?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
				<?php }?>
				<?php } ?>	
				<?php }?>	
			</select>
			<span>开奖类型:</span>
			<select onchange="window.location.href='/a/prize/list?status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
&auto='+this.value;">
				<?php if ($_smarty_tpl->tpl_vars['autoList']->value) {?>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['autoList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
				<?php if ($_smarty_tpl->tpl_vars['auto']->value==$_smarty_tpl->tpl_vars['i']->value) {?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" selected><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
				<?php } else { ?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
				<?php }?>
				<?php } ?>	
				<?php }?>	
			</select>
			<span>奖品编号:</span>
			<input type="text" size="20" value="<?php echo $_smarty_tpl->tpl_vars['code']->value;?>
" onblur="if(this.value!='') window.location.href='/a/prize/list?code='+this.value;"/>
		</td>
	</tr>
	<tr>
		<td colspan="50" id="tab_out_bg" width="100%">
			<table class="baifenbai" cellpadding="0" cellspacing="1">
				<tr style="background-color:rgb(207,236,257); font-weight:bold;" height=27 align="center">
					<td width="2%">ID</td>
					<td width="2%">期数</td>
					<td width="4%">编号</td>
					<td width="10%">标题</td>
					<td width="3%">所需积分</td>
					<td width="3%">最低人数</td>
					<td width="3%">实际人数</td>
					<td width="3%">市场价格</td>
					<td width="3%">大奖状态</td>
					<td width="3%">开奖类型</td>
					<td width="3%">发布人</td>
					<td width="3%">推荐</td>
					<td width="6%">发布时间</td>
					<td width="8%">操作</td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['list']->value) {?>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
				<tr align="center" bgcolor="#FFFFFF" style="height:24px;" class="content">
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_phase'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_code'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_short_title'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_draw_currency'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_min_num'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_fact_num'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_price'];?>
</td>
					<td>
						<?php if ($_smarty_tpl->tpl_vars['item']->value['prize_status']==0) {?>
						<span>待开放</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['item']->value['prize_status']==1) {?>
						<span>进行中</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['item']->value['prize_status']==2) {?>
						<span>缓冲中</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['item']->value['prize_status']==3) {?>
						<span>已结束</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['item']->value['prize_status']==4) {?>
						<span>已隐藏</span>
						<?php }?>
					</td>
					<td>
						<?php if ($_smarty_tpl->tpl_vars['item']->value['prize_auto']==1) {?>
						<span>自动</span>
						<?php } else { ?>
						<span>手动</span>
						<?php }?>
					</td>
					<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prize_admin_name'];?>
</td>
					<td>
						<?php if ($_smarty_tpl->tpl_vars['item']->value['prize_flag']==0) {?>
						<span>否</span>
						<?php } else { ?>
						<span>是</span>
						<?php }?>
					</td>
					<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['prize_add_date'],'%Y-%m-%d %H:%M:%S');?>
</td>
					<td>
						<?php if (($_smarty_tpl->tpl_vars['item']->value['prize_status']==0)||($_smarty_tpl->tpl_vars['item']->value['prize_status']==1&&$_smarty_tpl->tpl_vars['item']->value['prize_fact_num']==0)) {?>
						<a href="javascript:delePrize(<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">删除</a>&nbsp;&nbsp;
						<a href="javascript:viewPrize(<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">编辑</a>&nbsp;&nbsp;
						<?php }?>
						<?php if (($_smarty_tpl->tpl_vars['item']->value['prize_status']==1&&$_smarty_tpl->tpl_vars['item']->value['prize_fact_num']>0)||$_smarty_tpl->tpl_vars['item']->value['prize_status']==3||$_smarty_tpl->tpl_vars['item']->value['prize_status']==4) {?>
						<a href="javascript:viewPrize(<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">查看</a>&nbsp;&nbsp;
						<?php }?>
					</td>
				</tr>
				<?php } ?>	
				<?php }?>
			</table>
			<?php if ($_smarty_tpl->tpl_vars['list']->value) {?>
			<table class="baifenbai" style="background-color:#D5F2DB">
				<tr>
					<td align="center">
					<span>共<?php echo $_smarty_tpl->tpl_vars['page']->value['nu'];?>
条数据&nbsp;共<?php echo $_smarty_tpl->tpl_vars['page']->value['nc'];?>
页&nbsp;&nbsp;&nbsp;&nbsp;</span>	
					<?php if ($_smarty_tpl->tpl_vars['page']->value['nc']!=1) {?>
						<?php if ($_smarty_tpl->tpl_vars['page']->value['has_prev']!=0) {?>
			            	<a class="pagebox_pre_nolink" href="/a/prize/list?rn=<?php echo $_smarty_tpl->tpl_vars['page']->value['rn'];?>
&pn=<?php echo $_smarty_tpl->tpl_vars['page']->value['pn']-1;?>
&auto=<?php echo $_smarty_tpl->tpl_vars['auto']->value;?>
&status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">上一页</a>
						<?php }?>
						<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['page']->value['display_pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
							<a class="<?php if ($_smarty_tpl->tpl_vars['page']->value['pn']==$_smarty_tpl->tpl_vars['item']->value) {?> pagebox_num_nonce current<?php } else { ?> pagebox_num <?php }?>" href="<?php if ($_smarty_tpl->tpl_vars['page']->value['pn']==$_smarty_tpl->tpl_vars['item']->value) {?> javascript:void(0) <?php } else { ?> /a/prize/list?rn=<?php echo $_smarty_tpl->tpl_vars['page']->value['rn'];?>
&pn=<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
&auto=<?php echo $_smarty_tpl->tpl_vars['auto']->value;?>
&status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
 <?php }?>"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</a>
						<?php } ?>
						<?php if ($_smarty_tpl->tpl_vars['page']->value['has_next']!=0) {?>
			            	<a class="pagebox_next" id="pagelist" href="/a/prize/list?rn=<?php echo $_smarty_tpl->tpl_vars['page']->value['rn'];?>
&pn=<?php echo $_smarty_tpl->tpl_vars['page']->value['pn']+1;?>
&auto=<?php echo $_smarty_tpl->tpl_vars['auto']->value;?>
&status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
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
<?php echo $_smarty_tpl->getSubTemplate ("a/widgets/footer/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
