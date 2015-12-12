<?php
/**
 * 推送的接口
 *
 * 这里使用的是个推
 *
 * @author hufeng(@yunsupport.com)
 * @version 1.0
 */
require_once(dirname(__FILE__) . '/getui/' . 'IGt.Push.php');
class Arch_Getui
{
	private $appkey = '';
	private $appid = '';
	private $masterSecuret = '';
	private $host = '';

	public function instance($module){
		if(isset(self::$_instances[$module]) == NULL){
			self::$_instances[$module] = new Arch_Getui($module);
		}
		return self::$_instances[$module];
	}
	private function __construct($module){
		$conf = $this->getConf($module);

		$this->appkey = $conf['appkey'];
		$this->appid = $conf['appid'];
		$this->masterSecuret = $conf['master_securet'];
		$this->host = $conf['host'];
	}

	/**
	 * 发送消息给设备
	 *
	 * @param string $cid 设备的标记
	 * @param string $title 标题,IOS忽略这个参数
	 * @param string $body 正文信息 IOS忽略这个参数
	 * @param string $device 1:安卓 2:ios
	 * @param int $edage APP图标上显示的数字
	 * @param string $data 透传出的数据
	 */
	public function sendToSingle($cid, $title, $body, $device = 1, $edage = 0, $data = ''){
		try{
			if(1 == $device){
				$template = $this->androidTemplate($title, $body, $data, $edage);
			}else{
				$template = $this->iosTemplate($title, $data, $edage);
			}
			$rev = $this->pushMessageToSingle($cid, $template);
		}catch(Exception $e){
			Arch_Log::warning(sprintf("Push fail{%s}", $e->getMessage()));
			return false;
		}
		return true;
	}

	//单推接口案例
	function pushMessageToSingle($cid, $template){
		$igt = new IGeTui($this->host, $this->appkey, $this->masterSecuret);
		
		//个推信息体
		$message = new IGtSingleMessage();

		$message->set_isOffline(true);//是否离线
		$message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间
		$message->set_data($template);//设置推送消息类型
		$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
		//接收方
		$target = new IGtTarget();
		$target->set_appId($this->appid);
		$target->set_clientId($cid);
		
		$rep = $igt->pushMessageToSingle($message,$target);

		if($rep['result'] == 'ok'){
			return true;
		}
		return false;
	}

	private function iosTemplate($body, $data = '', $edage = 0){
        $template =  new IGtTransmissionTemplate();
        $template->set_appId($this->appid);//应用appid
        $template->set_appkey($this->appkey);//应用appkey
        $template->set_transmissionType(2);//透传消息类型
        $template->set_transmissionContent($data);//透传内容
		//iOS推送需要设置的pushInfo字段
		$template->set_pushInfo('', $edage, $body, "", '', '', '', '');
        return $template;
	}
	/*private function androidTemplate($title, $body, $data = '', $edage = 0){
	    $template =  new IGtNotificationTemplate();
		//$template = new IGtTransmissionTemplate();
        $template->set_appId($this->appid);//应用appid
        $template->set_appkey($this->appkey);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent($data);//透传内容
        $template->set_title($title);//通知栏标题
        $template->set_text($body);//通知栏内容
        $template->set_logo("push.png");//通知栏logo
        $template->set_isRing(true);//是否响铃
        $template->set_isVibrate(true);//是否震动
        $template->set_isClearable(true);//通知栏是否可清除
        // iOS推送需要设置的pushInfo字段
		//$template->set_pushInfo('消息', $edage, $body, '', $body, '', '', '');
        return $template;
	}*/


   private function androidTemplate($title,$body,$data="",$edage=0){
	    $template = new IGtTransmissionTemplate();
	    $template->set_appId($this->appid);//应用appid
	    $template->set_appkey($this->appkey);//应用appkey
	    $template->set_transmissionType(2);//透传消息类型
	    $template->set_transmissionContent($body);//透传内容
	    //iOS推送需要设置的pushInfo字段
	   //$template ->set_pushInfo($actionLocKey,$badge,$message,$sound,$payload,$locKey,$locArgs,$launchImage);
	   //$template->set_pushInfo("", 5, "", "", "", "", "", "");
	   //$template->set_pushInfo('', $edage, $title, "", $body, '', '', '');
	   // $template->set_pushInfo('', 3, '你还好么', '');
         return $template;
   }


	private function getConf($module){
		$conf = Arch_Yaml::get('getui', 'modules', true);
		if(is_array($conf) && isset($conf[$module])){
			return $conf[$module];
		}

		throw new Arch_Exception("Getui conf {$module} is not exist");
	}

	static private $_instances = array();
}

