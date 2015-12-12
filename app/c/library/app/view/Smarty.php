<?php

/**
 * Json输出的View类
 * 
 * @author 胡峰 <monkee@yeahmobi.com>
 * @version 1.0.0
 * @package ym
 * @category script
 * @copyright 2014-2015 Yeahmobi@inc
 */
require(dirname(__FILE__) . '/smarty/Smarty.class.php');

class App_View_Smarty extends App_View
{
    private $smarty = null;
    
    public function __construct(){
		$this->smarty = new Smarty();
		//读取配置
		$this->smarty->setTemplateDir(PDP_APP_VIEW);
		$this->smarty->setCompileDir(PDP_APP_DATA . '/smarty');
		//$this->smarty->setDe
    }
    
    public function getHeaders(){
        return array();
    }
    
    public function assign($spec, $value = null){
        if(is_array($spec)){
            $this->smarty->assign($spec);
        }else if(is_string($spec)){
            $this->smarty->assign($spec, $value);
        }
    }
    
    public function render($tpl = '', $var = null){
		if(!empty($var)){
			$this->smarty->assign($var);
		}
        if(empty($tpl)){
            throw new App_Exception_Fatal('Smarty view need render tpl');
        }
        $tpl = $tpl . '.tpl';
        return $this->smarty->fetch($tpl);
    }

    public function setScriptPath($path){
		//此方法无效
    }

    public function getScriptPath(){
		//此方法无效
    }

    public function display($tpl = '', $var = null){
		if(is_array($var)){
			$this->smarty->assign($var);
		}
        if(empty($tpl)){
            throw new App_Exception_Fatal('Smarty view need render tpl');
        }
        $tpl = $tpl . '.tpl';
        $this->smarty->display($tpl);
    }
}
