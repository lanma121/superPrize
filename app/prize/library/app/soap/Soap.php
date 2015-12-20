<?php

/**
 * @desc Soap Server
 * @author 1399871902@qq.com
 * @time Sat 14 Nov 16:16
 */

include_once( __DIR__.'/class/nusoap.class.php' );

class App_Soap_Soap{
	
	private $client;
	
	public function __construct(){
		$opt = Arch_Yaml::get('prize/soap', 'link', true);
		if(!(!empty($opt['url']) && fopen($opt['url'],'r'))){
			$opt['url'] = 'http://www.xabaili.com/points/server.php';
		}
		$this->client = new nusoap_client($opt['url']);
	}
	
	/**
	 * 更新会员等级
	 * @param $mid member_id
	 * @param $tid type_id
	 */
	public function updateLevel($mid,$tid){
		$error = $this->client->get_error();
		if(!$error){
			$params = array(
				'mid'		=> $mid,
				'tid'		=> $tid
			);
			return $this->client ->call('users_notes.update_level',$params);
		}else{
			return $error;
		}
	}
}