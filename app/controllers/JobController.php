<?php
namespace Controllers;

use Phalcon\Mvc\Controller;

use Utilities\Common\Lang;

use Models\Job;

use Models\JobInfo;

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

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
     * @api {post} /job/create   发布职位
     * @apiUse Token
     * @apiName create
     * @apiGroup Jobs
     * @apiSampleRequest http://api.yjobs.net/create
     * @apiDescription 发布职位.
     * @apiParam {String} job_name 职位名称.
     * @apiParam {String} job_desc 职位描述.
     * @apiParam {String} company_id 企业ID.
     * @apiParam {String} company_name 企业名称.
     * @apiParam {Number=100,200,300} job_type 职位类型(100=>全职，200=>兼职,300=>实习).
     * @apiParam {Number} category_id 职位类别ID.
     * @apiParam {String} category_name 职位类别名称.
     * @apiParam {String[]} position_high 职位亮点ID.
     * @apiParam {String[]} position_character 职位特点ID.
     * @apiParam {Number=100,200,300} sex=100 性别(100=>不限,200=>男,300=>女).
     * @apiParam {Number} education 学历要求ID(0=>不限,非0=>为实际学历要求的ID).
     * @apiParam {String} experience 工作经验要求
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
     * @apiExample {curl} 请求实例:
     * {
     * "job_name":"test\u804c\u4f4d\u6dfb\u52a0",
     * "job_desc":"\u804c\u4f4d\u63cf\u8ff0\u4e0d\u80fd\u4e3a\u7a7a",
     * "company_id":"10001",
     * "company_name":"\u4e91\u54c1\u79d1\u6280",
     * "job_type":100,
     * "start_time":1478292103,"end_time":1578292103,
     * "category_id":"1111",
     * "category_name":"\u4f20\u5355\u6d3e\u53d1",
     * "position_high":"1,2,3,10",
     * "position_character":"51,52",
     * "experience":"23,12",
     * "sex":100,
     * "education":103,
     * "min_age":10,
     * "max_age":30,
     * "publish_city_id":"2001",
     * "contacts_info":
     *       {
     *           "contact_name":"\u8d75\u5b50\u8c6a",
     *           "dispaly_name":100,
     *           "contact_tel":"010-56199966",
     *           "contact_mobile":"18101020846",
     *           "contact_email":"zh@appdevs.cn",
     *           "dispaly_email":200,
     *           "contact_address":"\u5317\u4eac\u5e02\u6d77\u6dc0\u533a\u4e0a\u5730\u4e94\u8857\u7fa4\u82f1\u79d1\u6280\u56ed"
     *      },
     * "receive_info":
     *      {
     *          "receive_email":"hr@appdevs.cn",
     *          "push_email":200,
     *          "receive_mobile":"131266712321",
     *          "push_sms":100
     *      },
     * "stations_info":
     *     [{
     *          "supervisor_nums":20,
     *          "supervisor_backup":5,
     *          "supervisor_money":200,
     *          "supervisor_wage":15,
     *          "supervisor_type":103,
     *          "parttime_nums":50,
     *          "parttime_backup":30,
     *          "parttime_money":150,
     *          "parttime_wage":108,
     *          "parttime_type":201,
     *          "province_id":1008,
     *          "city_id":3213,
     *          "district_id":202,
     *          "business_district_id":298
     *          "address":"\u5317\u4eac\u5e02\u4e2d\u5173\u6751\u9f0e\u597d\u5927\u53a6",
     *          "lng":109.321221,
     *          "lat":89.212321,
     *          "start_date":1479898902,
     *          "end_date":1579898902,
     *          "work_start_time":"090000",
     *          "work_end_time":180000,
     *          "fall_in_time":140000,
     *          "fall_in_address":"\u4eba\u6c11\u5927\u5b66\u98df\u5802"
     *     }]
     * }
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"Success","code":"0","msg":"发布成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status": "FAILD","codes": "10001","msg": "发布的职位名称不能为空!"}
     */

    public function createAction() {

        if(!$this->_params['job_name']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_NAME_NO_EMPTY));
        }

        if(!$this->_params['job_desc']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_DESC_NO_EMPTY));
        }
        if(!$this->_params['experience']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_EXPERIENCE_NO_EMPTY));
        }

        $jobInfo = Job::find("job_name ='".$this->_params['job_name']."'");

        if(count($jobInfo) > 0) {
            return $this->responseJson("FAILD",Lang::_M(JOB_NAME_EXSIST));
        }

        if(!$this->_params['company_name']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_COMPANY_NO_EMPTY));
        }
        if(!$this->_params['company_id']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_COMPANY_NO_EMPTY));
        }
        $jobData['company_id'] = $this->_params['company_id'];
        $jobData['company_name'] = $this->_params['company_name'];

        if(!$this->_params['category_name']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_CATEGORY_NO_EMPTY));
        }
        if(!$this->_params['category_id']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_CATEGORY_NO_EMPTY));
        }
        $jobData['category_id'] = $this->_params['category_id'];
        $jobData['job_name'] = $this->_params['job_name'];
        $jobData['category_name'] = $this->_params['category_name'];
        $jobData['position_high'] = $this->_params['position_high'] ? $this->_params['position_high'] : '';
        $jobData['position_character'] = $this->_params['position_character'] ? $this->_params['position_character'] : '';
        $jobData['job_desc'] = $this->_params['job_desc'];
        $jobData['experience'] = $this->_params['experience'];
        $jobData['education'] = $this->_params['education'] ? $this->_params['education'] : '';
        $jobData['job_type'] = $this->_params['job_type'] ? $this->_params['job_type'] : 100;
        $jobData['sex'] = $this->_params['sex'] ? $this->_params['sex'] : 100;
        $jobData['min_age'] = $this->_params['min_age'] ? $this->_params['min_age'] : 18;
        $jobData['max_age'] = $this->_params['max_age'] ? $this->_params['max_age'] : 99;
        $jobData['publish_city_id'] = $this->_params['publish_city_id'] ? $this->_params['publish_city_id'] : 0;
        if(!$this->_params['contacts_info']['contact_name']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_CONTACTS_NAME_NO_EMPTY));
        }
        if(!$this->_params['contacts_info']['contact_tel']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_CONTACTS_TEL_NO_EMPTY));
        }
        if(!$this->_params['contacts_info']['contact_mobile']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_CONTACTS_MOBILE_NO_EMPTY));
        }
        if(!$this->_params['contacts_info']['contact_email']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_CONTACTS_EMAIL_NO_EMPTY));
        }
        if(!$this->_params['contacts_info']['contact_address']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_CONTACTS_ADDR_NO_EMPTY));
        }
        $jobData['dispaly_name'] = $this->_params['contacts_info']['dispaly_name'] ? $this->_params['contacts_info']['dispaly_name'] : 100;
        $jobData['dispaly_email'] = $this->_params['contacts_info']['dispaly_email'] ? $this->_params['contacts_info']['dispaly_email'] : 100;
        $jobData['contact_address'] = $this->_params['contacts_info']['contact_address'];
        $jobData['contact_name'] = $this->_params['contacts_info']['contact_name'];
        $jobData['contact_tel'] = $this->_params['contacts_info']['contact_tel'];
        $jobData['contact_mobile'] = $this->_params['contacts_info']['contact_mobile'];
        $jobData['contact_email'] = $this->_params['contacts_info']['contact_email'];
        if(!$this->_params['receive_info']['receive_email']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_RECEIVE_EMAIL_NO_EMPTY));
        }
        if(!$this->_params['receive_info']['receive_mobile']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_RECEIVE_MOBILE_NO_EMPTY));
        }
        $jobData['receive_email'] = $this->_params['receive_info']['receive_email'];
        $jobData['receive_mobile'] = $this->_params['receive_info']['receive_mobile'];
        $jobData['push_email'] = $this->_params['receive_info']['push_email'] ? $this->_params['receive_info']['push_email'] : 100;
        $jobData['push_sms'] = $this->_params['receive_info']['push_sms'] ? $this->_params['receive_info']['push_sms'] : 100;
        if($this->_params['stations_info']) {
            foreach($this->_params['stations_info'] as $sk => &$sv) {
                if(!$sv['supervisor_nums']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_SUPERVISOR_NUMS_NO_EMPTY));
                }
                $sv['supervisor_backup'] = $sv['supervisor_backup'] ? $sv['supervisor_backup'] : 0;
                if(!$sv['supervisor_money']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_SUPERVISOR_MONEY_NO_EMPTY));
                }
                if(!$sv['supervisor_wage']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_SUPERVISOR_WAGE_NO_EMPTY));
                }
                if(!$sv['supervisor_type']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_SUPERVISOR_TYPE_NO_EMPTY));
                }
                if(!$sv['parttime_nums']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_PARTTIME_NUMS_NO_EMPTY));
                }
                $sv['parttime_backup'] = $sv['parttime_backup'] ? $sv['parttime_backup'] : 0;
                if(!$sv['parttime_money']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_PARTTIME_MONEY_NO_EMPTY));
                }
                if(!$sv['parttime_wage']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_PARTTIME_WAGE_NO_EMPTY));
                }
                if(!$sv['parttime_type']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_PARTTIME_TYPE_NO_EMPTY));
                }
                if(!$sv['province_id']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_PROVINCE_ID_NO_EMPTY));
                }
                if(!$sv['city_id']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_CITY_ID_NO_EMPTY));
                }
                if(!$sv['district_id']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_DISTRICT_ID_NO_EMPTY));
                }
                if(!$sv['business_district_id']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_BUSINESS_DISTRICT_ID_NO_EMPTY));
                }
                if(!$sv['address']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_ADDR_NO_EMPTY));
                }
                if(!$sv['lng']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_LNG_NO_EMPTY));
                }
                if(!$sv['lat']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_LAT_NO_EMPTY));
                }
                if(!$sv['start_date']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_TIME_FAILD));
                }
                if(!$sv['end_date']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_TIME_FAILD));
                }
                if(!$sv['start_date'] || !$sv['end_date'] || ($sv['end_date'] <= $sv['start_date'])) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_TIME_FAILD));
                }

                if(!$sv['work_start_time']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_WORK_START_NO_EMPTY));
                }
                if(!$sv['work_end_time']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_WORK_END_NO_EMPTY));
                }
                if(!$sv['fall_in_time']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_FALL_IN_TIME_NO_EMPTY));
                }
                if(!$sv['fall_in_address']) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_FALL_IN_ADDR_NO_EMPTY));
                }
            }
        }
        $jobData['create_time'] = $jobData['update_time'] = $jobData['refurbish_time'] = time();
        $this->db->begin();
        $job = new Job();
        if($job->save($jobData)) {
            $jobId = $job->id;
            $jobInfo = new JobInfo();
            foreach ($this->_params['stations_info'] as $k => $v) {
                $v['job_id'] = $jobId;
                if(!$jobInfo->save($v)) {
                    $this->db->rollback();
                    return $this->responseJson("FAILD",Lang::_M(JOB_CREATE_FAILD));
                }
            }
            $this->db->commit();
            return $this->responseJson("Success",Lang::_M(JOB_CREATE_SUCCESS));
        } else {
            return $this->responseJson("FAILD",Lang::_M(JOB_CREATE_FAILD));
        }

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/update   更新职位
     * @apiUse Token
     * @apiName update
     * @apiGroup Jobs
     * @apiDescription 更新职位.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {String} job_name 职位名称.
     * @apiParam {String} job_desc 职位描述.
     * @apiParam {Number=100,200,300} job_type 职位类型(100=>全职，200=>兼职,300=>实习).
     * @apiParam {Number} category_id 职位类别ID.
     * @apiParam {String} category_name 职位类别名称.
     * @apiParam {String[]} position_high 职位亮点ID.
     * @apiParam {String[]} position_character 职位特点ID.
     * @apiParam {Number=100,200,300} sex=100 性别(100=>不限,200=>男,300=>女).
     * @apiParam {Number} education 学历要求ID(0=>不限,非0=>为实际学历要求的ID).
     * @apiParam {String} experience 工作经验要求
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
     * @apiParam (点位信息字段) {Number} job_info_id 点位ID.
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
     * @apiParam  {Number[]} del_job_ids 删除的点位ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"更新成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"职位描述不能为空"}
     */
    public function updateAction() {
        $jobId = $this->_params['jobid'];
        $jobInfo = Job::findFirst($jobId);
        if(!$jobInfo) {
            return $this->responseJson("FAILD",Lang::_M(JOB_INFO_NO_EXISE));
        }
        $jobData['company_id'] = $this->_params['company_id'];
        $jobData['company_name'] = $this->_params['company_name'];
        $jobData['category_id'] = $this->_params['category_id'];
        $jobData['job_name'] = $this->_params['job_name'];
        $jobData['category_name'] = $this->_params['category_name'];
        $jobData['position_high'] = $this->_params['position_high'] ? $this->_params['position_high'] : '';
        $jobData['position_character'] = $this->_params['position_character'] ? $this->_params['position_character'] : '';
        $jobData['job_desc'] = $this->_params['job_desc'];
        $jobData['experience'] = $this->_params['experience'];
        $jobData['education'] = $this->_params['education'] ? $this->_params['education'] : '';
        $jobData['job_type'] = $this->_params['job_type'] ? $this->_params['job_type'] : 100;
        $jobData['sex'] = $this->_params['sex'] ? $this->_params['sex'] : 100;
        $jobData['min_age'] = $this->_params['min_age'] ? $this->_params['min_age'] : 18;
        $jobData['max_age'] = $this->_params['max_age'] ? $this->_params['max_age'] : 99;
        $jobData['publish_city_id'] = $this->_params['publish_city_id'] ? $this->_params['publish_city_id'] : 0;
        $jobData['dispaly_name'] = $this->_params['contacts_info']['dispaly_name'] ? $this->_params['contacts_info']['dispaly_name'] : 100;
        $jobData['dispaly_email'] = $this->_params['contacts_info']['dispaly_email'] ? $this->_params['contacts_info']['dispaly_email'] : 100;
        $jobData['contact_address'] = $this->_params['contacts_info']['contact_address'];
        $jobData['contact_name'] = $this->_params['contacts_info']['contact_name'];
        $jobData['contact_tel'] = $this->_params['contacts_info']['contact_tel'];
        $jobData['contact_mobile'] = $this->_params['contacts_info']['contact_mobile'];
        $jobData['contact_email'] = $this->_params['contacts_info']['contact_email'];
        $jobData['receive_email'] = $this->_params['receive_info']['receive_email'];
        $jobData['receive_mobile'] = $this->_params['receive_info']['receive_mobile'];
        $jobData['push_email'] = $this->_params['receive_info']['push_email'] ? $this->_params['receive_info']['push_email'] : 100;
        $jobData['push_sms'] = $this->_params['receive_info']['push_sms'] ? $this->_params['receive_info']['push_sms'] : 100;
        $jobData['update_time'] = time();
        if(!$jobInfo->save($jobData)) {
            return $this->responseJson("Faild",Lang::_M(JOB_INFO_UPDATE_FAILD));
        }
        if($this->_params['stations_info']) {
            foreach($this->_params['stations_info'] as $sk => $sv) {
                $Jinfo = JobInfo::findFirst($sv['job_info_id']);
                if(!$Jinfo->save($sv)) {
                    return $this->responseJson("Faild",Lang::_M(JOB_INFO_UPDATE_FAILD));
                }
            }
        }
        if($this->_params['del_job_ids']) {
            foreach($this->_params['del_job_ids'] as $idk => $idv) {
                $Jinfo = JobInfo::findFirst($sv['job_info_id']);
                $Jinfo->is_delete = 200;
                if(!$Jinfo->save()) {
                    return $this->responseJson("Faild",Lang::_M(JOB_INFO_UPDATE_FAILD));
                }
            }
        }
        return $this->responseJson("Success",Lang::_M(JOB_INFO_UPDATE_SUCCESS));
    }

    /**
     * @apiVersion 1.0.0
     * @api {get} /job/list  职位列表
     * @apiUse Token
     * @apiName list
     * @apiGroup Jobs
     * @apiDescription 职位列表.
     * @apiParam {String} company_id 企业ID.
     * @apiParam {Number} status 职位状态(100=>发布中,200=>审核中,300=>未显示(301=>审核未通过,302=>已关闭),400=>已删除)
     * @apiParam {Number} create_time 发布时间
     * @apiParam {Number} refurbish_time 刷新时间
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"Success","code":"0","msg":"获取列表成功","data":{
    "codes": 0,
    "msg": "获取职位列表成功!",
    "status": "Success",
    "data": [
    {
    "id": "23",
    "company_id": "10001",
    "company_name": "云品科技",
    "job_name": "te1st职位添加",
    "job_type": "100",
    "category_id": "1111",
    "category_name": "传单派发",
    "position_high": "1,2,3,10",
    "position_character": "51,52",
    "sex": "100",
    "education": "103",
    "experience": "23,12",
    "min_age": "10",
    "max_age": "30",
    "job_desc": "职位描述不能为空",
    "publish_city_id": "2001",
    "contact_name": "赵子豪",
    "dispaly_name": "100",
    "contact_tel": "010-56199966",
    "contact_mobile": "18101020846",
    "dispaly_mobile": "100",
    "contact_email": "zh@appdevs.cn",
    "dispaly_email": "200",
    "contact_address": "北京市海淀区上地五街群英科技园",
    "receive_email": "hr@appdevs.cn",
    "push_email": "200",
    "receive_mobile": "13126671232",
    "push_sms": "100",
    "status": "200",
    "refurbish_time": "1471790501",
    "create_time": "1471790501",
    "update_time": "1471790501",
    "list": [
    {
    "id": "5",
    "job_id": "22",
    "supervisor_nums": "20",
    "supervisor_backup": "5",
    "supervisor_money": "200.00",
    "supervisor_wage": "15",
    "supervisor_type": "103",
    "parttime_nums": "50",
    "parttime_backup": "30",
    "parttime_money": "150.00",
    "parttime_wage": "108",
    "parttime_type": "201",
    "province_id": "1008",
    "city_id": "3213",
    "district_id": "202",
    "business_district_id": "298",
    "address": "北京市中关村鼎好大厦",
    "lng": "126.416094",
    "lat": "41.945409",
    "start_date": "1479898902",
    "end_date": "1579898902",
    "sign_nums": "0",
    "work_start_time": "90000",
    "work_end_time": "180000",
    "fall_in_time": "140000",
    "fall_in_address": "人民大学食堂",
    "is_delete": "100",
    "job_type": "200",
    "category_id": "1111"
    },
    {
    "id": "6",
    "job_id": "23",
    "supervisor_nums": "20",
    "supervisor_backup": "5",
    "supervisor_money": "200.00",
    "supervisor_wage": "15",
    "supervisor_type": "103",
    "parttime_nums": "50",
    "parttime_backup": "30",
    "parttime_money": "150.00",
    "parttime_wage": "108",
    "parttime_type": "201",
    "province_id": "1008",
    "city_id": "3213",
    "district_id": "202",
    "business_district_id": "298",
    "address": "北京市中关村鼎好大厦",
    "lng": "117.571438",
    "lat": "31.316441",
    "start_date": "1479898902",
    "end_date": "1579898902",
    "sign_nums": "0",
    "work_start_time": "90000",
    "work_end_time": "190000",
    "fall_in_time": "140000",
    "fall_in_address": "人民大学食堂",
    "is_delete": "100",
    "job_type": "200",
    "category_id": "1111"
    }
    ]
    }
    ]
    }
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"Faild","code":"10001","msg":"职位列表为空"}
     */
    public function listAction() {
        if($this->_params['company_id']) {
            $conditons[] = 'company_id='.$this->_params['company_id'];
        }
        if($this->_params['status']) {
            $conditons[] = 'status='.$this->_params['status'];
        }
        if($this->_params['create_time']) {
            $conditons[] = 'create_time >='.$this->_params['create_time'];
        }
        if($this->_params['refurbish_time']) {
            $conditons[] = 'refurbish_time >='.$this->_params['refurbish_time'];
        }

        $page = $this->_params['page'] ? $this->_params['page'] : 1;
        $size = $this->_params['size'] ? $this->_params['size'] : 30;
        $start = ($page - 1) * $size;

        $Jobs = Job::find([
            implode(' AND ',$conditons),
            'offset' => $start,
            'limit'  => $size,
            "order" => "refurbish_time DESC",
        ])->toArray() ;
        if(!$Jobs) {
            return $this->responseJson("Faild",Lang::_M(JOB_LIST_EMPTY));
        }
        foreach($Jobs as $Jk => $Jv) {
            $Jobs[$Jk]['list'] = JobInfo::find(['job_id' => $Jv['id']])->toArray();
        }
        return $this->responseJson("Success",Lang::_M(JOB_LIST_SUCCESS), $Jobs);
    }

    /**
     * @apiVersion 1.0.0
     * @api {get} /job/info  职位详情
     * @apiUse Token
     * @apiName info
     * @apiGroup Jobs
     * @apiDescription 职位详情.
     * @apiParam {Number} job_id 职位ID.
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
     * @apiParam {Number} province_id 省份ID
     * @apiParam {Number} city_id 城市ID
     * @apiParam {Number} district_id 区ID
     * @apiParam {Number} business_district_id 商圈ID
     * @apiParam {Number=100,200,300,400} order_type 排序类型(100=>默认排序,200=>离我最近,300=>最新发布,400=>工资最高)
     * @apiParam {Double} lng 经度(仅排序为200时使用)
     * @apiParam {Double} lng 纬度(仅排序为200时使用)
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"Success","code":"0","msg":"获取列表成功","data":"{
  "codes": 0,
    "msg": "获取职位列表成功!",
    "status": "Success",
    "data": [
    {
    "list": [
    {
    "id": "5",
    "job_id": "22",
    "supervisor_nums": "20",
    "supervisor_backup": "5",
    "supervisor_money": "200.00",
    "supervisor_wage": "15",
    "supervisor_type": "103",
    "parttime_nums": "50",
    "parttime_backup": "30",
    "parttime_money": "150.00",
    "parttime_wage": "108",
    "parttime_type": "201",
    "province_id": "1008",
    "city_id": "3213",
    "district_id": "202",
    "business_district_id": "298",
    "address": "北京市中关村鼎好大厦",
    "lng": "126.416094",
    "lat": "41.945409",
    "start_date": "1479898902",
    "end_date": "1579898902",
    "sign_nums": "0",
    "work_start_time": "90000",
    "work_end_time": "180000",
    "fall_in_time": "140000",
    "fall_in_address": "人民大学食堂",
    "is_delete": "100",
    "job_type": "200",
    "category_id": "1111",
    "distance": "946251"
    }
    ],
    "jobInfo": {
    "id": "22",
    "company_id": "10001",
    "company_name": "云品科技",
    "job_name": "test职位添加",
    "job_type": "100",
    "category_id": "1111",
    "category_name": "传单派发",
    "position_high": "1,2,3,10",
    "position_character": "51,52",
    "sex": "100",
    "education": "103",
    "experience": "23,12",
    "min_age": "10",
    "max_age": "30",
    "job_desc": "职位描述不能为空",
    "publish_city_id": "2001",
    "contact_name": "赵子豪",
    "dispaly_name": "100",
    "contact_tel": "010-56199966",
    "contact_mobile": "18101020846",
    "dispaly_mobile": "100",
    "contact_email": "zh@appdevs.cn",
    "dispaly_email": "200",
    "contact_address": "北京市海淀区上地五街群英科技园",
    "receive_email": "hr@appdevs.cn",
    "push_email": "200",
    "receive_mobile": "13126671232",
    "push_sms": "100",
    "status": "100",
    "refurbish_time": "1471787542",
    "create_time": "1471787542",
    "update_time": "1471794751"
    }
    },
    {
    "list": [
    {
    "id": "6",
    "job_id": "23",
    "supervisor_nums": "20",
    "supervisor_backup": "5",
    "supervisor_money": "200.00",
    "supervisor_wage": "15",
    "supervisor_type": "103",
    "parttime_nums": "50",
    "parttime_backup": "30",
    "parttime_money": "150.00",
    "parttime_wage": "108",
    "parttime_type": "201",
    "province_id": "1008",
    "city_id": "3213",
    "district_id": "202",
    "business_district_id": "298",
    "address": "北京市中关村鼎好大厦",
    "lng": "117.571438",
    "lat": "31.316441",
    "start_date": "1479898902",
    "end_date": "1579898902",
    "sign_nums": "0",
    "work_start_time": "90000",
    "work_end_time": "190000",
    "fall_in_time": "140000",
    "fall_in_address": "人民大学食堂",
    "is_delete": "100",
    "job_type": "200",
    "category_id": "1111",
    "distance": "1230469"
    }
    ],
    "jobInfo": {
    "id": "23",
    "company_id": "10001",
    "company_name": "云品科技",
    "job_name": "te1st职位添加",
    "job_type": "100",
    "category_id": "1111",
    "category_name": "传单派发",
    "position_high": "1,2,3,10",
    "position_character": "51,52",
    "sex": "100",
    "education": "103",
    "experience": "23,12",
    "min_age": "10",
    "max_age": "30",
    "job_desc": "职位描述不能为空",
    "publish_city_id": "2001",
    "contact_name": "赵子豪",
    "dispaly_name": "100",
    "contact_tel": "010-56199966",
    "contact_mobile": "18101020846",
    "dispaly_mobile": "100",
    "contact_email": "zh@appdevs.cn",
    "dispaly_email": "200",
    "contact_address": "北京市海淀区上地五街群英科技园",
    "receive_email": "hr@appdevs.cn",
    "push_email": "200",
    "receive_mobile": "13126671232",
    "push_sms": "100",
    "status": "200",
    "refurbish_time": "1471790501",
    "create_time": "1471790501",
    "update_time": "1471790501"
    }
    }
    ]
    }"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"Faild","code":"10001","msg":"职位列表为空"}
     */
    public function searchAction() {

        $page = $this->_params['page'] ? $this->_params['page'] : 1;
        $size = $this->_params['size'] ? $this->_params['size'] : 30;
        $start = ($page - 1) * $size;

        if($this->_params['job_type']) {
            $conditons[] = 'job_type='.$this->_params['job_type'];
        }
        if($this->_params['category_id']) {
            $conditons[] = 'category_id='.$this->_params['category_id'];
        }
        if($this->_params['province_id']) {
            $conditons[] = 'province_id='.$this->_params['province_id'];
        }
        if($this->_params['city_id']) {
            $conditons[] = 'city_id='.$this->_params['city_id'];
        }
        if($this->_params['district_id']) {
            $conditons[] = 'district_id='.$this->_params['district_id'];
        }
        if($this->_params['business_district_id']) {
            $conditons[] = 'business_district_id='.$this->_params['business_district_id'];
        }

        switch ($this->_params['order_type']) {
            case 100 :
                $sort = 'refurbish_time DESC';
                break;
            case 200 :
                $sort = ' distance ASC';
                $columns = array('*','ROUND(6378.138*2*ASIN(SQRT(POW(SIN((42.299439*PI()/180-lat*PI()/180)/2),2)+COS(22.299439*PI()/180)*COS(lat*PI()/180)*POW(SIN((116.173881*PI()/180-lng*PI()/180)/2),2)))*1000) AS distance');
                break;
            case 300 :
                $sort = 'create_time DESC';
                break;
            case 400 :
                $sort = 'parttime_money DESC';
                break;
        }


        $sql = "select *,ROUND(6378.138*2*ASIN(SQRT(POW(SIN((42.299439*PI()/180-lat*PI()/180)/2),2)+COS(22.299439*PI()/180)*COS(lat*PI()/180)*POW(SIN((116.173881*PI()/180-lng*PI()/180)/2),2)))*1000) AS distance from ys_jobs_info";
        $conditons[] = 'is_delete = 100';
        $sql .= " where ".implode(' AND ',$conditons);
        $sql .= ' order by '.$sort.' limit '.$start.','.$size;

        $jobInfoObject = new JobInfo();
        $InfoTmp =  new Resultset(null, $jobInfoObject, $jobInfoObject->getReadConnection()->query($sql));
        $Jobs = $InfoTmp->toArray();
        if(!$Jobs) {
            return $this->responseJson("Faild",Lang::_M(JOB_LIST_EMPTY));
        }
        foreach($Jobs as $Jk => $Jv) {
            $ids[] = $Jv['job_id'];
            $JobList[$Jv['job_id']]['list'][] = $Jv;
        }
        $idstr = implode(',', $ids);
        $Jsql = "select * from ys_jobs where id IN($idstr)";
        $JobObject = new Job();
        $JobTmp =  new Resultset(null, $JobObject, $JobObject->getReadConnection()->query($Jsql));
        $JobTmp = $JobTmp->toArray();
        foreach($JobList as $k => &$v) {
            foreach($JobTmp as $ik => $iv) {
                if($k == $iv['id']) {
                    $JobList[$k]['jobInfo'] =  $iv;
                }
            }
        }

        return $this->responseJson("Success",Lang::_M(JOB_LIST_SUCCESS), array_values($JobList));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/delete 删除职位
     * @apiUse Token
     * @apiName delete
     * @apiGroup Jobs
     * @apiDescription 删除职位.
     * @apiParam {Number[]} job_ids 职位ID.
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
     * @apiParam {Number} uid 报名ID.
     * @apiParam {Number} enroll_id 报名ID.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {String} sign_address 签到地址.
     * @apiParam {Number} sign_pic 签到图片.
     * @apiParam {String} remark 签到备注.
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
     * @api {post} /job/confirm  工作状态确认
     * @apiUse Token
     * @apiName past
     * @apiGroup Jobs
     * @apiDescription 签到/签退/续约确认.
     * @apiParam {Number[]} sign_ids 签到/签退id.
     * @apiParam {Number} type 操作类型(100=>签到,200=>签退).
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


    /**
     * @apiVersion 1.0.0
     * @api {post} /job/evaluate  工作评价
     * @apiUse Token
     * @apiName evaluate
     * @apiGroup Jobs
     * @apiDescription 工作评价.
     * @apiParam {Number} enroll_id 报名ID.
     * @apiParam {Number} evaluate_uid 评价人的ID(督导、BD).
     * @apiParam {Number} type 评价类型(101=>准时率,102=>热心值,103=>效果值,104=>绩效值,105=>能力值).
     * @apiParam {Float}  score 分数值
     * @apiParam {String}  evaluate_content 评价内容
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"评价成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"评价失败!"}
     */
    public function evaluateAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/evaluateInfo  获取评价详情
     * @apiUse Token
     * @apiName evaluateInfo
     * @apiGroup Jobs
     * @apiDescription 获取评价详情.
     * @apiParam {Number} enroll_id 报名ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取评价详情成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取评价详情失败!"}
     */
    public function evaluateInfoAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/renew   用户续约
     * @apiUse Token
     * @apiName renew
     * @apiGroup Jobs
     * @apiDescription 用户续约.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
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
     * @apiParam {Number} uid 用户ID.
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

}


?>