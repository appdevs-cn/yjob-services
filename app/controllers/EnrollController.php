<?php
namespace Controllers;

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
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} date 日期.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"报名成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"报名失败"}
     */
    public function addAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/update  更新报名信息
     * @apiUse Token
     * @apiName update
     * @apiGroup enroll
     * @apiDescription 职位报名.
     * @apiParam {Number} enroll_id 报名id.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {String} desc 备注.
     * @apiParam {Number} station_type 岗位类型(100=>普通,200=>督导).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"更新成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"更新失败!"}
     */
    public function updateAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /enroll/list  获取报名列表
     * @apiUse Token
     * @apiName list
     * @apiGroup enroll
     * @apiDescription 获取职位报名列表.
     * @apiParam {Number} job_id 用户id.
     * @apiParam {Number} uid 职位ID.
     * @apiParam {Number} date 工作时间.
     * @apiParam {Number} status 报名状态(100=>等待操作,200=>通过,201=>已完成,300=>弃用,400=>取消,500=>放鸽子,600=>备用)',
     * @apiParam {Number} station_type 岗位类型(100=>普通,200=>督导).
     * @apiParam {Number} check_status 查看状态(100=>未查看,200=>已查看)
     * @apiParam {Number} sort 岗位类型(100=>默认排序,200=>点位排序).
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":" 获取职位报名列表成功!","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取职位报名列表失败!"}
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
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} status 审核状态(200=>通过,201=>已完成,300=>弃用,400=>取消,500=>放鸽子,600=>备用).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"审核成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"审核失败!"}
     */
    public function statusAction() {

    }


}