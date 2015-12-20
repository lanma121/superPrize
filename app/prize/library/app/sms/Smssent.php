<?php
/**
 * Created by BaiLi.
 * User: Hogan
 * Date: 2015/4/3
 * Time: 10:24
 */
require_once 'CCPRestSDK.php';
class App_Sms_Smssent {
    private $accountSid= 'aaf98f894c2fd0b5014c35d945d20492';
    private $accountToken= '1b7126ce122f4f9aabf80d1237dcc04b';
    private $appId='aaf98f894c49ea4f014c4aca8eb700fc';
    private $serverIP='app.cloopen.com';//请求地址
    private $serverPort='8883';//请求端口号
    private $softVersion='2013-12-26';//REST版本号
    private $rest = null;
    public function __construct(){
        $rest = new REST($this->serverIP,$this->serverPort,$this->softVersion);
        $rest->setAccount($this->accountSid,$this->accountToken);
        $rest->setAppId($this->appId);
        $this->rest = $rest;
    }
    /**
     * 发送模板短信
     * @param to 手机号码集合,用英文逗号分开
     * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
     * @param $tempId 模板Id
     */
    public function sendTemplateSMS($to,$datas,$tempId){
        return $this->rest->sendTemplateSMS($to,$datas,$tempId);
    }
    /**
     * 语音验证码
     * @param verifyCode 验证码内容，为数字和英文字母，不区分大小写，长度4-8位
     * @param playTimes 播放次数，1－3次
     * @param to 接收号码
     * @param displayNum 显示的主叫号码
     * @param respUrl 语音验证码状态通知回调地址，云通讯平台将向该Url地址发送呼叫结果通知
     */
    public function voiceVerify($verifyCode,$playTimes,$to,$displayNum,$respUrl){
        return $this->rest->voiceVerify($verifyCode,$playTimes,$to,$displayNum,$respUrl);
      
    }

}
