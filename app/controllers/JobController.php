<?php
namespace Controllers;

use Models\Enroll;
use Models\Evaluate;
use Models\Work;
use Phalcon\Mvc\Controller;

use Utilities\Common\Lang;

use Models\Job;

use Models\JobInfo;

use Models\JobAutoRefresh;

use Models\JobFav;

use Models\Enrol;

use Models\JobTeam;

use Models\JobCounter;

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class JobController extends BaseController {

    private $evaluateType = [101, 102, 103, 104, 105];
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
                $v['start_date'] = strtotime($v['start_date']);
                $v['end_date'] = strtotime($v['end_date']);
                $v['category_id'] = $jobData['category_id'];
                $v['job_id'] = $jobId;
                if(!$jobInfo->save($v)) {
                    $this->db->rollback();
                    return $this->responseJson("FAILD",Lang::_M(JOB_CREATE_FAILD));
                }
            }
            $this->db->commit();
            return $this->responseJson("Success", Lang::_M(JOB_CREATE_SUCCESS), ['id' => $jobId]);
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
     * {"status":"SUCCESS","code":"0","msg":"更新成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"职位描述不能为空"}
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
            return $this->responseJson("FAILD",Lang::_M(JOB_INFO_UPDATE_FAILD));
        }
        if($this->_params['stations_info']) {
            foreach($this->_params['stations_info'] as $sk => $sv) {
                $Jinfo = JobInfo::findFirst($sv['job_info_id']);
                if(!$Jinfo->save($sv)) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_INFO_UPDATE_FAILD));
                }
            }
        }
        if($this->_params['del_job_ids']) {
            foreach($this->_params['del_job_ids'] as $idk => $idv) {
                $Jinfo = JobInfo::findFirst($sv['job_info_id']);
                $Jinfo->is_delete = 200;
                if(!$Jinfo->save()) {
                    return $this->responseJson("FAILD",Lang::_M(JOB_INFO_UPDATE_FAILD));
                }
            }
        }
        return $this->responseJson("Success",Lang::_M(JOB_INFO_UPDATE_SUCCESS));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/list  职位列表
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
     * {"status":"Success","code":"0","msg":"获取列表成功","data": [
    {
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
    "status": "301",
    "refurbish_time": "1472043323",
    "create_time": "1471787542",
    "update_time": "1472090698",
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
    },
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
    "status": "301",
    "refurbish_time": "1471790501",
    "create_time": "1471790501",
    "update_time": "1472090698",
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
     * {"status":"FAILD","code":"10001","msg":"职位列表为空"}
     */
    public function listAction() {
        if($this->_params['company_id']) {
            $conditons[] = 'company_id='.$this->_params['company_id'];
        }
        if($this->_params['status'] && $this->_params['status'] != 300) {
            $conditons[] = 'status = '.$this->_params['status'];
        } elseif($this->_params['status']) {
            $conditons[] = 'status between 300 AND 400';

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
        $jobModel = new Job();
        $where =array(
            'company_id' => $this->_params['company_id'],
        );
        //全部数量
        $totalcount[0] = $jobModel->getCount($where);
        //发布中
        $where['status'] = 100;
        $totalcount[1] = $jobModel->getCount($where);
        //审核中数量
        $where['status'] = 200;
        $totalcount[2] = $jobModel->getCount($where);
        $where['$bt'] = array(
            "status" => array(300,400)

        );
        unset($where['status']);
        $totalcount[3] = $jobModel->getCount($where);
        $Jobs = Job::find([
            implode(' AND ',$conditons),
            'offset' => $start,
            'limit'  => $size,
            "order" => "refurbish_time DESC",
        ])->toArray() ;
//
//        if(!$Jobs) {
//            return $this->responseJson("FAILD",Lang::_M(JOB_LIST_EMPTY));
//        }
        if($Jobs) {
            $jonInfo =new JobInfo();
            foreach($Jobs as $Jk => $Jv) {
                $Jobs[$Jk]['list'] = $jonInfo->findAll(['job_id' => $Jv['id']])->toArray();
            }
        }
        $returnList['list'] = $Jobs ? $Jobs : array();

        $returnList['totalCount'] = $totalcount ? $totalcount : 0;
        return $this->responseJson("Success",Lang::_M(JOB_LIST_SUCCESS), $returnList);
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
     * {"status":"SUCCESS","code":"0","msg":"获取职位详情成功","data":{
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
        "status": "301",
        "refurbish_time": "1472043323",
        "create_time": "1471787542",
        "update_time": "1472090698",
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
        }
        ]
    }}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"没有该职位的信息"}
     */
    public function infoAction($job_id) {
        if(!$job_id) {
            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
        }
        $jobModel = new Job();
        $infoTmp = $jobModel->findFirst($job_id);
        $info = $infoTmp ? $infoTmp->toArray() : array();
        if(!$info) {
            return $this->responseJson("FAILD",Lang::_M(JOB_INFO_NO_EXISE));
        }
        if($info['job_desc']) {
            $info['job_desc'] = htmlspecialchars($info['job_desc']);
        }
        $jobInfoModel = new JobInfo();
        $joblist = $jobInfoModel->find('job_id='.$job_id)->toArray();
        $info['list'] = $joblist ? $joblist : array();
        return $this->responseJson("SUCCESS",Lang::_M(JOB_GET_LIST_SUCCESS), $info);
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/search   职位搜索
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
     * {"status":"Success","code":"0","msg":"获取列表成功", "data": {
    "0": {
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
    "status": "301",
    "refurbish_time": "1472043323",
    "create_time": "1471787542",
    "update_time": "1472090698"
    }
    },
    "1": {
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
    "status": "301",
    "refurbish_time": "1471790501",
    "create_time": "1471790501",
    "update_time": "1472090698"
    }
    },
    "totalCount": "2"
    }}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"职位列表为空"}
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
                $sort = 'refurbish_time';
                break;
            case 200 :
                $sort = 'distance ASC';
                break;
            case 300 :
                $sort = 'create_time';
                break;
            case 400 :
                $sort = 'parttime_money';
                break;
        }
        $sql = "select *, ROUND(6378.138*2*ASIN(SQRT(POW(SIN((42.299439*PI()/180-lat*PI()/180)/2),2)+COS(22.299439*PI()/180)*COS(lat*PI()/180)*POW(SIN((116.173881*PI()/180-lng*PI()/180)/2),2)))*1000) AS distance from ys_jobs_info";
        $conditons[] = 'is_delete = 100';
        $sql .= " where ".implode(' AND ',$conditons);
        $this->_params['order_type'] == 200 && $sql .= ' order by distance ASC ' ;
        $sql .= ' limit '.$start.','.$size;
        $jobInfoObject = new JobInfo();
        $InfoTmp =  new Resultset(null, $jobInfoObject, $jobInfoObject->getReadConnection()->query($sql));
        $Jobs = $InfoTmp->toArray();
        if(!$Jobs) {
            return $this->responseJson("FAILD",Lang::_M(JOB_LIST_EMPTY));
        }
        foreach($Jobs as $Jk => $Jv) {
            $ids[] = $Jv['job_id'];
        }
        if(isset($ids) && !empty($ids)) {
            $idstr = implode(',', $ids);
            $Jsql = "select * from ys_jobs where id IN($idstr)";
        }
        $JobObject = new Job();
        $JobTmp =  new Resultset(null, $JobObject, $JobObject->getReadConnection()->query($Jsql));
        $JobTmp = $JobTmp->toArray();
        if($JobTmp) {
            foreach($JobTmp as $jk => &$job) {
                $sSql = 'select min(start_date) as start_date, max(end_date) as end_date from ys_jobs_info where job_id ='.$job['id'];
                $jobInfoObject = new JobInfo();
                $InfoTmp =  new Resultset(null, $jobInfoObject, $jobInfoObject->getReadConnection()->query($sSql));
                $sDateAndEdate =  $InfoTmp->toArray();
                $job['start_date'] = $sDateAndEdate[0]['start_date'];
                $job['end_date'] = $sDateAndEdate[0]['end_date'];
                if($this->_params['order_type'] != 200) {
                    $jobList[$job[$sort]] = $job;
                }
            }
            krsort($jobList);
        }
        $return = array_values($JobTmp);
        return $this->responseJson("Success",Lang::_M(JOB_LIST_SUCCESS), $jobList);
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/delete 删除职位
     * @apiUse Token
     * @apiName delete
     * @apiGroup Jobs
     * @apiDescription 删除职位.
     * @apiParam {Number[]} job_ids 职位ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"审核成功","data":{
        "22": 100,
        "23": 100
        }
     * }
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"删除失败"}
     */
    public function deleteAction() {
        if(!$this->_params['job_ids'] || !is_array($this->_params['job_ids'])) {
            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
        }
        $jobModel = new Job();
        foreach($this->_params['job_ids'] as $jk => $jid) {
            $jobInfo = $jobModel->findfirst($jid);
            $uData['status'] = 400;
            $uData['update_time'] = time();
            $urst = $jobInfo->save($uData);
            $returnData[$jid] = $urst ? 100 : 220;
        }
        return $this->responseJson("SUCCESS",Lang::_M(JOB_DELETE_SUCCESS), $returnData);

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/refresh 刷新职位
     * @apiUse Token
     * @apiName refresh
     * @apiGroup Jobs
     * @apiDescription 刷新职位.
     * @apiParam {Number[]} job_id 职位ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"刷新成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"刷新失败"}
     */
    public function refreshAction() {
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
        }
        $jobModel = new Job();
        $jobInfo = $jobModel->findfirst($this->_params['job_id']);
        $uData['refurbish_time'] = time();
        $uData['update_time'] = time();
        if(!$jobInfo->save($uData)) {
            return $this->responseJson("FAILD",Lang::_M(JOB_REFRESH_FAILD));
        }
        return $this->responseJson("SUCCESS",Lang::_M(JOB_REFRESH_SUCCESS));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/audit   职位审核
     * @apiUse Token
     * @apiName audit
     * @apiGroup Jobs
     * @apiDescription 职位审核.
     * @apiParam {Number[]} job_ids 职位ID.
     * @apiParam {Number=100,200} status=100 审核状态(100=>通过,200=>拒绝)
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"审核成功","data":{
    "22": 100,
    "23": 100
    }
    }
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"审核失败"}
     */
    public function auditAction() {
        if(!$this->_params['job_ids'] || !is_array($this->_params['job_ids'])) {
            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
        }
        $jobModel = new Job();
        foreach($this->_params['job_ids'] as $jk => $jid) {
            $jobInfo = $jobModel->findfirst($jid);
            if($jobInfo->status != 200) {
                $this->responseJson("FAILD",Lang::_M(JOB_AUDIT_STATUS_ERROR));
            }
            $uData['status'] = $this->_params['status'] == 100 ? 100 : 301;
            $uData['update_time'] = time();
            $urst = $jobInfo->save($uData);
            $returnData[$jid] = $urst ? 100 : 220;
        }
        return $this->responseJson("SUCCESS",Lang::_M(JOB_AUDIT_SUCCESS), $returnData);
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/close   关闭职位
     * @apiUse Token
     * @apiName close
     * @apiGroup Jobs
     * @apiDescription 关闭职位.
     ** @apiParam {Number[]} job_id 职位ID.
     * @apiParam {Number=100,200} status=100 审核状态(100=>关闭,200=>恢复)
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"关闭成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"关闭失败"}
    */
    public function closeAction() {
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
        }
        $jobModel = new Job();
        $jobInfo = $jobModel->findfirst($this->_params['job_id']);

        $uData['status'] = $this->_params['status'] == 100 ? 302 : 100;
        $uData['update_time'] = time();
        if(!$jobInfo->save($uData)) {
            return $this->responseJson("FAILD",Lang::_M(JOB_CLOSE_FAILD));
        }
        return $this->responseJson("SUCCESS",Lang::_M(JOB_CLOSE_SUCCESS));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/autoRefresh   自动刷新设置
     * @apiUse Token
     * @apiName autoRefresh
     * @apiGroup Jobs
     * @apiDescription 自动刷新设置.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number=100,200} status=100 自动刷新(100=>打开,200=>关闭)
     * @apiParam {Number} refresh_time 自动刷新时间(仅开启时使用).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"自动刷新设置成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"自动刷新设置失败"}
     */
    public function autoRefreshAction() {
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
        }
        if($this->_params['status'] == 100 && !isset($this->_params['refresh_time'])) {
            return $this->responseJson("FAILD",Lang::_M(JOB_AUTO_INFO_FAILD));
        }
        $cData['job_id'] = $this->_params['job_id'];
        $cData['refresh_status'] = $this->_params['status'] ? $this->_params['status'] : 0;
        $cData['refresh_time'] = $this->_params['refresh_time'] ? $this->_params['refresh_time'] : 0;
        $cData['create_time'] = time();
        $autoRefreshModel = new JobAutoRefresh();
        $jobInfo = $autoRefreshModel->findOne('job_id='.$this->_params['job_id']);
        $objectName = !$jobInfo ? $autoRefreshModel : $jobInfo ;
        if(!$objectName->save($cData)) {
            return $this->responseJson("FAILD",Lang::_M(JOB_AUTO_SETTING_FAILD));
        }
        return $this->responseJson("SUCCESS",Lang::_M(JOB_AUTO_SETTING_SUCCESS));


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
     * @apiParam {Number} sign_time 签到时间.
     * @apiParam {Json} sign_pic 签到图片.
     * @apiParam {String} remark 签到备注.
     * @apiParam {Number=100,200} sign_type=100 签到/签退(100=>签到,200=>签退)
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"签到成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"签到失败"}
     */
    public function pastAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD",Lang::_M(USER_ID_NO_EMPTY));

        }
        if(!$this->_params['enroll_id']) {
            return $this->responseJson("FAILD",Lang::_M(ENROLL_ID_NO_EMPTY));
        }
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
        }
        if(!$this->_params['job_info_id']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_INFO_IDS_NO_EMPTY));
        }
        if(!$this->_params['sign_address']) {
            return $this->responseJson("FAILD",Lang::_M(SIGN_ADDR_NO_EMPTY));
        }
        if(!$this->_params['sign_pic'] || count($this->_params['sign_pic'] ) > 3) {
            return $this->responseJson("FAILD",Lang::_M(SIGN_PIC_NO_EMPTY));
        }
        $enRollModel = new Enroll();
        $ewhere = 'id='.$this->_params['enroll_id'];
        $rInfo = $enRollModel->findOne($ewhere)->toArray();
        if(!$rInfo['id']) {
            $this->responseJson("FAILD",Lang::_M(ENROLL_INFO_NO_EXSIST));
        }
        $signInfo['work_date'] = $rInfo['work_date'];
        $workModel = new Work();
        $where['enroll_id'] = $this->_params['enroll_id'];
        if($this->_params['sing_type'] == 200) {
            $where['sign_type'] = 100;
            $workInfo = $workModel->findOne($where)->toArray();
            if(!$workInfo) {
                return $this->responseJson("FAILD",Lang::_M(SIGN_TYPE_FAILD));
            }
        }
        $where['work_date'] = $rInfo['work_date'];
        $where['sign_type'] = $this->_params['sign_type'];
        $workInfo = $workModel->findOne($where);
        if($workInfo) {
            $signInfo['sign_time'] = $this->_params['sign_time'] ? $this->_params['sign_time'] : time();
            $signInfo['sign_pic'] = $this->_params['sign_pic'];
            $signInfo['sign_address'] = $this->_params['sign_address'];
            $signInfo['remark'] = $this->_params['remark'];
            $signInfo['work_date'] = $rInfo['work_date'];
            $rs = $workInfo->save($signInfo);
        } else {
            $signInfo['sign_type'] = $this->_params['sign_type'] ? $this->_params['sign_type'] : 100;
            $signInfo['sign_time'] = $this->_params['sign_time'] ? $this->_params['sign_time'] : time();
            $signInfo['sign_pic'] = $this->_params['sign_pic'];
            $signInfo['sign_address'] = $this->_params['sign_address'];
            $signInfo['uid'] = $this->_params['uid'];
            $signInfo['enroll_id'] = $this->_params['enroll_id'];
            $signInfo['job_id'] = $this->_params['job_id'];
            $signInfo['job_info_id'] = $this->_params['job_info_id'];
            $signInfo['remark'] = $this->_params['remark'];
            $signInfo['work_date'] = $rInfo['work_date'];
            $rs = $workModel->save($signInfo);
        }
        if(!$rs) {
            $T = $this->_params['sign_type'] == 100 ? 'SIGN_IN_FAILD' : 'SIGN_OUT_FAILD';
            return $this->responseJson("FAILD",Lang::_M($T));
        }
        $T = $this->_params['sign_type'] == 100 ? 'SIGN_IN_SUCCESS' : 'SIGN_OUT_SUCCESS';
        return $this->responseJson("SUCCESS",Lang::_M($T));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/pastList  职位签到/签退列表
     * @apiUse Token
     * @apiName pastList
     * @apiGroup Jobs
     * @apiDescription 职位签到列表.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} uid 用户id.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiParam {Number} type 操作类型(100=>签到,200=>签退).
     * @apiParam {Number} date 日期.
     * @apiParam {Number} status 审核状态(100=>待确认,200=>通过,300=>拒绝).
     * @apiParam {Number} show_type 查看方式(100=>默认,200=>图片).
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"确认成功","data":{
    "totalCount": "1",
        "list": [
            {
            "id": "7",
            "uid": "10002",
            "enroll_id": "1",
            "job_id": "22",
            "job_info_id": "5",
            "sign_type": "100",
            "sign_address": "银网中心A",
            "sign_time": "1472304304",
            "sign_pic": "[\"http:\\/\\/www.baidu.com\\/a.jpg\",\"http:\\/\\/baidu.com\\/b.jpg\"]",
            "remark": "淫网中心A 1",
            "work_date": "20160827",
            "confirm_status": "100",
            "confirm_uid": "0",
            "confirm_time": "0",
            "confirm_user_name": "",
            "confirm_user_position": "0"
            }
        ]
    }}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"确认失败"}
     */
    public function pastListAction() {
//        if(!$this->_params['job_id']) {
//            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
//        }
//        if(!$this->_params['uid']) {
//            return $this->responseJson("FAILD",Lang::_M(USER_ID_NO_EMPTY));
//        }
//        if(!$this->_params['job_info_id']) {
//            return $this->responseJson("FAILD",Lang::_M(JOB_INFO_IDS_NO_EMPTY));
//        }
        $page = $this->_params['page'] ? $this->_params['page'] : 1;
        $size = $this->_params['size'] ? $this->_params['size'] : 30;
        $start = ($page - 1) * $size;
        if($this->_params['show_type'] == 200) {
            $where['$ne'] = array('sign_pic' => null);
        }
        $this->_params['type'] && $where['sign_type'] = $this->_params['type'];
        $this->_params['job_id'] && $where['job_id'] = $this->_params['job_id'];
        $this->_params['date'] && $where['work_date'] = $this->_params['date'];
        $this->_params['job_info_id'] && $where['job_info_id'] = $this->_params['job_info_id'];
        $this->_params['uid'] && $where['uid'] =  $this->_params['uid'];
        $this->_params['status'] && $where['confirm_status'] =  $this->_params['status'];

        $workModel = new Work();
        $count = $workModel->getCount($where);
        $signList = $workModel->findAll($where,$start, $size)->toArray();
        if($count == 0) {
            return $this->responseJson("FAILD",Lang::_M(JOB_INFO_IDS_NO_EMPTY));
        }
        foreach($signList as $sk => &$sv) {
            $sv['sign_pic'] = json_decode($sv['sign_pic'], true);
        }
        $return['totalCount'] = $count;
        $return['list'] = $signList;
        return $this->responseJson("SUCCESS",Lang::_M(JOB_LIST_SUCCESS), $return);
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/confirm  工作状态确认
     * @apiUse Token
     * @apiName confirm
     * @apiGroup Jobs
     * @apiDescription 签到/签退/续约确认.
     * @apiParam {Number[]} sign_ids 签到/签退id.
     * @apiParam {Number} confirm_uid 确认人UID.
     * @apiParam {Number} confirm_user_name 确认人名称.
     * @apiParam {Number} confirm_user_position 确认人职位(100=>督导,200=>BD).
     * @apiParam {Number} status 状态(100=>通过,200=>拒绝).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"确认成功", "data":{
    "7": 1,
    "8": 0
        }
     * }
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"确认失败"}
    */

    public function confirmAction() {
        if(!$this->_params['sign_ids']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_SIGN_IDS_NO_EMPTY));
        }
        if(!$this->_params['status']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_SIGN_STATUS_NO_EMPTY));
        }
        if(!$this->_params['confirm_uid']) {
            return $this->responseJson("FAILD",Lang::_M(SIGN_CONFIRM_UID_NO_EMPTY));
        }
        if(!$this->_params['confirm_user_name']) {
            return $this->responseJson("FAILD",Lang::_M(SIGN_CONFIRM_NAME_NO_EMPTY));
        }
        if(!$this->_params['confirm_user_position']) {
            return $this->responseJson("FAILD",Lang::_M(SIGN_CONFIRM_POSITION_NO_EMPTY));
        }
        $work = new Work();
        foreach($this->_params['sign_ids'] as $sidk => $sid) {
            $where['id'] = $sid;
            $sInfo = $work->findOne($where);
            if($sInfo) {
                $updateInfo['confirm_status'] = $this->_params['status'] == 100 ? 200 : 300;
                $updateInfo['confirm_uid'] = $this->_params['confirm_uid'];
                $updateInfo['confirm_user_name'] = $this->_params['confirm_user_name'];
                $updateInfo['confirm_user_position'] = $this->_params['confirm_user_position'];
                $updateInfo['confirm_uid'] = time();
                $data[$sid] = $sInfo->save($updateInfo) ? 1 : 0;
            } else {
                $data[$sid] = 0;
            }
        }
        return $this->responseJson("SUCCESS",Lang::_M(SIGN_CONFIRM_STATUS_SUCCESS), $data);
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/favJob  职位收藏
     * @apiUse Token
     * @apiName fav
     * @apiGroup Jobs
     * @apiDescription 职位收藏.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} job_id 职位ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"收藏成功"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"收藏失败"}
     */
    public function favJobAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD",Lang::_M(USER_ID_NO_EMPTY));
        }
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
        }
        $jobModel = new Job();
        $jobInfo = $jobModel->findFirst($this->_params['job_id']);
        if(count($jobInfo) != 1) {
            return $this->responseJson("FAILD",Lang::_M(JOB_INFO_NO_EXISE));
        }
        $favInfo['uid'] = $this->_params['uid'];
        $favInfo['job_id'] = $this->_params['job_id'];
        $favInfo['job_name'] = $jobInfo->job_name;
        $favInfo['create_time'] = time();
        $favModel = new JobFav();
        $count = $favModel->getCount(array('uid'=>$favInfo['uid'], 'job_id'=>$favInfo['job_id']), 'ys_jobs_fav');
        if($count > 0) {
            return $this->responseJson("FAILD",Lang::_M(JOB_FAV_NO_REPEAT));
        }
        $frst = $favModel->save($favInfo);
        if(!$frst) {
            return $this->responseJson("SUCCESS",Lang::_M(JOB_FAV_FAILD));
        }
        return $this->responseJson("SUCCESS",Lang::_M(JOB_FAV_SUCCESS));

    }
    
    /**
     * @apiVersion 1.0.0
     * @api {post} /job/isFav  是否收藏职位
     * @apiUse Token
     * @apiName fav
     * @apiGroup Jobs
     * @apiDescription 职位收藏.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} job_id 职位ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0",data:1}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"请求失败"}
     */
    public function isFavAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD",Lang::_M(USER_ID_NO_EMPTY));
        }
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD",Lang::_M(JOB_IDS_NO_EMPTY));
        }
        $jobModel = new Job();
        $jobInfo = $jobModel->findFirst($this->_params['job_id']);
        if(count($jobInfo) != 1) {
            return $this->responseJson("FAILD",Lang::_M(JOB_INFO_NO_EXISE));
        }
        $favInfo['uid'] = $this->_params['uid'];
        $favInfo['job_id'] = $this->_params['job_id'];
        $favModel = new JobFav();
        $count = $favModel->getCount(array('uid'=>$favInfo['uid'], 'job_id'=>$favInfo['job_id']), 'ys_jobs_fav');
        if($count > 0) {
            return $this->responseJson("SUCCESS",Lang::_M(JOB_FAV_EXSIST), 1);
        }
        return $this->responseJson("SUCCESS",Lang::_M(JOB_FAV_NO_EXSIST), 0);

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
     * {"status":"SUCCESS","code":"0","msg":"获取职位收藏列表成功","data":{
    "totalCount": "1",
    "list": [
        {
        "id": "4",
        "uid": "10002",
        "job_id": "22",
        "job_name": "test职位添加",
        "create_time": "2016-08-27"
        }
        ]
    }
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"获取职位收藏列表失败"}
     */
    public function favJobListAction($uid) {
        if(!$uid) {
            return $this->responseJson("FAILD",Lang::_M(USER_ID_NO_EMPTY));
        }
        $page = $this->_params['page'] ? $this->_params['page']: 1;
        $size = $this->_params['size'] ? $this->_params['size']: 30;
        $start = ($page - 1) * $size;
        $favModel = new JobFav();
        $where = 'uid='.$uid;
        $favList = $favModel->findAll($where, $start, $size, 'create_time DESC')->toArray();
        $totalCount = $favModel->getCount($where);
        $return['totalCount'] = $totalCount;
        foreach($favList as $fk => &$info) {
            $info['create_time'] = date('Y-m-d', $info['create_time']);
        }
        $return['list'] = $favList;
        if(!$favList) {
            return $this->responseJson("SUCCESS",Lang::_M(JOB_FAV_LIST_EMPTY));
        }
        return $this->responseJson("SUCCESS",Lang::_M(JOB_GET_FAV_LIST_SUCCESS), $return);

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/evaluate  工作评价
     * @apiUse Token
     * @apiName evaluate
     * @apiGroup Jobs
     * @apiDescription 工作评价.
     * @apiParam {Number} enroll_id 报名ID.
     * @apiParam {Number} uid 被评价用户ID.
     * @apiParam {Number} evaluate_uid 评价人的ID(督导、BD).
     * @apiParam {Number} type 评价类型(101=>准时率,102=>热心值,103=>效果值,104=>绩效值,105=>能力值).
     * @apiParam {Float}  score 分数值
     * @apiParam {String}  evaluate_content 评价内容
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"评价成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"评价失败!"}
     */
    public function evaluateAction()
    {
        if (!$this->_params['enroll_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_ID_NO_EMPTY));
        }
        if ($this->_params['type'] && !in_array($this->_params['type'], $this->evaluateType)) {
            return $this->responseJson("FAILD", Lang::_M(EVALUATE_TYPE_FAILD));
        }
        if ($this->_params['type'] && !$this->_params['score']) {
            return $this->responseJson("FAILD", Lang::_M(EVALUATE_SOURCE_FAILD));
        }
        switch ($this->_params['type']) {
            case 101 :
                $fieldName = 'punctual';
                break;
            case 102 :
                $fieldName = 'earnest';
                break;
            case 103 :
                $fieldName = 'effect';
                break;
            case 104 :
                $fieldName = 'performance';
                break;
            case 105 :
                $fieldName = 'ability';
                break;
        }
        $evaluateModel = new Evaluate();
        $enrollEvalueateInfo = $evaluateModel->findOne(array('enroll_id' => $this->_params['enroll_id']));
        $this->_params['score'] && $eInfo[$fieldName] = $this->_params['score'];
        $eInfo['uid'] = $this->_params['uid'];
        $eInfo['enroll_id'] = $this->_params['enroll_id'];
        $eInfo['evaluate_uid'] = $this->_params['evaluate_uid'];
        $this->_params['evaluate_content'] && $eInfo['evaluate_content'] = $this->_params['evaluate_content'];
        $eInfo['evaluate_time'] = time();
        if ($enrollEvalueateInfo) {
            $rs = $enrollEvalueateInfo->save($eInfo);
        } else {
            $eInfo['create_time'] = time();
            $rs = $evaluateModel->save($eInfo);
        }
        if (!$rs) {
            return $this->responseJson("FAILD", Lang::_M(EVALUATE_USER_FAILD));
        }
        $enrollModel = new Enroll();
        $enrollInfo = $enrollModel->findOne(['id' => $this->_params['enroll_id']]);
        if($enrollInfo->evaluate_status == 100) {
            $enrollInfo->evaluate_status = 200;
            $enrollInfo->save();
        }
        return $this->responseJson("SUCCESS", Lang::_M(EVALUATE_USER_SUCCESS));
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
     * {"status":"SUCCESS","code":"0","msg":"获取评价详情成功!","data":{
    "id": "1",
    "uid": "10001",
    "enroll_id": "1",
    "evaluate_uid": "9999",
    "evaluate_time": "1472314297",
    "evaluate_content": "这小伙儿不错!!",
    "punctual": "4",
    "earnest": "1",
    "effect": "0",
    "performance": "0",
    "ability": "0",
    "create_time": "1472313835"
    }
    }
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"获取评价详情失败!"}
     */
    public function evaluateInfoAction() {
        if(!$this->_params['enroll_id']) {
            return $this->responseJson("FAILD", Lang::_M(ENROLL_ID_NO_EMPTY));
        }
        $evaluateModel = new Evaluate();
        $enrollEvalueateInfo = $evaluateModel->findOne(array('enroll_id' => $this->_params['enroll_id']));
        if(!$enrollEvalueateInfo) {
            return $this->responseJson("FAILD", Lang::_M(EVALUATE_GET_INFO_FAILD));
        }
        return $this->responseJson("SUCCESS", Lang::_M(EVALUATE_GET_INFO_SUCCESS), $enrollEvalueateInfo->toArray());
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /job/jobStatistics  获取点位统计信息
     * @apiUse Token
     * @apiName reputation
     * @apiGroup Jobs
     * @apiDescription 获取信誉值.
     * @apiParam {Number} job_id 职位ID.
     * @apiParam {Number} job_info_id 点位ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"获取统计信息成功!", "data":"{
    "list": {
    "22": {
    "sign_in_rate": 93,
    "sign_in": "28",
    "sign_in_valid": "26",
    "sign_out": "28",
    "sign_out_valid": "25",
    "EveluaCount": "24",
    "fEveluaCount": 6,
    "sign_in_vitiation": 2,
    "sign_out_vitiation": 3,
    "punctual_rate": 1,
    "earnest_rate": 0,
    "ability_rate": 1,
    "effect_rate": 1,
    "performance_rate": 0,
    "evaelua_rate": 3,
    "total_rate": 0.84466666666667
    }
    },
    "total_rate": 84
    }"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"获取统计信息失败!"}
     */
    public function jobStatisticsAction() {
        if(!$this->_params['job_id']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_IDS_NO_EMPTY));
        }
        //应签到
        $JobTeamModel = new JobTeam();
        $where[] = 'job_id='.$this->_params['job_id'];
        $this->_params['job_info_id'] && $where[] = 'id='.$this->_params['job_info_id'];
            $jobInfoObject = new JobInfo();
            $jonInfoList = $jobInfoObject->find(implode(' AND ', $where))->toArray();
        if(!$jonInfoList) {
        }
        foreach($jonInfoList as $jinfoK => $jinfo) {
            $jwhere['job_info_id'] = $jinfo['id'];
            $jobTeamUserCount = $JobTeamModel->getCount($jwhere);
            $jobTeamUserCount = 30;
            //实际签到
            $jobCounter = new JobCounter();
            $counterInfo = $jobCounter->findOne($jwhere);
            //签到率
            $return['list'][$jinfo['id']]['sign_in_rate'] = round(($counterInfo->sign_in / $jobTeamUserCount) * 100);
            //签到人数
            $return['list'][$jinfo['id']]['sign_in'] = $counterInfo->sign_in ? $counterInfo->sign_in : 0;
            //有效签到人数
            $return['list'][$jinfo['id']]['sign_in_valid'] = $counterInfo->sign_in_valid ? $counterInfo->sign_in_valid : 0;
            //签退人数
            $return['list'][$jinfo['id']]['sign_out'] = $counterInfo->sign_out ? $counterInfo->sign_out : 0;
            //签退率
            $return['list'][$jinfo['id']]['sign_out_rate'] = round(($counterInfo->sign_out / $jobTeamUserCount) * 100);

            //有效签退人数
            $return['list'][$jinfo['id']]['sign_out_valid'] = $counterInfo->sign_out_valid ? $counterInfo->sign_out_valid : 0;
            //应评价人数
            $return['list'][$jinfo['id']]['totalEveluaCount'] = $jobTeamUserCount;
            //评价人数
            $return['list'][$jinfo['id']]['eveluaCount'] = $counterInfo->evaluate ? $counterInfo->evaluate : 0;
            //未评价数
            $return['list'][$jinfo['id']]['fEveluaCount'] = $jobTeamUserCount - $counterInfo->evaluate;
            //未签到
            $return['list'][$jinfo['id']]['sign_in_vitiation'] = $counterInfo->sign_in - $counterInfo->sign_in_valid;
            //未签退
            $return['list'][$jinfo['id']]['sign_out_vitiation'] = $counterInfo->sign_out - $counterInfo->sign_out_valid;
            $eModel = new Evaluate();
            $elist = $eModel->findAll($jwhere);

            if(!$elist) {
                continue;
            }
            $elist = $elist->toArray();

            foreach($elist as $ek => $ev) {
                $punctualTmp += ($ev['punctual'] / 5) * 0.3;
                $earnestTmp += ($ev['earnest'] / 5) * 0.2;
                $abilityTmp += ($ev['ability'] / 5) * 0.25;
                $effectTmp += ($ev['effect'] / 5) * 0.2;
                $performanceTmp  += ($ev['performance'] / 5) * 0.05;
                $totalTmp += ($ev['punctual'] / 5) * 0.3 + ($ev['earnest'] / 5) * 0.2 + ($ev['ability'] / 5) * 0.25 + ($ev['effect'] / 5) * 0.2 + ($ev['performance'] / 5) * 0.05;

            }
            $return['list'][$jinfo['id']]['punctual_rate'] = round(($punctualTmp / $counterInfo->evaluate) * 100);
            $return['list'][$jinfo['id']]['earnest_rate'] = round(($earnestTmp / $counterInfo->evaluate) * 100);
            $return['list'][$jinfo['id']]['ability_rate'] = round(($abilityTmp / $counterInfo->evaluate) * 100);
            $return['list'][$jinfo['id']]['effect_rate'] = round(($effectTmp / $counterInfo->evaluate) * 100);
            $return['list'][$jinfo['id']]['performance_rate'] = round(($performanceTmp / $counterInfo->evaluate) * 100);
            $return['list'][$jinfo['id']]['evaelua_rate'] = round(($totalTmp / $counterInfo->evaluate) * 100);
            $sign_in_rate = ($counterInfo->sign_in / $jobTeamUserCount) * 0.7;
            $sign_in_valid_rate = ($counterInfo->sign_in_valid / $jobTeamUserCount) * 0.3;
            $sign_in_total = ($sign_in_rate + $sign_in_valid_rate) *0.5;
            $sign_out_rate = ($counterInfo->sign_out / $jobTeamUserCount) * 0.6;
            $sign_out_valid_rate = ($counterInfo->sign_out_valid / $jobTeamUserCount) * 0.4;
            $sign_out_total = ($sign_out_rate + $sign_out_valid_rate) *0.3;
            $evalua_rate = ($counterInfo->evaluate / $jobTeamUserCount);
            $evalua_rate_total = $evalua_rate * 0.15 * 1;
            $return['list'][$jinfo['id']]['total_rate'] = ($sign_in_total + $sign_out_total + $evalua_rate_total);
            $return['total_rate'] += $return['list'][$jinfo['id']]['total_rate'];
        }
        $return['total_rate'] = round($return['total_rate'] / count($jonInfoList) * 100);

        return $this->responseJson("SUCCESS", Lang::_M(JOB_GET_RATE_SUCCESS), $return);
    }
    
    
    public function jobPtInfoAction() {
        if(!$this->_params['job_info_id']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_IDS_NO_EMPTY));
        }
        $jobInfoModel = new JobInfo();
        $where['id'] = $this->_params['job_info_id'];
        $ptInfo = $jobInfoModel->findOne($where);
        if(!$ptInfo) {
            return $this->responseJson("FAILD", Lang::_M(JOB_INFO_NO_EXISE));
        }
        $jobInfo = $ptInfo->toArray();
        if($jobInfo) {
            $jobTeamModel = new JobTeam();
            $twhere['job_info_id'] = $jobInfo['id'];
            $twhere['type'] = 200;
            $ddInfo = $jobTeamModel->findOne($twhere);
            $ddInfo = $ddInfo ? $ddInfo->toArray() : array();
            $jobInfo['dd_uid'] = $ddInfo['uid'];
        }
        return $this->responseJson("SUCCESS", Lang::_M(JOB_GET_LIST_SUCCESS), $jobInfo);
    }

}


?>