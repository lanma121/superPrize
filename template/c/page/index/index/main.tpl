<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<link type="text/css" rel="stylesheet" href="/c/static/css/main.css"/>
<link rel="stylesheet" href="http://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<title>CAR FOR CAR</title>
</head>
<body>
<!-- jquery mobile 页面 -->
<!-- 
<div data-role="page" id="pageone">

	<div data-role="header">
		<h1>欢迎访问我的主页</h1>
	</div>
	
	<div data-role="main" class="ui-content">
		<p>欢迎!</p>
    	<a href="#pagetwo">弹出对话框</a>
	</div>
	
	<div data-role="footer">
		<h1>底部文本</h1>
	</div>
</div>

<div data-role="page" data-dialog="true" id="pagetwo">

	<div data-role="header">
		<h1>我是一个对话框！</h1>
	</div>
	
	<div data-role="main" class="ui-content">
		<p>对话框与普通页面不同，它显示在当期页面上, 但又不会填充完整的页面，顶部图标 "X" 用于关闭对话框。</p>
		<a href="#pageone">跳转到第一个页面</a>
	</div>
	
	<div data-role="footer">
		<h1>对话框底部文本</h1>
	</div>
</div>
-->
<!-- jquery mobile 过渡 -->
<!-- 
<div data-role="page" id="pageone">
	<div data-role="header">
		<h1>欢迎来到我的主页</h1>
	</div>
	<div data-role="main" class="ui-content">
		<p>点击链接查看淡入效果 (页面从右至左淡入)。</p>
		<a href="#pagetwo" data-transition="slide">淡入第二个页面</a>
	</div>
	<div data-role="footer">
		<h1>底部文本</h1>
	</div>
</div>
<div data-role="page" id="pagetwo">
	<div data-role="header">
		<h1>欢迎来到我的主页</h1>
	</div>
	<div data-role="main" class="ui-content">
		<p>点击链接查看相反方向的淡入效果 (页面从左至右淡入)。</p>
		<a href="#pageone" data-transition="slide" data-direction="reverse">淡入第一个页面(reversed)</a>
	</div>
	<div data-role="footer">
		<h1>底部文本</h1>
	</div>
</div>
 -->
<!-- jquery mobile 导航栏 -->
<!-- 
<div data-role="page" id="pageone">
	<div data-role="header">
		<h1>欢迎访问我的主页</h1>
		<div data-role="navbar">
			<ul>
				<li><a href="#">主页</a></li>
				<li><a href="#">第二页</a></li>
				<li><a href="#">搜索</a></li>
			</ul>
		</div>
	</div>
	<div data-role="main" class="ui-content">
		<p>我的内容..</p>
	</div>
	<div data-role="footer">
		<h1>我的底部</h1>
	</div>
</div>
--> 
<!-- jquery mobile 面板 -->
<!-- 
<div data-role="page" id="pageone">
	<div data-role="panel" id="myPanel"> 
		<h2>面板头部</h2>
		<p>你可以通过点击面板外部区域或按下 Esc 键或滑动来关闭面板。</p>
	</div>
	<div data-role="header">
		<h1>页面头部</h1>
	</div>
	<div data-role="main" class="ui-content">
		<p>点击下面按钮打开面板。</p>
		<a href="#myPanel" class="ui-btn ui-btn-inline ui-corner-all ui-shadow">打开面板</a>
	</div>
	<div data-role="footer">
		<h1>页面底部</h1>
	</div>
</div>
-->
<!-- jQuery Mobile 可折叠块 -->
<!--  
<div data-role="page" id="pageone">
	<div data-role="header">
		<h1>可折叠块</h1>
	</div>
	<div data-role="main" class="ui-content">
		<div data-role="collapsible" data-collapsed="true">
			<h1>点击我 - 我可以折叠！</h1>
			<p>我是可折叠的内容。</p>
		</div>
	</div>
	<div data-role="footer">
		<h1>页脚文本</h1>
	</div>
</div>
-->
<!-- jQuery Mobile 表格 -->
<div data-role="page" id="pageone">
	<div data-role="header">
		<h1>列切换</h1>
	</div>
	<div data-role="main" class="ui-content">
		<p>列切换模型会在宽度不够时隐藏数据。</p>
		<h4>慢慢重置窗口大小。你会发现表格中的列会根据窗口的大小自动隐藏列。</h4>
		<table data-role="table" data-mode="columntoggle" class="ui-responsive" id="myTable">
			<thead>
				<tr>
					<th data-priority="6">CustomerID</th>
					<th data-priority="1">CustomerName</th>
		          	<th data-priority="2">ContactName</th>
		          	<th data-priority="3">Address</th>
		          	<th data-priority="4">City</th>
	          		<th data-priority="5">PostalCode</th>
		          	<th>Country</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
		          	<td>Alfreds Futterkiste</td>
		          	<td>Maria Anders</td>
		          	<td>Obere Str. 57</td>
		          	<td>Berlin</td>
		          	<td>12209</td>
		          	<td>Germany</td>
				</tr>
				<tr>
	          		<td>2</td>
	          		<td>Antonio Moreno Taquer</td>
		          	<td>Antonio Moreno</td>
		          	<td>Mataderos 2312</td>
		          	<td>Mico D.F.</td>
		          	<td>05023</td>
		          	<td>Mexico</td>
	        	</tr>
	        	<tr>
		          	<td>3</td>
		          	<td>Around the Horn</td>
		          	<td>Thomas Hardy</td>
		          	<td>120 Hanover Sq.</td>
		          	<td>London</td>
		          	<td>WA1 1DP</td>
		          	<td>UK</td>
		        </tr>
		        <tr>
		          	<td>4</td>
		          	<td>Berglunds snabbk</td>
		          	<td>Christina Berglund</td>
		          	<td>Berguvsven 8</td>
		          	<td>Lule</td>
		          	<td>S-958 22</td>
		          	<td>Sweden</td>
		        </tr>
			</tbody>
		</table>
	</div>
	<div data-role="footer">
		<h1>底部文本</h1>
	</div>
</div>
</body>
</html>