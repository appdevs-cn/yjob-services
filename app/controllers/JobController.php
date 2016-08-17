<?php
namespace Controllers;

class JobController extends BaseController {

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
     * @api {post} /job/add   发布职位
     * @apiUse Token
     * @apiName add
     * @apiGroup Jobs
     * @apiDescription 发布职位.
     * @apiParam {String} job_name 职位名称.
     * @apiParam {String} uid 用户ID.
     * @apiParam {String} company_id 企业ID.
     * @apiParam {String} company_name 企业名称.
     * @apiParam {Number=100,200,300} job_type 职位类型(100=>全职，200=>兼职,300=>实习).
     * @apiParam {Number} start_time 开始时间.
     * @apiParam {Number} end_time 结束时间.
     * @apiParam {Number} category_id 职位类别ID.
     * @apiParam {String} category_name 职位类别名称.
     * @apiParam {String[]} position_high 职位亮点ID.
     * @apiParam {String[]} position_character 职位特点ID.
     * @apiParam {Number=100,200,300} sex=100 性别(100=>不限,200=>男,300=>女).
     * @apiParam {Number} education 学历要求ID(0=>不限,非0=>为实际学历要求的ID).
     * @apiParam {Number} min_age 最小年龄.
     * @apiParam {Number} max_age 最大年龄.
     * @apiParam {Number} publish_city_id 发布城市ID.
     * @apiParam {String[]} contacts_info 职位联系信息(请参考<a href="#联系信息">联系信息字段</a>)
     * @apiParam (联系信息字段) {String} contact_name 联系人
     * @apiParam (联系信息字段) {Number=100,200} dispaly_name=100 是否公开联系人(100=>公开,200=>不公开)
     * @apiParam (联系信息字段) {String} contact_tel 联系电话
     * @apiParam (联系信息字段) {String} contact_mobile 联系手机
     * @apiParam (联系信息字段) {Number=100,200} dispaly_mobile=100 是否公开手机号码(100=>公开,200=>不公开)
     * @apiParam (联系信息字段) {String} contact_email 联系邮箱
     * @apiParam (联系信息字段) {Number=100,200} dispaly_email=100 是否公开邮箱(100=>公开,200=>不公开)
     * @apiParam (联系信息字段) {String} contact_address 联系地址
     * @apiParam {String[]} receive_info 接收通知设置(请参考<a href="#通知设置">通知设置字段</a>)
     * @apiParam (通知设置字段) {String} receive_email 接收简历邮箱.
     * @apiParam (通知设置字段) {Number=100,200} push_email=100 是否email接收简历(100=>接收,200=>不接收)
     * @apiParam (通知设置字段) {String} receive_mobile 接收通知手机.
     * @apiParam (通知设置字段) {Number=100,200} push_sms=100 是否短信接收简历(100=>接收,200=>不接收)
     * @apiParam {String[]} stations_info 点位信息 (请参考<a href="#点位信息说明">点位信息字段</a>)
     * @apiParam (点位信息字段) {Number} supervisor_nums 督导报名人数.
     * @apiParam (点位信息字段) {Number} supervisor_backup 督导备用人数.
     * @apiParam (点位信息字段) {Number} supervisor_money 督导薪资.
     * @apiParam (点位信息字段) {Number} supervisor_wage 督导薪资计算方式ID(天/件/次....).
     * @apiParam (点位信息字段) {Number} supervisor_type 督导结算方式ID.
     * @apiParam (点位信息字段) {Number} parttime_nums 兼职招聘人数.
     * @apiParam (点位信息字段) {Number} parttime_backup 兼职备用人数.
     * @apiParam (点位信息字段) {Number} parttime_money 兼职薪资.
     * @apiParam (点位信息字段) {Number} parttime_wage 兼职薪资计算方式ID(天/件/次....).
     * @apiParam (点位信息字段) {Number} parttime_type 兼职结算方式ID.
     * @apiParam (点位信息字段) {Number} province_id 省ID.
     * @apiParam (点位信息字段) {Number} city_id 市ID.
     * @apiParam (点位信息字段) {Number} district_id 区ID.
     * @apiParam (点位信息字段) {Number} business_district_id 商圈ID.
     * @apiParam (点位信息字段) {String} address 具体地址.
     * @apiParam (点位信息字段) {Double} lng 经度.
     * @apiParam (点位信息字段) {Double}lat 纬度.
     * @apiParam (点位信息字段) {Number} start_date 开始日期.
     * @apiParam (点位信息字段) {Number} end_date 结束日期.
     * @apiParam (点位信息字段) {Number} work_start_time 上班时间.
     * @apiParam (点位信息字段) {Number} work_end_time 下班时间.
     * @apiParam (点位信息字段) {Number} fall_in_time 集合时间.
     * @apiParam (点位信息字段) {String} fall_in_address 集合地点.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"发布成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"职位描述不能为空"}
     */

    public function addAction() {


    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/update   更新职位
     * @apiUse Token
     * @apiName update
     * @apiGroup Jobs
     * @apiDescription 更新职位.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {String} uid 用户ID.
     * @apiParam {String} company_id 企业ID.
     * @apiParam {String} job_name 职位名称.
     * @apiParam {Number=100,200,300} job_type 职位类型(100=>全职，200=>兼职,300=>实习).
     * @apiParam {Number} start_time 开始时间.
     * @apiParam {Number} end_time 结束时间.
     * @apiParam {Number} category_id 职位类别ID.
     * @apiParam {String} category_name 职位类别名称.
     * @apiParam {String[]} position_high 职位亮点ID.
     * @apiParam {String[]} position_character 职位特点ID.
     * @apiParam {Number=100,200,300} sex=100 性别(100=>不限,200=>男,300=>女).
     * @apiParam {Number} education 学历要求ID(0=>不限,非0=>为实际学历要求的ID).
     * @apiParam {Number} min_age 最小年龄.
     * @apiParam {Number} max_age 最大年龄.
     * @apiParam {Number} publish_city_id 发布城市ID.
     * @apiParam {String[]} contacts_info 职位联系信息(请参考<a href="#联系信息">联系信息字段</a>)
     * @apiParam (联系信息字段) {String} contact_name 联系人
     * @apiParam (联系信息字段) {Number=100,200} dispaly_name=100 是否公开联系人(100=>公开,200=>不公开)
     * @apiParam (联系信息字段) {String} contact_tel 联系电话
     * @apiParam (联系信息字段) {String} contact_mobile 联系手机
     * @apiParam (联系信息字段) {Number=100,200} dispaly_mobile=100 是否公开手机号码(100=>公开,200=>不公开)
     * @apiParam (联系信息字段) {String} contact_email 联系邮箱
     * @apiParam (联系信息字段) {Number=100,200} dispaly_email=100 是否公开邮箱(100=>公开,200=>不公开)
     * @apiParam (联系信息字段) {String} contact_address 联系地址
     * @apiParam {String[]} receive_info 接收通知设置(请参考<a href="#通知设置">通知设置字段</a>)
     * @apiParam (通知设置字段) {String} receive_email 接收简历邮箱.
     * @apiParam (通知设置字段) {Number=100,200} push_email=100 是否email接收简历(100=>接收,200=>不接收)
     * @apiParam (通知设置字段) {String} receive_mobile 接收通知手机.
     * @apiParam (通知设置字段) {Number=100,200} push_sms=100 是否短信接收简历(100=>接收,200=>不接收)
     * @apiParam {String[]} stations_info 点位信息 (请参考<a href="#点位信息说明">点位信息字段</a>)
     * @apiParam (点位信息字段) {Number} supervisor_nums 督导报名人数.
     * @apiParam (点位信息字段) {Number} supervisor_backup 督导备用人数.
     * @apiParam (点位信息字段) {Number} supervisor_money 督导薪资.
     * @apiParam (点位信息字段) {Number} supervisor_wage 督导薪资计算方式ID(天/件/次....).
     * @apiParam (点位信息字段) {Number} supervisor_type 督导结算方式ID.
     * @apiParam (点位信息字段) {Number} parttime_nums 兼职招聘人数.
     * @apiParam (点位信息字段) {Number} parttime_backup 兼职备用人数.
     * @apiParam (点位信息字段) {Number} parttime_money 兼职薪资.
     * @apiParam (点位信息字段) {Number} parttime_wage 兼职薪资计算方式ID(天/件/次....).
     * @apiParam (点位信息字段) {Number} parttime_type 兼职结算方式ID.
     * @apiParam (点位信息字段) {Number} province_id 省ID.
     * @apiParam (点位信息字段) {Number} city_id 市ID.
     * @apiParam (点位信息字段) {Number} district_id 区ID.
     * @apiParam (点位信息字段) {Number} business_district_id 商圈ID.
     * @apiParam (点位信息字段) {String} address 具体地址.
     * @apiParam (点位信息字段) {Double} lng 经度.
     * @apiParam (点位信息字段) {Double} lat 纬度.
     * @apiParam (点位信息字段) {Number} start_date 开始日期.
     * @apiParam (点位信息字段) {Number} end_date 结束日期.
     * @apiParam (点位信息字段) {Number} work_start_time 上班时间.
     * @apiParam (点位信息字段) {Number} work_end_time 下班时间.
     * @apiParam (点位信息字段) {Number} fall_in_time 集合时间.
     * @apiParam (点位信息字段) {String} fall_in_address 集合地点.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"更新成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"职位描述不能为空"}
     */
    public function updateAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {get} /job/list  职位列表
     * @apiUse Token
     * @apiName list
     * @apiGroup Jobs
     * @apiDescription 职位列表.
     * @apiParam {String} uid 用户ID.
     * @apiParam {String} company_id 企业ID.
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取列表成功","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"职位列表为空"}
     */
    public function listAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {get} /job/info  职位详情
     * @apiUse Token
     * @apiName info
     * @apiGroup Jobs
     * @apiDescription 职位详情.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {String} uid 用户ID.
     * @apiParam {String} company_id 企业ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取职位详情成功","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"没有该职位的信息"}
     */
    public function infoAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {get} /job/search   职位搜索
     * @apiUse Token
     * @apiName search
     * @apiGroup Jobs
     * @apiDescription 职位搜索(默认返回全部结果).
     * @apiParam {Number=100,200,300} job_type 工作性质(100=>全职,200=>兼职,300=>实习)
     * @apiParam {Number} category_id 职位分类ID
     * @apiParam {Number} job_type 职位类型
     * @apiParam {Number} province_id 省份ID
     * @apiParam {Number} city_id 城市ID
     * @apiParam {Number} district_id 区ID
     * @apiParam {Number} business_district_id 商圈ID
     * @apiParam {Number=100,200,300,400} order_type 排序类型(100=>默认排序,200=>离我最近,300=>最新发布,400=>工资最高)
     * @apiParam {Double} lng 经度(仅排序为200时使用)
     * @apiParam {Double} lng 纬度(仅排序为200时使用)
     * @apiParam {Number} status 职位状态(100=>发布中,200=>审核中,300=>未显示(301=>审核未通过,302=>已关闭),400=>已删除)
     * @apiParam {Number} start_time 发布时间
     * @apiParam {Number} end_time 到期时间
     * @apiParam {Number} refurbish_time 刷新时间
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取列表成功","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"职位列表为空"}
     */
    public function searchAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/delete 删除职位
     * @apiUse Token
     * @apiName delete
     * @apiGroup Jobs
     * @apiDescription 删除职位.
     * @apiParam {Number[]} job_id 职位ID.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} company_id 企业ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"删除成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"删除失败"}
     */
    public function deleteAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/refurbish 刷新职位
     * @apiUse Token
     * @apiName refresh
     * @apiGroup Jobs
     * @apiDescription 刷新职位.
     * @apiParam {Number[]} job_id 职位ID.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} company_id 企业ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"刷新成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"刷新失败"}
     */
    public function refreshAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/audit   职位审核
     * @apiUse Token
     * @apiName audit
     * @apiGroup Jobs
     * @apiDescription 职位审核.
     * @apiParam {Number[]} job_id 职位ID.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} company_id 企业ID.
     * @apiParam {Number=100,200} status=100 审核状态(100=>通过,200=>拒绝)
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"审核成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"审核失败"}
     */
    public function auditAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/close   关闭职位
     * @apiUse Token
     * @apiName close
     * @apiGroup Jobs
     * @apiDescription 关闭职位.
     ** @apiParam {Number[]} job_id 职位ID.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} company_id 企业ID.
     * @apiParam {Number=100,200} status=100 审核状态(100=>关闭,200=>恢复)
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"关闭成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"关闭失败"}
    */
    public function closeAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/autoRefresh   自动刷新设置
     * @apiUse Token
     * @apiName autoRefresh
     * @apiGroup Jobs
     * @apiDescription 自动刷新设置.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number=100,200} status=100 自动刷新(100=>打开,200=>关闭)
     * @apiParam {Number} refresh_time 自动刷新时间(仅开启时使用).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"自动刷新设置成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"自动刷新设置失败"}
     */
    public function autoRefreshAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/past   用户签到/签退
     * @apiUse Token
     * @apiName past
     * @apiGroup Jobs
     * @apiDescription 用户签到/签退
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number=100,200} status=100 签到/签退(100=>签到,200=>签退)
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"签到成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"签到失败"}
     */
    public function pastAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/pastList  职位签到/签退列表
     * @apiUse Token
     * @apiName pastList
     * @apiGroup Jobs
     * @apiDescription 职位签到列表.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number} type 操作类型(100=>签到,200=>签退).
     * @apiParam {Number} date 日期.
     * @apiParam {Number} show_type 查看方式(100=>默认,200=>图片).
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"确认成功","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"确认失败"}
     */
    public function pastListAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/renew   用户续约
     * @apiUse Token
     * @apiName renew
     * @apiGroup Jobs
     * @apiDescription 用户签到/签退/续约.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number[]} renew_ids 续约ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"续约成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"续约失败"}
     */
    public function renewAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/renewList   用户续约列表
     * @apiUse Token
     * @apiName renewList
     * @apiGroup Jobs
     * @apiDescription 用户续约列表.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取续约列表成功!","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取续约列表失败"}
     */
    public function renewListAction() {

    }


    /**
     * @apiVersion 1.0.0
     * @api {post} /job/confirm  工作状态确认
     * @apiUse Token
     * @apiName past
     * @apiGroup Jobs
     * @apiDescription 签到/签退/续约确认.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number[]} work_ids 签到/签退id.
     * @apiParam {Number} type 操作类型(100=>签到,200=>签退,300=>续约).
     * @apiParam {Number} status 状态(100=>通过,200=>拒绝).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"确认成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"确认失败"}
    */

    public function confirmAction() {

    }


    /**
     * @apiVersion 1.0.0
     * @api {post} /job/stood  标记放鸽子
     * @apiUse Token
     * @apiName stood
     * @apiGroup Jobs
     * @apiDescription 标记放鸽子.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} status 状态(100=>标记,200=>取消标记).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"标记成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"标记失败"}
    */

    public function stoodAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/fav  职位收藏
     * @apiUse Token
     * @apiName fav
     * @apiGroup Jobs
     * @apiDescription 职位收藏.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} job_id 职位ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"收藏成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"收藏失败"}
     */
    public function favJobAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/favJobList  职位收藏列表
     * @apiUse Token
     * @apiName favJobList
     * @apiGroup Jobs
     * @apiDescription 职位收藏列表.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取职位收藏列表成功","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取职位收藏列表失败"}
     */
    public function favJobListAction() {

    }

}


?>