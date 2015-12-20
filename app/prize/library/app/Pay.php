<?php

/**
 * 
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 08 Jul 2015 08:30:55 AM CST
 */

require_once(dirname(__FILE__) . '/pingpp/init.php');

class App_Pay
{
	private $module;
	public function __construct($module){
		$this->module = $module;
		$conf = $this->getConf();
		\Pingpp\Pingpp::setApiKey($conf['key']);
	}

	/**
	 * 创建订单,并返回charge对象
	 *
	 * @param string $tradeId 当前的交易ID,这里是支付的ID
	 * @param int	$amount	交易金额,单位:分
	 * @param string $channel 交易方式, alipay, upacp, wx
	 *
	 * @return object 一段可以被Json序列化的对象
	 */
	public function createCharge($tradeId, $amount, $channel, $subject, $body, $desc){
		//$ip = $_SERVER['HTTP_REMOTEIP'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$conf = $this->getConf();
		$charge = \Pingpp\Charge::create(array(
			'order_no' => $tradeId, 
			'amount' => $amount,
			'app' => array(
				'id' => $conf['appid']
			),
			'channel' => $channel,
			'currency' => 'cny',
			'client_ip' => $ip,
			'subject' => $subject,
			'body' => $body,
			'description' => $desc
		));

		return $charge->__toStdObject();
	}

	private function getConf(){
		$conf = Arch_Yaml::get('pay', $this->module);
		if(empty($conf)){
			throw new Blue_Exception_Warning("配置PAY-{$this->module}不存在");
		}
		return $conf;
	}
}
