/********************************************AJAX上传图片信息****************************************/
jQuery.extend({
  	//创建 iframe 元素,接受提交及响应
  	upload_iframe:function(id, uri){
    	var frame_id = 'upload_frame' + id;
    	if(window.ActiveXObject){
      		//fix ie9 and ie 10-------------
      		if(jQuery.browser.version == "9.0" || jQuery.browser.version == "10.0"){
        		var io = document.createElement('iframe');
        		io.id = frame_id;
        		io.name = frame_id;
     		}else if(jQuery.browser.version == "6.0" || jQuery.browser.version == "7.0" || jQuery.browser.version == "8.0"){
        		var io = document.createElement('<iframe id="' + frame_id + '" name="' + frame_id + '" />');
        		switch(typeof uri){
					case 'boolean':
						io.src = 'javascript:false';
					break;
					case 'string':
						io.src = uri;
					break;

				}
      		}
    	}else{
      		var io = document.createElement('iframe');
      		io.id = frame_id;
      		io.name = frame_id;
   		}
    	io.style.position = 'absolute';
    	io.style.top = '-1000px';
    	io.style.left = '-1000px';
    	document.body.appendChild(io);
    	return io;
  	},

  	//创建 from 元素，用于提交的表单
  	upload_form:function(id, elementid, post_data){
    	//create form<span style="white-space:pre">	</span>
    	var form_id = 'upload_form' + id;
    	var file_id = 'upload_file' + id;
    	var form = $('<form  action="" method="POST" name="' + form_id + '" id="' + form_id + '" enctype="multipart/form-data"></form>');
    	var old_element = $('#' + elementid);
    	var new_element = $(old_element).clone();
   	 	$(old_element).attr('id', file_id);
    	$(old_element).before(new_element);
    	$(old_element).appendTo(form);
    	//添加自定义参数
    	if(post_data){
      		//递归遍历JSON所有键值
      		function recur_json(json){
        		for(var i in json){
	          		//alert(i+"="+json[i])
	          		$("<input name='" + i + "' id='" + i + "' value='" + json[i] + "' />").appendTo(form);
	          		if(typeof json[i] == "object"){
	            		recur_json(json[i]);
	          		}
        		}
      		}
      		recur_json(post_data);
    	}
	    //set attributes
	    $(form).css('position', 'absolute');
	    $(form).css('top', '-1200px');
	    $(form).css('left', '-1200px');
	    $(form).appendTo('body');
	    return form;
  	},
  	//上传文件
  	//s 参数：json对象
  	file_upload:function(s){
    	s = jQuery.extend({fileFilter:"",fileSize:0}, jQuery.ajaxSettings, s);
    	//文件筛选
    	var fiel_name = $('#' + s.elementid).val();
    	var extention = fiel_name.substring(fiel_name.lastIndexOf(".") + 1).toLowerCase();
    	if(s.fileFilter && s.fileFilter.indexOf(extention) < 0){
      		alert("仅支持 (" + s.fileFilter + ") 为后缀名的文件!");
      		return;
    	}
    	//文件大小限制
    	if(s.fileSize > 0){
      		var fs = 0;
      		try{
        		if(window.ActiveXObject){
	          		//IE浏览器
	          		var image = new Image();
	          		image.dynsrc = fiel_name;
	          		fs = image.fileSize;
        		}else{
          			fs = $('#' + s.elementid)[0].files[0].size;
        		}
      		}catch(e){
	
      		}
	      	if(fs > s.fileSize){
	        	alert("当前文件大小 (" + fs + ") 超过允许的限制值 (" + s.fileSize +")！");
	        	return;
	      	}
    	}
    	var id = new Date().getTime();
    	//创建 form 表单元素
    	var form = jQuery.upload_form(id, s.elementid, s.data);
    	//创建 iframe 贞元素
    	var io = jQuery.upload_iframe(id, s.secureuri);
    	var frame_id = 'upload_frame' + id;
    	var form_id = 'upload_form' + id;
    	//监测是否有新的请求
    	if(s.global && !jQuery.active++){
      		jQuery.event.trigger("ajaxStart"); //触发 AJAX 请求开始时执行函数。Ajax 事件。
    	}
    	var request_done = false;
    	//创建请求对象
    	var xml = {};
    	if(s.global){
			jQuery.event.trigger("ajaxSend", [xml, s]); //触发 AJAX 请求发送前事件
		}
    	//上载完成的回调函数
    	var upload_callback = function(is_timeout){
      		var io = document.getElementById(frame_id);
	      	try{
	        	//存在跨域脚本访问问题，如遇到‘无法访问’提示则需要在响应流中加一段脚块：<script ...>document.domain = 'xxx.com';</script>
	        	if(io.contentWindow){ //兼容各个浏览器，可取得子窗口的 window 对象
	          		xml.responseText = io.contentWindow.document.body ? io.contentWindow.document.body.innerHTML : null;
	          		xml.responseXML = io.contentWindow.document.XMLDocument ? io.contentWindow.document.XMLDocument : io.contentWindow.document;
	        	}else if(io.contentDocument){ //contentDocument Firefox 支持，> ie8 的ie支持。可取得子窗口的 document 对象。
	          		xml.responseText = io.contentDocument.document.body ? io.contentDocument.document.body.innerHTML : null;
	          		xml.responseXML = io.contentDocument.document.XMLDocument ? io.contentDocument.document.XMLDocument : io.contentDocument.document;
	        	}
	      	}catch(e){
	        	jQuery.handle_error_ext(s, xml, null, e);
	     	}
      		if(xml || is_timeout == "timeout"){
	        	request_done = true;
	        	var status;
	        	try{
	          		status = is_timeout != "timeout" ? "success" : "error";
	          		// Make sure that the request was successful or notmodified
	          		if(status != "error"){
	            		//处理数据（运行XML通过httpData不管回调）
	            		var data = jQuery.upload_http_data(xml, s.datatype);
	            		// If a local callback was specified, fire it and pass it the data
	            		if(s.success){
							s.success(data, status);
						}
	            		// Fire the global callback
		            	if(s.global){
							jQuery.event.trigger("ajaxSuccess", [xml, s]);
						}
	          		}else{
						jQuery.handle_error_ext(s, xml, status);
					}
	        	}catch(e){
	          		status = "error";
	          		jQuery.handle_error_ext(s, xml, status, e);
	        	}
	        	// The request was completed
	        	if(s.global){
					jQuery.event.trigger("ajaxComplete", [xml, s]);
				}
	        	// Handle the global AJAX counter
	        	if(s.global && !--jQuery.active){
					jQuery.event.trigger("ajaxStop");
				}
	        	// Process result
	        	if(s.complete){
					s.complete(xml, status);
				}
	        	jQuery(io).unbind();
	        	setTimeout(function(){
			        try{
			            $(io).remove();
			            $(form).remove();
			        }catch(e){
			            jQuery.handle_error_ext(s, xml, null, e);
			        }
	        	}, 100);
	        	xml = null;
      		}
    	};
	    //超时检查，s.timeout 毫秒后调用 upload_callback 回调函数提示请求超时
	    if(s.timeout > 0){
	      	setTimeout(function(){
	        	// Check to see if the request is still happening
	        	if(!request_done){
					upload_callback("timeout");
				}
	      	}, s.timeout);
	    }
	    try{
	      	//设置动态 form 表单的提交参数
	      	// var io = $('#' + frame_id);
	      	var form = $('#' + form_id);
	      	$(form).attr('action', s.url);
	      	$(form).attr('method', 'POST');
	      	$(form).attr('target', frame_id);
	      	if(form.encoding){
	      		form.encoding = 'multipart/form-data';
	      	}else{
	        	form.enctype = 'multipart/form-data';
	      	}
	      	$(form).submit();
	    }catch(e){
	      	jQuery.handle_error_ext(s, xml, null, e);
	    }
	    //向动态表单的页面加载事件中注册回调函数
	    if(window.attachEvent){
	      	document.getElementById(frame_id).attachEvent('onload', upload_callback);
	    }else{
	      	document.getElementById(frame_id).addEventListener('load', upload_callback, false);
	    }
	    return{
	      	abort:function(){}
	    };
  	},
  	//上传文件
  	upload_http_data:function(r, type){
	    //alert("type=" + type + ";upload_http_data" + JSON.stringify(r))
	    var data = !type;
	    data = type == "xml" || data ? r.responseXML : r.responseText;
	    // If the type is "script", eval it in global context
	    if(type == "script"){
			jQuery.globalEval(data);
		}
	    // Get the JavaScript object, if JSON is used.
	    if(type == "json"){
			eval("data = " + data);
		}
	    // evaluate scripts within html
	    if(type == "html"){
			jQuery("<div>").html(data).evalScripts();
		}
    	//alert($('param', data).each(function(){alert($(this).attr('value'));}));
    	return data;
  	},
  	handle_error_ext: function(s, xhr, status, e){
    	// If a local callback was specified, fire it
    	if(s.error){
      		s.error.call(s.context || s, xhr, status, e);
    	}
   	 	// Fire the global callback
    	if(s.global){
      		(s.context ? jQuery(s.context) : jQuery.event).trigger("ajaxError", [xhr, s, e]);
    	}
  	}
});
