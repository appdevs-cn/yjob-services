<?php
namespace Utilities\Debug;

class RemoteCall {


    /**
     * Log error to database
     *
         * @param int		php error number
         * @param string	php error description
         * @param string	php file where the error occured
         * @param int		php line where the error occured
     * @return bool
     */
    public static function logToDb($RequestInfo) {
        if(!$RequestInfo) {
            return false;
        }
        $rq = new \Models\RemoteCall();	
        $rq->api_name = $RequestInfo['api_name'];
        $rq->api_url = $RequestInfo['api_url'];
        $rq->request_method = strtoupper($RequestInfo['request_method']);
        $rq->request_data = $RequestInfo['request_data'];
        $rq->charset = $RequestInfo['charset'];
        $rq->request_time = $RequestInfo['request_time'];
        $rq->response_time = $RequestInfo['response_time'];
        $rq->use_time = $RequestInfo['use_time'];
        $rq->response_data = $RequestInfo['response_data'];
        $rq->response_code = $RequestInfo['response_code'];
        return $rq->save();
    }
}