<?php
/**
 * Json格式输出的View类
 *
 * @author 		monkee <monkee.hu@yeahmobi.com>
 * @package		yeahmobi
 * @version		2.0.2
 * @copyright		Copyright (c) 2014 Yeahmobi, Inc.
 */
class App_View_Json extends App_View
{
    private $data = array();
    
    public function __construct(){
    }
    
    public function assign($spec, $value = null){
        if(is_array($spec)){
            $this->data = array_merge($this->data, $spec);
        }else if(is_string($spec)){
            $this->data[$spec] = $value;
        }
    }
    
    public function render($ignore = '', $var = null){
        if(is_array($var)){
            $this->data = array_merge($this->data, $var);
        }
        return json_encode($this->data);
    }

    public function setScriptPath($path){
    }

    public function getScriptPath(){
    }
    
    /**
     * 返回输出需要的Header信息
     * 
     * @return array
     */
    public function getHeaders(){
        return array(
            "Content-type: application/json"
        );
    }

    public function display($ignore = '', $var = null){
        echo $this->render($ignore, $var);
    }
}
