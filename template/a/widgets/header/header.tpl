<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="/a/static/css/style.css" />
	<link type="text/css" rel="stylesheet" href="/a/static/css/bootstrap.css"  />
	<link type="text/css" rel="stylesheet" href="/a/static/css/bootstrap-responsive.css" />
	<script type="text/javascript" src="/a/static/util/royalerp.js"></script>
	<script type="text/javascript" src="/a/static/util/jquery.js"></script>
	<script type="text/javascript" src="/a/static/util/unajax.js"></script>
	<script type="text/javascript" src="/a/static/util/dialog.js"></script>
	<script type="text/javascript" src="/a/static/util/upfile.js"></script>
</head>
<body>
	<input type="hidden" id="dllk" value="{$dllk}"/>
	<!--头部-->
	<div class="warp_bg">
		<div class="tou_top">
		
			<div id="top_right">
				<ul class="shouye">
					{if $modules}
					{foreach from=$modules key=i item=item}
					<li><a href="/a/index/index?mo={$item.key}">{$item.name}</a></li>
					{/foreach}
					{/if}
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
		<div id="user_position">{$admin}<span onclick="logout()" style="cursor:pointer;">[注销]</span></div>
		<div id="position_title">
			<span>
				<a>{$time}</a>
			</span>
		</div>
	</div>
	
	<div id="left_12">
		<div id="left_123">
			<div id="left_title"><span>{$key}</span></div>
			{if $menus}
			{foreach from=$menus key=i item=item}
			<div>
				<div id="bolck_a" class="ft_lt">
					<div class="xiaobiaoti_bg">
						<img src="/a/static/images/022.gif" style="margin-top:4px; margin-right:5px;" />
						<span>{$item.name}</span>
					</div>
					<div id="xiaobiaoti_kuang">
						{if $item.childs}
						{foreach from=$item.childs key=i item=limit}
						<ul>
							<li class="left_main1">
								<a href="{$limit.link}">
									<img src="/a/static/images/023.gif" style="margin-right:5px;border:0px;" />
									<span>{$limit.title}</span>
								</a>
							</li>
						</ul>
						{/foreach}
						{/if}
					</div>
				</div>
			</div>
			{/foreach}
			{/if}
		</div>
		<div id="right">