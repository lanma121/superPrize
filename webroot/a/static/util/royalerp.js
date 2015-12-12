function getAbsPoint(e){
  var x = e.offsetLeft;
  var y = e.offsetTop;
  while(e = e.offsetParent){
    x += e.offsetLeft;
    y += e.offsetTop;
  }
  return {"x": x, "y": y};
}
function getBroserSize() 
{
   var xScroll, yScroll,windowWidth,windowHeight,pageHeight,pageWidth;     
   if (window.innerHeight && window.scrollMaxY) {     
       xScroll = document.body.scrollWidth; 
       yScroll = window.innerHeight + window.scrollMaxY; 
   } else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac 
       xScroll = document.body.scrollWidth; 
       yScroll = document.body.scrollHeight; 
   } else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari 
       xScroll = document.body.offsetWidth; 
       yScroll = document.body.offsetHeight; 
   }

    
   if (self.innerHeight) {    // all except Explorer 
       windowWidth = self.innerWidth; 
       windowHeight = self.innerHeight; 
   } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode 
       windowWidth = document.documentElement.clientWidth; 
       windowHeight = document.documentElement.clientHeight; 
   } else if (document.body) { // other Explorers 
       windowWidth = document.body.clientWidth; 
       windowHeight = document.body.clientHeight; 
   }    
    
   if(yScroll < windowHeight){ 
       pageHeight = windowHeight; 
   } else { 
       pageHeight = yScroll; 
   }

   if(xScroll < windowWidth){     
       pageWidth = windowWidth; 
   } else { 
       pageWidth = xScroll; 
   } 
   return {"x": pageWidth, "y": pageHeight};
   
}
function RoyalalertWin(title,content,width,closeid){
 var iWidth = document.documentElement.clientWidth; 
 var iHeight = document.documentElement.clientHeight;
 var string='<div style="display:block;position:absolute;left:0px;top:0px;width:'+iWidth+'px;height:'+Math.max(document.body.clientHeight, iHeight)+'px;filter:Alpha(Opacity=30);opacity:0.3;background-color:#000000;z-index:101;"></div>';
 string+='<div style="position:absolute;top:'+(iHeight-100)/2+'px;left:'+(iWidth-400)/2+'px;width:400px;text-align:center;border:1px solid #4466ee;background-color:white;padding:1px;line-height:22px;z-index:102;">';
 string+='<table style="margin:0px;border:0px;padding:0px;width:100%;"><tr style="background-color:#4466ee;"><td style="color:#ffffff"><b>'+title+'</b></td></tr><tr><td>'+content+'</td></tr></table></div></div>';
 if(document.getElementById('phpeip_message_stack')){
 	document.getElementById('phpeip_message_stack').innerHTML = string;
 } else {
 	string='<div id="phpeip_message_stack">'+string+'</div>';
 }
 document.body.innerHTML = document.body.innerHTML+string;
 var closebtn1 = document.getElementById(closeid);
 if(closebtn1!="undefined"){
 	closebtn1.onclick=function(){
 	  var ccc =document.getElementById('phpeip_message_stack');
	  document.body.removeChild(ccc);
	}
 }
}
var phpeip_checkrepeatsubmit = false;
function checkrepeatsubmit(){
	if(phpeip_checkrepeatsubmit==false) {
		phpeip_checkrepeatsubmit=true;
		return true;
	}
	alert("请不要重复提交！");
	return false;
}
function NavType(){
	if(window.navigator.userAgent.indexOf("MSIE")>=1) return 'IE';
	else if(window.navigator.userAgent.indexOf("Firefox")>=1) return 'FF';
	else return "OT";
}
var selectbgObj;
function phpeip_showmenudiv(objname,width,text) {
		if(selectbgObj){
			var tmp = selectbgObj;
			selectbgObj = null;
			document.body.removeChild(tmp); 
		} else {
			var obj = document.getElementById(objname);
			if(obj){
				var xy = getAbsPoint(obj);
			    var bgObj = document.createElement("div"); 
				bgObj.style.cssText = "position:absolute;left:"+xy.x+"px;top:"+(xy.y+20)+"px;width:"+width+"px;background-color:#ffffff;z-index:101;display:bolck;border:solid 1px blue;";
				bgObj.innerHTML = text;
				document.body.appendChild(bgObj); 
				selectbgObj = bgObj;
			}
		}
}
function GetCookie(c_name)
{
	if (document.cookie.length > 0)
	{
		c_start = document.cookie.indexOf(c_name + "=")
		if (c_start != -1)
		{
			c_start = c_start + c_name.length + 1;
			c_end   = document.cookie.indexOf(";",c_start);
			if (c_end == -1)
			{
				c_end = document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return null
}
function SetCookie(c_name,value,expiredays)
{
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString())+"; path=/"; //使设置的有效时间正确。增加toGMTString()
}

function ShowPic(file,img,imgname) {
	var fileobj = document.getElementById(file);
	var imgobj = document.getElementById(img);
	fileobj.value = imgname.value;
	if(imgname.files){ 	  
	 	if(imgobj)imgobj.src = imgname.files[0].getAsDataURL(); 
	} else {
		if(imgobj){
			imgobj.style.display = "none";
		    document.getElementById(img+"_div").filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgname.value;
		}
	}
}

function SelectImage(picname,path){
	if(path=='')path = "select_images.php";
	if(NavType()=="IE"){ var posLeft = window.event.clientX-420; var posTop = window.event.clientY+160; }
	else{ var posLeft = 320; var posTop = 400; }
	var val = window.showModalDialog(path, "picname", "dialogWidth:700px; dialogHeight:500px; help: no; scroll: yes; status: no");
	if(val != undefined && val.length > 1) 
	{
		document.getElementById(picname).value=val;
	}
}

function phpeip_load_array(d){
	var r = [],f = [],e  = d.split("|");
	var e0 = e[0].split(",");
	for(var i=0;i<e0.length;i++){
		f.push(e0[i]);
	}
	var ej;
	for(var i=1;i<e.length;i++){
		var b={};
		ej = e[i].split(",");
		for(var j=0;j<ej.length;j++){
			b[f[j]] = ej[j];
		}
		r.push(b);
	}
	return r;
}