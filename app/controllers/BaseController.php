<?php
namespace Controllers;

use \Phalcon\Mvc\Controller;


class BaseController extends Controller {

    protected $_params;

    private static $_models;

    public function onConstruct() {
        if ($this->request->isPost() == true) {
            $this->_params = $this->request->getPost() ? $this->request->getPost() : $this->request->getJsonRawBody(true);
        } elseif($this->request->isGet() == true) {
            $this->_params = $this->request->isGet();
        } else {
            $this->_params =  $this->request->getJsonRawBody(true);
        }
    }

    public function responseJson($status, $message = array(), $data = array()) {
        $returnInfo = !empty($message) ? $message : ['code' => '-1', 'msg' => '请求出错'];
        $returnInfo['status'] = $status;
        (isset($data) && !empty($data)) && $returnInfo['data'] = $data;
        return $returnInfo;
    }
//
//    public static function getModelInstance($modelName) {
//        if(!self::$_models[$modelName]) {
//            self::$_models[$modelName] = new Job();
//        }
//        return self::$_models[$modelName] ;
//    }

}