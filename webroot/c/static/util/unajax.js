//消息类型AJAX【异步】
function msgs_ajax(url,data,type,tip,rod,off){
	$.ajax({
		url:url,
		data:data,
		type:type,
		beforeSend:function(){
			if(!off){
				set_shield(true);
			}
		},
		success:function(res){
			if(tip == true){
				if(res == 'success' || res == 1){
					alert('操作成功!');
				}else{
				  	alert('操作失败!');			  
				}
			}	
			if(rod == true){
				window.location.reload();
			}
		},
		complete:function(){
			if(!off){
				set_shield(false);
			}
		}
	});
}

//数据类型AJAX【同步】 
function data_ajax(url,data,type,off){
	var result = 0;
	$.ajax({
		url:url,
		data:data,
		type:type,
		async:false,
		beforeSend:function(){
			if(!off){
				set_shield(true);
			}
		},
		success:function(res){
			result = res;
		},
		complete:function(){
			if(!off){
				set_shield(false);
			}
		}
    });
	return result;
}

//JSON类型AJAX【同步】
function json_ajax(url,data,type,off){
	var result = 0;
	$.ajax({
		url:url,
		data:data,
		type:type,
		async:false,
		dataType:'json',
		beforeSend:function(){
			if(!off){
				set_shield(true);
			}
		},
		success:function (res,st){
			result = res.data;
		},
		complete:function(){
			if(!off){
				set_shield(false);
			}
		}
	});
	return result;
}

//过滤 字符串左侧空格
function left_trim(string){
	var pattern = new RegExp('^[\\s]+','gi');
	return string.replace(pattern,'');	
}

//过滤字符串左侧空格
function right_trim(string){
	var pattern = new RegExp('[\\s]+$','gi');
	return string.replace(pattern,'');	
}

//过滤字符串左右侧空格
function all_trim(string){
	return right_trim(left_trim(string));
}

//自动给字符串加引号
function quotes_string(str){
	return "'"+str+"'";
}

//截取字符串
function set_string(str,len){
	var strlen = 0; 
	var s = '';
	for(var i = 0;i < str.length;i++){
		if(str.charCodeAt(i) > 128){
			strlen += 2;
		}else{ 
			strlen++;
		}
		s += str.charAt(i);
		if(strlen >= len){ 
			return s ;
		}
	}
	return s;
}

//显示注册提示消息
function set_message(id,color,msg){
	var html_msg = '<span style="color:'+color+'">'+msg+'</span>';
	return $("#"+id).html(html_msg);
}

//设置屏蔽罩
function set_shield(off){
	var ovid = document.getElementById('mydiv');
	if(ovid){
		document.body.removeChild(ovid);
	}
	//正在加载请稍候......
	//var imag = '<img src="/images/002.gif" width="124px" height="124px"/>';
	var imag = '';
	var html = '<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0);z-index:2;width:100%;height:100%;">';
	html += '<div style="width:200px;height:200px;margin:300px auto;">';
	html += '<span style="color:white;font-size:14px;font-weight:bold;">'+imag+'</span>';
	html += '</div>';
	html += '</div>';
	var ndiv = document.createElement('div');
	ndiv.id = 'mydiv';
	ndiv.innerHTML = html;
	document.body.appendChild(ndiv);
	if(!off){
		setTimeout(function(){
			$('#outerdiv').hide();
		},1000);
	}
}

//全选/反选
function choice_box(obj,name){
	$("input[type='checkbox'][name='"+name+"[]']").each(function(){
		if($(obj).is(':checked') == true){
			$(this).attr('checked',true);
		}else{
			$(this).attr('checked',false);
		}
	});
}

//产生随消息
function random_msg(){
	var chars = [
	    '紧张的时刻即将到来!',
	    '好激动好激动，马上就开奖啦!',
	    '亲，还犹豫什么；奖品马上就是你的了!',
	    '下一秒就是你!',
	    '此刻，我的心情是复杂而又忐忑!',
	    '这就是我的...中奖肯定是我...',
	    '我的未来不是梦，来了........',
	    '我告诉自己，这是真的，这不是梦!',
	    '梦想在继续，大奖在等你!',
	    '您所期待的时刻，马上就要来临了',
	    '你的命运注定在此刻改变!',
	    '花落谁家，非你莫属!',
	    '亲，脱掉衬衣大吼大叫可以提高中奖概率!',
	    '奖品这么大，还不来试试'
	];
	var range = chars.length-1;
	var randb = Math.random();
	var randx = Math.round(randb * range);
	return chars[randx];
}

