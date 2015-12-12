{include file="a/widgets/header/header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" class="baifenbai" id="list_table">
	<tr id="xuankuang">
		<td height="18" colspan="10">&nbsp;<img src="/a/static/images/024.jpg"/>当前的位置：奖品列表</td>
		<td align="center"><a href="javascript:addPrize()">添加奖品</a></td>
		<td align="right">
			<span>奖品状态:</span>
			<select onchange="window.location.href='/a/prize/list?&auto={$auto}&status='+this.value;">
				{if $statusList}
				{foreach from=$statusList key=i item=item}
				{if $status eq $i}
				<option value="{$i}" selected>{$item}</option>
				{else}
				<option value="{$i}">{$item}</option>
				{/if}
				{/foreach}	
				{/if}	
			</select>
			<span>开奖类型:</span>
			<select onchange="window.location.href='/a/prize/list?status={$status}&auto='+this.value;">
				{if $autoList}
				{foreach from=$autoList key=i item=item}
				{if $auto eq $i}
				<option value="{$i}" selected>{$item}</option>
				{else}
				<option value="{$i}">{$item}</option>
				{/if}
				{/foreach}	
				{/if}	
			</select>
			<span>奖品编号:</span>
			<input type="text" size="20" value="{$code}" onblur="if(this.value!='') window.location.href='/a/prize/list?code='+this.value;"/>
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
				{if $list}
				{foreach from=$list key=i item=item}
				<tr align="center" bgcolor="#FFFFFF" style="height:24px;" class="content">
					<td>{$item.id}</td>
					<td>{$item.prize_phase}</td>
					<td>{$item.prize_code}</td>
					<td>{$item.prize_short_title}</td>
					<td>{$item.prize_draw_currency}</td>
					<td>{$item.prize_min_num}</td>
					<td>{$item.prize_fact_num}</td>
					<td>{$item.prize_price}</td>
					<td>
						{if $item.prize_status eq 0}
						<span>待开放</span>
						{else if $item.prize_status eq 1}
						<span>进行中</span>
						{else if $item.prize_status eq 2}
						<span>缓冲中</span>
						{else if $item.prize_status eq 3}
						<span>已结束</span>
						{else if $item.prize_status eq 4}
						<span>已隐藏</span>
						{/if}
					</td>
					<td>
						{if $item.prize_auto eq 1}
						<span>自动</span>
						{else}
						<span>手动</span>
						{/if}
					</td>
					<td>{$item.prize_admin_name}</td>
					<td>
						{if $item.prize_flag eq 0}
						<span>否</span>
						{else}
						<span>是</span>
						{/if}
					</td>
					<td>{$item.prize_add_date|date_format:'%Y-%m-%d %H:%M:%S'}</td>
					<td>
						{if ($item.prize_status eq 0) || ($item.prize_status eq 1 && $item.prize_fact_num eq 0)}
						<a href="javascript:delePrize({$item.id})">删除</a>&nbsp;&nbsp;
						<a href="javascript:viewPrize({$item.id})">编辑</a>&nbsp;&nbsp;
						{/if}
						{if ($item.prize_status eq 1 && $item.prize_fact_num gt 0) || $item.prize_status eq 3 || $item.prize_status eq 4}
						<a href="javascript:viewPrize({$item.id})">查看</a>&nbsp;&nbsp;
						{/if}
					</td>
				</tr>
				{/foreach}	
				{/if}
			</table>
			{if $list}
			<table class="baifenbai" style="background-color:#D5F2DB">
				<tr>
					<td align="center">
					<span>共{$page.nu}条数据&nbsp;共{$page.nc}页&nbsp;&nbsp;&nbsp;&nbsp;</span>	
					{if $page.nc != 1}
						{if $page.has_prev != 0}
			            	<a class="pagebox_pre_nolink" href="/a/prize/list?rn={$page.rn}&pn={$page.pn-1}&auto={$auto}&status={$status}">上一页</a>
						{/if}
						{foreach from=$page.display_pages key=i item=item}
							<a class="{if $page.pn eq $item} pagebox_num_nonce current{else} pagebox_num {/if}" href="{if $page.pn eq $item} javascript:void(0) {else} /a/prize/list?rn={$page.rn}&pn={$item}&auto={$auto}&status={$status} {/if}">{$item}</a>
						{/foreach}
						{if $page.has_next != 0}
			            	<a class="pagebox_next" id="pagelist" href="/a/prize/list?rn={$page.rn}&pn={$page.pn+1}&auto={$auto}&status={$status}"> 下一页</a>
			            {/if}
					{/if}
					</td>
				</tr>
			</table>
			{/if}
		</td>
	</tr>		
</table>
{include file="a/widgets/footer/footer.tpl"}
