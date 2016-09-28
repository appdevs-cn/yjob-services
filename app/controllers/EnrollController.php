<?php
namespace Controllers;

use Models\Enroll;
use Models\Job;
use Models\JobInfo;
use Utilities\Common\Lang;

class EnrollController extends BaseController {

    /**
     * @apiDefine Token
     * @apiHeader {Number} APP_ID  API为应用分配的唯一ID
     * @apiHeader {Number} API_TIME  API请求时间戳
     * @apiHeader {Number} API_HASH  API为应用分配的唯一HASHKEY
     */

    /**
     * @apiDefine Response
     * @apiParam (响应信息){Number} status 请求响应状态码.
     * @apiParam (响应信息){Number} code 响应代码.
     * @apiParam (响应信息){String} msg 响应信息.
     */



    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/add  职位报名
     * @apiUse Token
     * @apiName add
     * @apiGroup enroll
     * @apiDescription 职位报名.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number} resume_id 简历ID
     * @apiParam {Number} enroll_type 报名方式(100=>正常报名,200=>续约报名).
     * @apiParam {Number} date 日期.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"报名成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"报名失败"}
     */
    public function addAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_UID_NOT_EMPTY));
        }
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_INFO_IDS_NO_EMPTY));
        }
        if(!$this->_params['job_info_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_UID_NOT_EMPTY));
        }
        if(!$this->_params['resume_id']) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_ID_NOT_EMPTY));
        }
        if(!$this->_params['date']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_DATE_NOT_EMPTY));
        }
        $existWhere['uid'] = $this->_params['uid'];
        $existWhere['job_info_id'] = $this->_params['job_info_id'];
        $existWhere['resume_id'] = $this->_params['resume_id'];
        //$existWhere['work_date'] = $this->_params['date'];
        $enrollModel = new Enroll();
        if($enrollModel->findOne($existWhere)) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_NO_REPEAT));
        }
        $jobModel = new Job();
        $jobInfo = $jobModel->findFirst($this->_params['job_id']);
        if(empty($jobInfo->job_name)) {
            return $this->responseJson("FAILD", Lang::_M(JOB_INFO_NO_EXISE));
        }
        $enrollInfo['uid'] = $this->_params['uid'];
        $enrollInfo['job_info_id'] = $this->_params['job_info_id'];
        $enrollInfo['job_id'] = $this->_params['job_id'];
        $enrollInfo['resume_id'] = $this->_params['resume_id'];
        $enrollInfo['work_date'] = $this->_params['date'];
        $enrollInfo['enroll_type'] = $this->_params['enroll_type'] ? $this->_params['enroll_type'] : 100 ;
        $enrollInfo['position_type'] = $this->_params['position_type'] ? $this->_params['position_type'] : 100;
        $enrollInfo['apply_time'] = $this->_params['apply_time'] ? $this->_params['apply_time'] : time();
        $enrollInfo['create_time'] = $enrollInfo['update_time'] = time();
        $enrollInfo['job_name'] = $jobInfo->job_name;
        $enrollRst = $enrollModel->create($enrollInfo);
        if(!$enrollRst) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_FAILD));
        }
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_SUCCESS));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/update  更新报名信息
     * @apiUse Token
     * @apiName update
     * @apiGroup enroll
     * @apiDescription 职位报名.
     * @apiParam {Number} enroll_id 报名id.
     * @apiParam {String} desc 备注.
     * @apiParam {Number} job_info_id 职位点位ID.
     * @apiParam {Number} position_type 岗位类型(100=>普通,200=>督导).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"更新成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"更新失败!"}
     */
    public function updateAction() {
        if(!$this->_params['enroll_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        $this->_params['job_info_id'] && $enrollInfo['job_info_id'] = $this->_params['job_info_id'];
        $this->_params['desc'] && $enrollInfo['remark'] = $this->_params['desc'];
        $this->_params['position_type'] && $enrollInfo['position_type'] = $this->_params['position_type'];
        $enrollMode = new Enroll();
        $enrollTmp = $enrollMode->findOne(array('id' => $this->_params['enroll_id']));
        if(!$enrollTmp) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        if(!$enrollTmp->save($enrollInfo)) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_UPDATE_FAILD));
        }
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_INFO_UPDATE_SUCCESS));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/list  获取报名列表
     * @apiUse Token
     * @apiName list
     * @apiGroup enroll
     * @apiDescription 获取职位报名列表.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} uid 用户id.
     * @apiParam {Number} date 工作时间.
     * @apiParam {Number} enroll_type 报名方式(100=>正常报名,200=>续约报名).
     * @apiParam {Number} status 报名状态(100=>等待操作,200=>通过,301=>已完成,302=>放鸽子,303=>早退,400=>弃用,500=>取消,600=>备用)',
     * @apiParam {Number} station_type 岗位类型(100=>普通,200=>督导).
     * @apiParam {Number} check_status 查看状态(100=>未查看,200=>已查看)
     * @apiParam {Number} sort 岗位类型(100=>默认排序,200=>点位排序).
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":" 获取职位报名列表成功!","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"获取职位报名列表失败!"}
     */
    public function listAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/status  状态审核
     * @apiUse Token
     * @apiName status
     * @apiGroup enroll
     * @apiDescription 状态审核.
     * @apiParam {Number[]} enroll_ids 报名id.
     * @apiParam {Number} status 审核状态(200=>通过,300=>已完成,400=>弃用,500=>取消,600=>备用).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"审核成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"审核失败!"}
     */
    public function statusAction() {
        if(!$this->_params['enroll_ids']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        if(!$this->_params['status']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_STATUS_NOT_EMPTY));
        }
        $enrollModel = new Enroll();
        foreach($this->_params['enroll_ids'] as $ek => $eid) {
            $where['id'] = $eid;
            $eInfo = $enrollModel->findOne($where);
            if(!$eInfo) {
                return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
            }
            $updateInfo['status'] = $this->_params['status'];
            $urs = $eInfo->save($updateInfo);
            $returnList[$eid] = $urs ? 100 : 200;
        }
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_INFO_UPDATE_SUCCESS), $returnList);
    }


    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/stood  标记放鸽子
     * @apiUse Token
     * @apiName stood
     * @apiGroup enroll
     * @apiDescription 标记放鸽子.
     * @apiParam {Number} enroll_id 报名ID.
     * @apiParam {Number} status 状态(100=>标记,200=>取消标记).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"标记成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"标记失败"}
     */

    public function stoodAction() {
        if(!$this->_params['enroll_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        if(!$this->_params['status']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_STATUS_NOT_EMPTY));
        }
        $enrollModel = new Enroll();
        $where['id'] = $this->_params['enroll_id'];
        $eInfo = $enrollModel->findOne($where);
        if(!$eInfo) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        $updateInfo['stood'] = $this->_params['status'] == 100 ? 200 : 100;
        $urs = $eInfo->save($updateInfo);
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_INFO_UPDATE_SUCCESS));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/leaveEarly  标记早退
     * @apiUse Token
     * @apiName leaveEarly
     * @apiGroup enroll
     * @apiDescription 标记早退.
     * @apiParam {Number} enroll_id 报名ID.
     * @apiParam {Number} status 状态(100=>标记,200=>取消标记).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"标记成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"标记失败"}
     */
    public function leaveEarlyAction() {
        if(!$this->_params['enroll_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        if(!$this->_params['status']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_STATUS_NOT_EMPTY));
        }
        $enrollModel = new Enroll();
        $where['id'] = $this->_params['enroll_id'];
        $eInfo = $enrollModel->findOne($where);
        if(!$eInfo) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        $updateInfo['leaveEarly'] = $this->_params['status'] == 100 ? 200 : 100;
        $urs = $eInfo->save($updateInfo);
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_INFO_UPDATE_SUCCESS));

    }

}