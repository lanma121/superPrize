//初始化
$(document).ready(function(){
  	$('#right').width($('#left_12').width()-$('#left_123').width()-5);
  	(function($){
  		if(!$("#exsitImgs").attr("id")){return;}
		var
			offLT = $("#exsitImgs").offset(),
			offl = offLT.left,
			offt = offLT.top,
			wid = $("#exsitImgs").width(),
			imgDiv = $("#exsitImgs div[name='imgDiv']"),
			imw = $(imgDiv[0]).outerWidth() + 10,
			rowNum = Math.floor(wid / imw),
			imh = $(imgDiv[0]).outerHeight() + 10,
			imgNum = imgDiv.length ,
			imgsL = imgNum * imw,
			left = offl + 10,
			right = imgsL > wid ? offl+ wid- imw : offl+ imgsL - imw,
			top = offt + 1,
			bottom =  imgsL > wid ? Math.ceil(imgsL/wid) * imh - imh + offt : offt;
			//console.log(offt+"    "+offl+"   "+wid+"   "+imw+"    "+rowNum+"    "+imh+"   "+imgN);
		function moveLoca(dragObj){
			dragObj.dragDrop({
				type:1,
				focuEle:"img",
				fixarea:{left:left,right:right,top:top,bottom:bottom},
				mouseUp:mouseUp
			});

		}
		function mouseUp(moveEle,locationData){// locationData数据对象，pageDown：鼠标按下位置，pageMove：鼠标拖动偏移量，startSet 拖动元素起始偏移量，endSet 最终移动位置；都以文档左上角为原点，横轴为：left，纵轴为：top
			moveEle.css("position","");
			var ml = locationData.endSet.left - locationData.startSet.left;
			var mt = locationData.endSet.top - locationData.startSet.top;
			var index = parseInt($("input[type='hidden']",moveEle).val());
			var moveNum = Math.round( ml / imw );		//横向移动的数量
			var mtNum = Math.round( mt /imh );			//纵向移动的行数
			var totalNum = mtNum * rowNum + moveNum + index;
			var finalNum = totalNum >= imgNum ?imgNum - 1 : totalNum;
			var divOBJ = $("#exsitImgs div:eq("+finalNum+")");
			finalNum > index ? divOBJ.after(moveEle.clone()) : divOBJ.before(moveEle.clone());
			moveEle.remove();
			moveLoca($("#exsitImgs div:eq("+finalNum+")").before());
			var x = index < finalNum ? index : finalNum;
			var y = finalNum > index ? finalNum : index;
			while(x <= y){
				$("#exsitImgs div:eq("+x+") input[type='hidden']").val(x);
				x++;
			}
		}
		moveLoca($("#exsitImgs div[name='imgDiv']"));

	}(jQuery));
});

//管理员退出
function logout(){
	$.MsgBox.Confirm('系统提示','确定要退出该系统吗？', function(){
		window.location.href='/a/index/logout';
	});
}