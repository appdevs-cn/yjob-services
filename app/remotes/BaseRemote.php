<?php

namespace REMOTES;

class BaseRemote {
 
    private $_configInfo;

    private $_url;        //接口URL
    
    private $_method;     //请求协议
    
    private $_charset;    //接口返回数据编码
    
    protected $_debug = true;//debug 参数
    
    protected $_apiName = '';
    
    static public $status = '';

    static public $timeout = 5;

    public function __construct($config = null) {
        $config = new \Phalcon\Config\Adapter\Php(CONF_PATH."remotes.php");
        if($config){
            $this->_configInfo = $config;
        }
    }
    
    /**
     * 取得毫秒级时间戳
     *
     * @return mixed This is the return value description
     *
     */    
    private function _getmicrotime() {
        list($usec, $sec) = explode(" ",microtime());  
        return ((float)$usec + (float)$sec);  
    }
    /**
     * 设置接口请求信息
     *
     * @param array $clientInfo 接口信息，数组，包含url-地址、method方法、charset编码
     * @return void
     *
     */    
    private function setClientInfo($clientInfo) {
        if($clientInfo){
            
            $this->_url = $clientInfo['url'] ? $clientInfo['url'] : '';
            
            $this->_method = $clientInfo['method'] ? $clientInfo['method'] : 'post';
            
            $this->_charset = $clientInfo['charset'] ? $clientInfo['charset'] : 'utf-8';
            
        }
    }

     
    private function setClientInfoByName($clientName) {
        $this->_apiName = $clientName;
        $clientInfo = $this->_configInfo->$clientName;
        
        if($clientInfo){
            
            $this->setClientInfo($clientInfo);
            
        }else{
            
            throw new exception('无配置信息或指定的接口名无效');
            
        }
    }
    
    /**
     * 发送请求并返回数据
     *
     * @param array $arguments 请求的数据
     * @param array|string $clientInfo 接口信息或接口名
     * @return string 返回接口返回的数据
     * @return $this_header 请求URL的header头
     */    
    public function send($arguments, $clientInfo = null, $this_header) {
        if($this->_debug){
            $startTime = $this->_getmicrotime();
        }

        $returnValue = false;
       
        if($clientInfo){
            if(is_array($clientInfo)){
                $this->setClientInfo($clientInfo);
            }
            if(is_string($clientInfo)){
                $this->setClientInfoByName($clientInfo);
            }
        }

        if($this->_url && $this->_method && $this->_charset){
            $requestUrl = $this->_url;
            //post get 分别处理
            if($this->_method == 'get'){
                //请求的URL处理，如果是GET，需要将参数变成get字串拼进URL
                $concatChar = '?';
                if (strpos($requestUrl,'?')) {
                    $concatChar = '&';
                }
                if(is_array($arguments)){
                    $arguments = http_build_query($arguments);
                }
                $requestUrl = $requestUrl . $concatChar . $arguments;
               
                $returnValue = self::get($requestUrl, $this->_charset);
            }else{
                $returnValue = self::post($requestUrl, $arguments, $this->_charset,$this_header);
            }
        }
        
        if($this->_debug){
            $endTime = $this->_getmicrotime();
            $costTime = $endTime-$startTime;
            $requestInfo['api_name'] = $this->_apiName;
            $requestInfo['api_url'] = $this->_url;
            $requestInfo['request_method'] = $this->_method;
            $requestInfo['request_data'] = json_encode($arguments);
            $requestInfo['charset'] = $this->_charset;
            $requestInfo['request_time'] = date("Y-m-d H:i:s", $startTime);
            $requestInfo['response_time'] = date("Y-m-d H:i:s", $endTime);
            $requestInfo['use_time'] = $costTime;
            $requestInfo['response_data'] = json_encode($returnValue);
            $requestInfo['response_code'] = self :: $status;
            \Utilities\Debug\RemoteCall::logToDb($requestInfo);
        }
        return $returnValue;
    }

    /**
     * 直接发送get请求并返回请求结果
     *
     * @param string $url 请求Url
     * @param string $charset 编码
     * @return string 返回内容
     *
     */    
    static function get($url, $charset = 'utf-8') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $returnValue = curl_exec($ch);
        self :: $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($charset != 'utf-8'){
            $returnValue = iconv($charset,'utf-8',$returnValue);
        }
        return $returnValue;
    }

    /**
     * 直接发送post请求并返回请求结果
     *
     * @param string $url 请求Url
     * @param array $$arguments 参数，数组
     * @param string $charset 编码
     * @return string 返回内容
     * @return $this_header 请求URL的header头
     */   
    static function post($url, $arguments, $charset = 'utf-8', $this_header="") {
        $postData = $arguments;
        $ch = curl_init(); 
        if(is_array($this_header)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1); 
        if(class_exists("CURLFile") && !empty($arguments['media'])) {
           $file = ltrim($postData['media'],'@');
           $postData['media'] = new CURLFile($file);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$timeout);
        $returnValue = curl_exec($ch);
        //var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE));exit;
       
        self :: $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($charset != 'utf-8'){
            $returnValue = iconv($charset,'utf-8',$returnValue);
        }
       return $returnValue;
    }

}
