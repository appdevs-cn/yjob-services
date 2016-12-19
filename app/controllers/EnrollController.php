<?php
namespace Controllers;

use Models\Enroll;
use Models\Job;
use Models\JobInfo;
use Models\Team;
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
     * @apiParam {Number} company_id 企业ID.
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
         if(!$this->_params['company_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_CID_NOT_EMPTY));
        }
        $existWhere['uid'] = $this->_params['uid'];
        $existWhere['job_info_id'] = $this->_params['job_info_id'];
        $existWhere['resume_id'] = $this->_params['resume_id'];
        $existWhere['$gte'] = ['work_date'=>$this->_params['date']];
        $this->_params['enroll_type'] && $existWhere['enroll_type'] = $this->_params['enroll_type'];
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
        $enrollInfo['company_id'] = $this->_params['company_id'];
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
     * @apiParam {Number} check_status 查看状态 (100=>未查看,200=>已查看).
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
        $this->_params['check_status'] && $enrollInfo['check_status'] = $this->_params['check_status'];
        $enrollMode = new Enroll();
        $enrollTmp = $enrollMode->findOne(array('id' => $this->_params['enroll_id']));
        if(!$enrollTmp) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        if(!$enrollTmp->save($enrollInfo)) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_UPDATE_FAILD));
        }
        if($this->_params['position_type']) {
            $where['uid'] = $enrollTmp->uid;
            $where['job_info_id'] = $enrollTmp->job_info_id;
            $team = new Team();
            $teamInfo = $team->findOne($where);
            if($teamInfo) {
                $data['type'] = $this->_params['position_type'];
                $trs = $teamInfo->save($data);
            } else {
                $data['job_id'] = $enrollTmp->job_id;
                $data['job_name'] = $enrollTmp->job_name;
                $data['job_info_id'] = $enrollTmp->job_info_id;
                $data['uid'] = $enrollTmp->uid;
                $data['type'] = $enrollTmp->position_type;
                $team->create($data);
            }
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
     * @apiParam {Number} company_id 企业ID.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number} uid 用户id.
     * @apiParam {Number} date 工作时间.
     * @apiParam {Number} enroll_type 报名方式(100=>正常报名,200=>续约报名).
     * @apiParam {Number} status 报名状态(100=>等待操作,200=>通过,301=>已完成,302=>放鸽子,303=>早退,400=>弃用,500=>取消,600=>备用)',
     * @apiParam {Number} position_type 岗位类型(100=>普通,200=>督导).
     * @apiParam {Number} check_status 查看状态(100=>未查看,200=>已查看)
     * @apiParam {Number} evaluate_status 查看状态(100=>未评价,200=>已评价)
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
        $this->_params['company_id'] && $where['company_id'] = $this->_params['company_id'];
        $this->_params['job_id'] && $where['job_id'] = $this->_params['job_id'];
        $this->_params['job_info_id'] && $where['job_info_id'] = $this->_params['job_info_id'];
        $this->_params['uid'] && $where['uid'] = $this->_params['uid'];
        $this->_params['date'] && $where['work_date'] = $this->_params['date'];
        $this->_params['enroll_type'] && $where['enroll_type'] = $this->_params['enroll_type'];
        $this->_params['status'] && $where['status'] =$this->_params['status'];
        $this->_params['position_type'] && $where['position_type'] = $this->_params['position_type'];
        $this->_params['check_status'] && $where['check_status'] = $this->_params['check_status'];
        $this->_params['evaluate_status'] && $where['evaluate_status'] = $this->_params['evaluate_status'];
        $sort = $this->_params['sort'] ? $this->_params['sort'] : 100;
        if($sort == 100) {
            $order = "apply_time DESC";
        }
        $page = $this->_params['page'] ? $this->_params['page'] : 1;
        $size = $this->_params['size'] ? $this->_params['size'] : 30;
        $start = ($page - 1) * $size;
        $enrollMode = new Enroll();
        $totalCount = $enrollMode->getCount($where);
        $enrollListRst = $enrollMode->findAll($where, $start, $size, $order);
        //已查看
        $countNVwhere = array_merge($where, array('check_status' => 100));
        $nvCount = $enrollMode->getCount($countNVwhere);
        $countVwhere = array_merge($where, array('check_status' => 200));
        $vCount = $enrollMode->getCount($countVwhere);

        if($enrollListRst) {
             $enrollList['list'] = $enrollListRst->toArray();
             $enrollList['totalCount'] = $totalCount ? $totalCount : 0;
             $enrollList['vcount'] = $vCount;
             $enrollList['nvcount'] = $nvCount;
             return $this->responseJson("SUCCESS", Lang::_M(ENROLL_LIST_SUCCESS), $enrollList);
        }
        return $this->responseJson("FAILD", Lang::_M(ENROLL_LIST_EMPTY));
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
        if(!is_array($this->_params['enroll_ids']) || !$this->_params['enroll_ids']) {
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
            if($urs) {
                $eInfo->status = $this->_params['status'];
            }
            if($eInfo->status == 200) {
                $team = new Team();
                $uwhere['uid'] = $eInfo->uid;
                $uwhere['job_info_id'] = $eInfo->job_info_id;
                $teamInfo = $team->findOne($uwhere);
                if($teamInfo) {
                    $data['type'] = $this->_params['position_type'];
                    $trs = $teamInfo->save($data);
                } else {
                    $data['job_id'] = $eInfo->job_id;
                    $data['job_name'] = $eInfo->job_name;
                    $data['job_info_id'] = $eInfo->job_info_id;
                    $data['uid'] = $eInfo->uid;
                    $data['type'] = $eInfo->position_type;
                    $team->create($data);
                }
            }
            $returnList[$eid] = $eInfo->toArray();
        }
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_INFO_UPDATE_SUCCESS), $returnList);
    }
    
    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/isEnroll  是否报名
     * @apiUse Token
     * @apiName isEnroll
     * @apiGroup enroll
     * @apiDescription 是否报名.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} uid 用户id.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"已报名!","data":"1"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"未报名!"}
     */
    public function isEnrollAction() {
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_JOB_ID_NOT_EMPTY));
        }
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_UID_NOT_EMPTY));
        }
        $where['job_id'] = $this->_params['job_id'];
        $where['uid'] = $this->_params['uid'];
        $enrollModel = new Enroll();
        $enrollCount = $enrollModel->getCount($where);
        if($enrollCount) {
            return $this->responseJson("SUCCESS", Lang::_M(ENROLL_EXISTS), $enrollCount);
        }
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_NOT_EXISTS));
    }
    
    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/enrollCount  职位报名数
     * @apiUse Token
     * @apiName enrollCount
     * @apiGroup enroll
     * @apiDescription 职位报名数.
     * @apiParam {Number} job_id 职位ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"获取报名数成功!","data":{"enrollCont":"10"}}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"获取报名数失败!"}
     */
    public function enrollCountAction() {
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_JOB_ID_NOT_EMPTY));
        }
        $where['job_id'] = $this->_params['job_id'];
        $enrollModel = new Enroll();
        $enrollCount = $enrollModel->getCount($where);
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_GET_COUNT_SUCCESS), ['enrollCount' => $enrollCount]);
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
     * @api {post} /enroll/info  获取报名信息
     * @apiUse Token
     * @apiName info
     * @apiGroup enroll
     * @apiDescription 获取报名信息.
     * @apiParam {Number} enroll_id 报名ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"获取报名信息成功","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"标记失败"}
     */
    public function infoAction() {
        if(!$this->_params['enroll_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        $enrollModel = new Enroll();
        $where['id'] = $this->_params['enroll_id'];
        $this->_params['position_type'] && $where['position_type'] = $this->_params['position_type'];
        $eInfo = $enrollModel->findOne($where);
        if(!$eInfo) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_INFO_NOT_EMPTY));
        }
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_INFO_SUCCESS), $eInfo);
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
        $updateInfo['leaveEarly'] = $this->_params['status'] == 200 ? 200 : 100;
        $urs = $eInfo->save($updateInfo);
        return $this->responseJson("SUCCESS", Lang::_M(ENROLL_INFO_UPDATE_SUCCESS));

    }

}
