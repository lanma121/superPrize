
//选择验证方式
function findWay(type){
	$('#checkType').text(((type==1)?'邮  箱':'手  机'));
}

//获取验证码
function getCode(){
	var wayType = $('input[name="way"]:checked').val();
	var userName = all_trim($('#userName').val());
	var passWord = all_trim($('#passWord').val());
	var condition = all_trim($('#condition').val());
	var message = (wayType==1)?'电子邮箱':'手机号码';
	if(userName == ''){
		$('#userName').focus();
		$.MsgBox.Alert('系统警告', '请填写用户名!');
		return;
	}
	if(passWord == ''){
		$('#passWord').focus();
		$.MsgBox.Alert('系统警告', '请填写密码!');
		return;
	}
	if(condition == ''){
		$('#condition').focus();
		$.MsgBox.Alert('系统警告', '请填写'+message+'!');
		return;
	}
	var reg = new RegExp(/[a-z0-9]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z])?/i);
	if(wayType==2){
		reg = new RegExp(/^1[3|4|5|7|8][0-9]\d{4,8}$/); 
	}
	if(!reg.exec(condition)){
		$('#condition').val('');
		$.MsgBox.Alert('系统警告', message+'格式不正确!');
	}else{
		var mydata = 'userName='+userName+'&passWord='+passWord+'&condition='+condition+'&wayType='+wayType;
		var object = json_ajax('/a/asyn/code',mydata,'POST');
		if(object && object.result){
			switch(parseInt(object.result)){
				case 1:
					$.MsgBox.Alert('系统警告', '数据信息不正确!');
				break;
				case 2:
					$.MsgBox.Alert('系统警告', '当前账号不存在!');
				break;
				case 3:
					$.MsgBox.Alert('系统警告', '当前密码错误!');
				break;
				case 4:
					if(wayType==1){
						$.MsgBox.Alert('系统警告', '管理员邮箱未指定!');
					}else{
						$.MsgBox.Alert('系统警告', '管理员手机未指定!');
					}
				break;
				case 5:
					$.MsgBox.Alert('系统警告', '发送失败请重新发送!');
				break;
				case 6:
					$.MsgBox.Alert('系统提示', '发送成功请重注意查收!');
				break;
			}
		}else{
			$.MsgBox.Alert('系统警告', '系统繁忙请稍后再试!');
		}
	}
}

//管理员登录
function Login(){
	var wayType = $('input[name="way"]:checked').val();
	var userName = all_trim($('#userName').val());
	var passWord = all_trim($('#passWord').val());
	var condition = all_trim($('#condition').val());
	var authInput = all_trim($('#authInput').val()); 
	var message = (wayType==1)?'电子邮箱':'手机号码';
	if(userName == ''){
		$('#userName').focus();
		$.MsgBox.Alert('系统警告', '请填写用户名!');
		return;
	}
	if(passWord == ''){
		$('#passWord').focus();
		$.MsgBox.Alert('系统警告', '请填写密码!');
		return;
	}
	if(condition == ''){
		$('#condition').focus();
		$.MsgBox.Alert('系统警告', '请填写'+message+'!');
		return;
	}
	if(authInput==''){
		$('#authInput').focus();
		$.MsgBox.Alert('系统警告', '请填写验证码!');
		return;
	}
	var mydata = 'authInput='+authInput;
	var object = json_ajax('/a/asyn/login',mydata,'POST');
	if(object && object.result){
		switch(parseInt(object.result)){
			case 1:
				$.MsgBox.Alert('系统警告', '数据信息不正确!');
			break;
			case 2:
				$.MsgBox.Alert('系统警告', '验证码错误!');
			break;
			case 3:
				$.MsgBox.Alert('系统提示', '验证通过!');
				window.location.href = '/a/index/index';
			break;	
		}
	}else{
		$.MsgBox.Alert('系统警告', '系统繁忙请稍后再试!');
	}
}