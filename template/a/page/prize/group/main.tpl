{include file="a/widgets/header/header.tpl"}
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
				{if $list}
				{foreach from=$list key=i item=item}
				<tr align="center" bgcolor="#FFFFFF" height="24">
					<td>{$item.id}</td>
					<td>{$item.prize_group_name}</td>
					<td>{$item.prize_group_remark}</td>
					<td>{$item.prize_group_adate}</td>
					<td>{$item.prize_group_edate}</td>
					<td>
						<a href="javascript:editGroup({$item.id})">编辑</a>
						<a href="javascript:delGroup({$item.id})">删除</a>
					</td>
				</tr>
				{/foreach}
				{/if}
			</table>
			{if $list}
			<table class="baifenbai" style="background-color:#D5F2DB">
				<tr>
					<td align="center">
					{if $page.nc != 1}
						{if $page.has_prev != 0}
			            	<a class="pagebox_pre_nolink" href="/a/prize/group?rn={$page.rn}&pn={$page.pn-1}">上一页</a>
						{/if}
						{foreach from=$page.display_pages key=i item=item}
							<a class="{if $page.pn eq $item} pagebox_num_nonce current{else} pagebox_num {/if}" href="{if $page.pn eq $item} javascript:void(0) {else} /a/prize/group?rn={$page.rn}&pn={$item} {/if}">{$item}</a>
						{/foreach}
						{if $page.has_next != 0}
			            	<a class="pagebox_next" id="pagelist" href="/a/prize/group?rn={$page.rn}&pn={$page.pn+1}"> 下一页</a>
			            {/if}
					{/if}
					</td>
				</tr>
			</table>
			{/if}
		</td>
	</tr>
</table>
<script type="text/javascript" src="/a/static/page/prize/group/group.js"></script>
{include file="a/widgets/footer/footer.tpl"}
