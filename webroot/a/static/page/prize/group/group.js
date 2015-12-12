//初始化
$(document).ready(function(){
	$('#viwe_table').hide();
});

//检查分类名称
function checkName(){
	var result = 0;
	var name = all_trim($('#groupName').val());
	var oname = all_trim($('#oname').val());
	if(name!=''){
		if(!isNaN(name)){
			$('#groupName').val('');
			set_message('msgName','red','名称不能全是数字!');
		}else{
			var mydata = 'name='+name;
			var object = json_ajax('/a/asyn/check',mydata,'POST');
			if(object && object.result){
				switch(parseInt(object.result)){
					case 1:
						set_message('msgName','red','数据信息异常!');
					break;
					case 2:
						if($('#oid').val()>0){
							set_message('msgName','blue','当前名称无更新!');
						}else{
							$('#groupName').val('');
							set_message('msgName','red','当前名称已经存在!');
						}
					break;
					case 3:
						result = 1;
						set_message('msgName','green','当前名称可以使用!');
					break;
				}
			}else{
				set_message('msgName','black','系统繁忙!');
			}
		}
	}else{
		set_message('msgName','red','请填写名称!');
	}
	return result;
}

//检查分类备注
function checkMark(){
	var result = 0;
	var remark = all_trim($('#groupMark').val());
	var oremark = all_trim($('#oremark').val());
	if(remark!=''){
		if(!isNaN(remark)){
			$('#groupMark').val('');
			set_message('msgMark','red','备注信息不能全是数字!');
		}else if(remark.length < 20){
			set_message('msgMark','red','备注信息不能少于20个字符!');
		}else{
			if(remark==oremark){
				set_message('msgMark','blue','当前备注无更新!');
			}else{
				result = 1;
				set_message('msgMark','green','当前备注可以使用!');
			}
		}
	}else{
		set_message('msgMark','red','请填写备注!');
	}
	return result;
}

//添加/编辑大奖的分类
function oper(){
	var resultName = checkName();
	var resultMark = checkMark();
	var groupId = parseInt($('#oid').val());
	var groupName = all_trim($('#groupName').val());
	var groupMark = all_trim($('#groupMark').val());
	if(resultName==1 && resultMark==1){
		$.MsgBox.Confirm('系统警告','确定要执行该操作吗？', function(){
			var mydata = 'name='+groupName+'&mark='+groupMark+'&id='+groupId;
			var object = json_ajax('/a/asyn/oper',mydata,'POST');
			if(object && object.result){
				switch(parseInt(object.result)){
					case 1:
						$.MsgBox.Alert('系统警告', '数据信息异常!');
					break;
					case 2:
						$.MsgBox.Alert('系统警告', '数据编辑成功!');
					break;
					case 3:
						$.MsgBox.Alert('系统提示', '数据新增成功!');
					break;
					case 4:
						$.MsgBox.Alert('系统警告', '数据操作失败!');
					break;
				}
			}else{
				$.MsgBox.Alert('系统警告', '系统繁忙!');
			}
		});	
	}
}

//添加分类
function addGroup(){
	$('#viwe_table').show();
	$('#list_table').hide();
	$('#add').val('添加');
	$('#msgTitle').text('添加');
}
	
//编辑分类
function editGroup(id){
	if(parseInt(id)>0){
		$('#add').val('编辑');
		$('#msgTitle').text('编辑');
		var mydata = 'id='+id;
		var object = json_ajax('/a/asyn/view',mydata,'POST');
		if(object && object.result){
			$('#viwe_table').show();
			$('#list_table').hide();
			switch(parseInt(object.result)){
				case 1:
					$.MsgBox.Alert('系统警告', '数据信息异常!');
				break;
				case 2:
					$.MsgBox.Alert('系统警告', '分类不存在!');
				break;
				case 3:
					$('#oid').val(object.info.id);
					$('#oname').val(object.info.prize_group_name);
					$('#oremark').val(object.info.prize_group_remark);
					$('#groupName').val(object.info.prize_group_name);
					$('#groupMark').val(object.info.prize_group_remark);
				break;
			}
		}else{
			$.MsgBox.Alert('系统警告', '系统繁忙!');
		}
	}else{
		$.MsgBox.Alert('系统警告', '数据异常!');
	}
}

//删除分类
function delGroup(id){
	if(parseInt(id)>0){
		$.MsgBox.Confirm('系统警告','确定要执行该操作吗？', function(){
			var mydata = 'id='+id;
			var object = json_ajax('/a/asyn/dele',mydata,'POST');
			if(object && object.result){
				switch(parseInt(object.result)){
				case 1:
					$.MsgBox.Alert('系统警告', '数据信息异常!');
					break;
				case 2:
					$.MsgBox.Alert('系统警告', '该分类已被使用禁止删除!'); 
					break;
				case 3:
					$.MsgBox.Alert('系统提示', '数据删除成功!');
					window.location.reload();
					break;
				case 4:
					$.MsgBox.Alert('系统警告', '数据删除失败!');
					break;
				}
			}else{
				$.MsgBox.Alert('系统警告', '系统繁忙!');
			}
		});
	}else{
		$.MsgBox.Alert('系统警告', '数据异常!');
	}
}