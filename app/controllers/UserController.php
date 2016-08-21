<?php
namespace Controllers;

class UserController extends BaseController
{

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
     * @api {post} /user/addResume  添加简历
     * @apiUse Token
     * @apiName addResume
     * @apiGroup user
     * @apiDescription 添加用户简历.
     * @apiParam {String} avatar 用户头像.
     * @apiParam {String} nick_name 昵称.
     * @apiParam {String} name 姓名.
     * @apiParam {String} sex 性别(100=>男,200=>女).
     * @apiParam {String} birthday 生日.
     * @apiParam {String} contact_info 联系电话.
     * @apiParam {String} stature 身高.
     * @apiParam {String} native_place 籍贯.
     * @apiParam {Number} profession_status 职业状态(100=>在校,200=>毕业,300=>求职中,400=>在职,500=>离职).
     * @apiParam {String} introduce 自我介绍.
     * @apiParam {String} school 毕业院校.
     * @apiParam {Number} school_id 学校ID.
     * @apiParam {String[]} pic_urls 照片地址.
     * @apiParam {String[]} video_urls 视频地址.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"添加成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"添加失败!"}
     */
    public function addResume() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/resumeInfo  获取简历详情
     * @apiUse Token
     * @apiName resumeInfo
     * @apiGroup user
     * @apiDescription 获取简历详情.
     * @apiParam {String} uid 用户id.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取详情成功!","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取详情失败!"}
     */
    public function resumeInfo() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/resumeList  简历列表
     * @apiUse Token
     * @apiName resumeList
     * @apiGroup user
     * @apiDescription 简历列表.
     * @apiParam {Number} nick_name 用户昵称.
     * @apiParam {Number} name 姓名.
     * @apiParam {Number} sex 性别(100=>男,200=>女).
     * @apiParam {Number} start_age 起始年龄.
     * @apiParam {Number} end_age 截至年龄
     * @apiParam {Number} profession_status 职业状态(100=>在校,200=>毕业,300=>求职中,400=>在职,500=>离职).
     * @apiParam {Number} mobile 手机号码.
     * @apiParam {Number} status 用户状态(100=>正常,200=>待审核,300=已删除).
     * @apiParam {Number} is_star高级人才(100=>是,200=>否,301=>已申请待开通，302=>已开通，303=>已拒绝).
     * @apiParam {Number} start_time 用户注册起始时间.
     * @apiParam {Number} end_time 用户注册结束时间.
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取简历列表成功!","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取简历列表失败!"}
     */
    public function resumeList() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/addIntention  添加工作意向
     * @apiUse Token
     * @apiName addIntention
     * @apiGroup user
     * @apiDescription 添加工作意向.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} job_category_id 职位分类ID.
     * @apiParam {Number} job_category_name 职位分类名称.
     * @apiParam {Number} school_id 学校ID.
     * @apiParam {String} province 省.
     * @apiParam {Number} province_id 省ID.
     * @apiParam {String} city 市.
     * @apiParam {Number} city_id 市ID.
     * @apiParam {String} district 区.
     * @apiParam {Number} district_id 区ID.
     * @apiParam {Number} business_district 商圈.
     * @apiParam {Number} business_district_id 商圈ID.
     * @apiParam {Number} work_date '工作时间(101=>周一,102＝>周二,103=>周三,104=>周四,105=>周五,106=>周六,107=>周日,201=>寒假,202=>暑假).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"添加成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"添加失败!"}
     */
    public function addIntentionAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/updateIntention  更新工作意向
     * @apiUse Token
     * @apiName updateIntention
     * @apiGroup user
     * @apiDescription 更新工作意向.
     * @apiParam {Number} uid 用户ID.
     * @apiParam {Number} intention_id 工作意向ID
     * @apiParam {Number} job_category_id 职位分类ID.
     * @apiParam {Number} job_category_name 职位分类名称.
     * @apiParam {Number} school_id 学校ID.
     * @apiParam {String} province 省.
     * @apiParam {Number} province_id 省ID.
     * @apiParam {String} city 市.
     * @apiParam {Number} city_id 市ID.
     * @apiParam {String} district 区.
     * @apiParam {Number} district_id 区ID.
     * @apiParam {Number} business_district 商圈.
     * @apiParam {Number} business_district_id 商圈ID.
     * @apiParam {Number} work_date '工作时间(101=>周一,102＝>周二,103=>周三,104=>周四,105=>周五,106=>周六,107=>周日,201=>寒假,202=>暑假).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"更新成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"更新成功!"}
     */
    public function updateIntentionAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/intentionInfo  获取工作意向
     * @apiUse Token
     * @apiName intentionInfo
     * @apiGroup user
     * @apiDescription 获取工作意向.
     * @apiParam {String} uid 用户id.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取工作意向成功!", "data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取工作意向失败!"}
     */
    public function intentionInfoAction() {

    }


    /**
     * @apiVersion 1.0.0
     * @api {post} /user/authUser  实名认证
     * @apiUse Token
     * @apiName authUser
     * @apiGroup user
     * @apiDescription 实名认证.
     * @apiParam {Number} uid 用户id.
     * @apiParam {String} real_name 真是姓名.
     * @apiParam {String} card_id 身份证号.
     * @apiParam {String} card_img_a 身份证正面.
     * @apiParam {String} card_img_b 身份证反面.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"实名认证成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"实名认证失败!"}
     */
    public function authUserAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/authUserList  获取认证列表
     * @apiUse Token
     * @apiName authUserList
     * @apiGroup user
     * @apiDescription 获取认证列表.
     * @apiParam {Number} status 审核状态(100=>待审核,200=>已通过).
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取认证列表成功!","data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取认证列表失败!"}
     */
    public function authUserListAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/authVerify  认证审核
     * @apiUse Token
     * @apiName authVerify
     * @apiGroup user
     * @apiDescription 认证审核.
     * @apiParam {Number} varify_id 申请认证id
     * @apiParam {Number} status 审核状态(100=>通过,200=>拒绝).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"审核成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"审核失败!"}
     */
    public function authVerifyAction() {

    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/reputation  获取信誉值
     * @apiUse Token
     * @apiName reputation
     * @apiGroup user
     * @apiDescription 获取信誉值.
     * @apiParam {String} uid 用户id.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"100","code":"10000","msg":"获取信誉值成功!", "data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取信誉值失败!"}
     */
    public function reputationAction() {

    }



}