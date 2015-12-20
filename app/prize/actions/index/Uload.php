<?php

/**
 * 图片上传
 * @author wangxb <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Thu 15 Oct 2015 11:15:10 AM CST
 */

class Action_Uload extends App_Action{
	
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_SMARTY2);
	}
	
	public function __execute(){
		if($this->getRequest()->isPost()){
			if(!empty($_POST['submit'])){
				if(isset($_FILES['tem_prize']) && ($_FILES['tem_prize']['error'] == 0)){
					$uload = $this->__uploadFile($_FILES['tem_prize']['tmp_name']);
					print_r($uload);
				}else{
					echo 'unknow!';
				}
			}
		}
		return array();
	}
	
	/*
	 * 图片上传方法
	 * @param string $filePath 上传文件路径
	 * @return 成功：返回OSS文件目录；失败：返回false：
	 */
	private function __uploadFile($filePath){
		$paf = Arch_Paf::instance('image');
		
		fwrite(fopen('d:/upload_1.log', 'w'), $filePath);
		
		$param = array(
			'module' => 'image',  //prize
			'file' => file_get_contents($filePath),
			'size' => array(100)
		);
		$res = $paf->call('publish', $param);
		if($res['flag'] == 0){
			return $res['data']['100'];
		}
		
		fwrite(fopen('d:/upload_2.log', 'w'), serialize($res));
		
		Core_Log::fatal('avatar upload fail', $res);
		return false;
	}
	
}