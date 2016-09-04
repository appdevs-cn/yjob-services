<?php
namespace Controllers;

use Models\Evaluate;
use Models\Intention;
use Models\JobTeam;
use Models\Verify;
use Models\Work;
use Utilities\Common\Lang;

use Models\User;

use Models\WorkCounter;

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

     private $work_date = array(
         101 => '周一',
         102 => '周二',
         103 => '周三',
         104 => '周四',
         105 => '周五',
         106 => '周六',
         107 => '周日',
         201 => '寒假',
         202 => '暑假'
     );
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
     * {"status":"SUCCESS","code":"0","msg":"添加成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"添加失败!"}
     */
    public function addResumeAction() {
        if(!$this->_params['nick_name']) {
            return $this->responseJson("FAILD", Lang::_M(USER_NICK_NAME_NOT_EMPTY));

        }
        if(!$this->_params['name']) {
            return $this->responseJson("FAILD", Lang::_M(USER_NAME_NOT_EMPTY));
        }
        if(!$this->_params['sex']) {
            return $this->responseJson("FAILD", Lang::_M(USER_SEX_NOT_EMPTY));
        }
        if(!$this->_params['birthday']) {
            return $this->responseJson("FAILD", Lang::_M(USER_BIRTHDAY_NOT_EMPTY));
        }
        if(!$this->_params['contact_info']) {
            return $this->responseJson("FAILD", Lang::_M(USER_CONTACT_INFO_NOT_EMPTY));
        }
        if(!$this->_params['native_place']) {
            return $this->responseJson("FAILD", Lang::_M(USER_NATIVE_PLACE_NOT_EMPTY));
        }
        if(!$this->_params['profession_status']) {
            return $this->responseJson("FAILD", Lang::_M(USER_PROFESSION_STATUS_NOT_EMPTY));
        }
        if(!$this->_params['introduce']) {
            return $this->responseJson("FAILD", Lang::_M(USER_INTRODUCE_NOT_EMPTY));
        }
        if(!$this->_params['school']) {
            return $this->responseJson("FAILD", Lang::_M(USER_SCHOOL_NOT_EMPTY));
        }
        if(!$this->_params['school_id']) {
            return $this->responseJson("FAILD", Lang::_M(USER_SCHOOL_ID_NOT_EMPTY));
        }

        $this->_params['avatar'] && $resume['avatar'] = $this->_params['avatar'];
        $resume['uid'] = $this->_params['uid'];
        $resume['nick_name'] = $this->_params['nick_name'];
        $resume['name'] = $this->_params['name'];
        $resume['sex'] = $this->_params['sex'];
        $resume['birthday'] = $this->_params['birthday'];
        $currentYear = date('Y', time());
        $birthdayYear = substr($resume['birthday'], 0, 4);
        $resume['age'] = $currentYear-$birthdayYear;
        $resume['contact_info'] = $this->_params['contact_info'];
        $this->_params['stature'] && $resume['stature'] = $this->_params['stature'];
        $resume['native_place'] = $this->_params['native_place'];
        $resume['profession_status'] = $this->_params['profession_status'];
        $resume['introduce'] = $this->_params['introduce'];
        $resume['school'] = $this->_params['school'];
        $resume['school_id'] = $this->_params['school_id'];
        $this->_params['pic_urls'] && $resume['pic_urls'] = $this->_params['pic_urls'];
        $this->_params['video_urls'] && $resume['video_urls'] = $this->_params['video_urls'];
        $resume['create_time'] = time();
        $userModel = new User();
        $where[] = 'nick_name = \''.$this->_params['nick_name'].'\'';
        //$where[] = 'name = \''.$this->_params['name'].'\'';
        $where[] = 'contact_info = '.$this->_params['contact_info'];
        $whereStr = implode(" OR ", $where);
        $userExist = $userModel->findFirst(array($whereStr));
        if($userExist) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_EXSIST));
        }
        if(!$userModel->save($resume)) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_ADD_FAILD));
        }
        return $this->responseJson("SUCCESS", Lang::_M(RESUME_ADD_SUCCESS));
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
     * {"status":"SUCCESS","code":"0","msg":"获取详情成功!","data":"{
    "info": {
    "id": "10000",
    "uid": "10001",
    "avatar": "",
    "nick_name": "赵老蔫",
    "name": "赵梓皓",
    "sex": "100",
    "birthday": "19870624",
    "contact_info": "18910271624",
    "stature": "0",
    "native_place": "辽宁",
    "profession_status": "100",
    "school": "北京理工大学",
    "introduce": "这里是自我介绍",
    "school_id": "10001",
    "is_star": "200",
    "real_name": "",
    "card_id": "",
    "card_img_a": "",
    "card_img_b": "",
    "status": "200",
    "is_verify": "100",
    "create_time": "1472385952"
    }
    }"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"获取详情失败!"}
     */
    public function resumeInfoAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_UID_NO_EMPTY));
        }
        $where['uid'] = $this->_params['uid'];
        $where['$IN'] = array('status'=>array(100,200));
        $userModel = new User();
        $resumeInfo = $userModel->findOne($where);
        if(!$resumeInfo->name) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_GET_RESUMEINFO_FAILD));
        }
        $return['info'] = $resumeInfo->toArray();
        return $this->responseJson("SUCCESS", Lang::_M(RESUME_GET_RESUMEINFO_SUCCESS), $return);
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/resumeList  简历列表
     * @apiUse Token
     * @apiName resumeList
     * @apiGroup user
     * @apiDescription 简历列表.
     * @apiParam {String} nick_name 用户昵称.
     * @apiParam {String} name 姓名.
     * @apiParam {Number} sex 性别(100=>男,200=>女).
     * @apiParam {Number} start_age 起始年龄.
     * @apiParam {Number} end_age 截至年龄
     * @apiParam {Number} profession_status 职业状态(100=>在校,200=>毕业,300=>求职中,400=>在职,500=>离职).
     * @apiParam {Number} mobile 手机号码.
     * @apiParam {Number} status 简历状态(100=>正常,200=>待审核,300=已删除).
     * @apiParam {Number} is_star 高级人才(100=>是,200=>否,301=>已申请待开通，302=>已开通，303=>已拒绝).
     * @apiParam {Number} start_time 用户注册起始时间.
     * @apiParam {Number} end_time 用户注册结束时间.
     * @apiParam {Number} page 页码.
     * @apiParam {Number} size 每页返回数量.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"获取简历列表成功!","data":"{
    "list": [
    {
    "id": "10001",
    "uid": "10001",
    "avatar": "",
    "nick_name": "赵老蔫",
    "name": "赵梓皓",
    "sex": "100",
    "birthday": "19870624",
    "age": "29",
    "contact_info": "18910271624",
    "stature": "0",
    "native_place": "辽宁",
    "profession_status": "100",
    "school": "北京理工大学",
    "introduce": "这里是自我介绍",
    "school_id": "10001",
    "is_star": "200",
    "real_name": "",
    "card_id": "",
    "card_img_a": "",
    "card_img_b": "",
    "status": "200",
    "is_verify": "100",
    "create_time": "1472983156"
    }
    ]"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"200","code":"10001","msg":"获取简历列表失败!"}
     */
    public function resumeListAction() {
        if($this->_params['start_time'] && !$this->_params['end_time']) {
            $this->_params['end_time'] = time();
        }
        if($this->_params['end_time'] && !$this->_params['start_time']) {
            $this->_params['start_time'] = time();
        }
        if($this->_params['end_time'] && $this->_params['start_time']) {
            $where['$BT'] = array('create_time' => array($this->_params['start_time'],$this->_params['end_time']));
        }
        if($this->_params['start_age']) {
            $where['$gte'] = array('age' => $this->_params['start_age']);
        }
        if($this->_params['end_age']) {
            $where['$lte'] = array('age' => $this->_params['end_age']);
        }
        if($this->_params['start_age'] && $this->_params['end_age']) {
            $where['$BT'] = array('age' => array($this->_params['start_age'],$this->_params['end_age']));
        }

        $this->_params['nick_name'] && $where['nick_name'] = $this->_params['nick_name'];
        $this->_params['name'] && $where['name'] = $this->_params['name'];
        $this->_params['sex'] && $where['sex'] = $this->_params['sex'];
        $this->_params['profession_status'] && $where['profession_status'] = $this->_params['profession_status'];
        $this->_params['mobile'] && $where['mobile'] = $this->_params['mobile'];
        $this->_params['status'] && $where['status'] = $this->_params['status'];
        $this->_params['is_star'] && $where['is_star'] = $this->_params['is_star'];
        $page = $this->_params['page'] ? $this->_params['page'] : 1;
        $size = $this->_params['size'] ? $this->_params['size'] : 30;
        $start = ($page - 1) * $size;
        $userModel = new User();
        $resumeList = $userModel->findAll($where, $start, $size);
        if(!$resumeList) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_LIST_EMPTY));
        }
        return $this->responseJson("SUCCESS", Lang::_M(RESUME_LIST_SUCCESS), array('list' => $resumeList->toArray()));
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
     * @apiParam {String} school 学校名称.
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
     * {"status":"SUCCESS","code":"0","msg":"添加成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"添加失败!"}
     */
    public function addIntentionAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_UID_NO_EMPTY));
        }
        if(!$this->_params['job_category_id']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_CATEGORY_ID_NO_EMPTY));
        }
        if(!$this->_params['job_category_name']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_CATEGORY_NAME_NO_EMPTY));
        }
        if(!$this->_params['school_id']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_SCHOOL_ID_NO_EMPTY));
        }
        if(!$this->_params['school']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_SCHOOL_NO_EMPTY));
        }
        if(!$this->_params['province']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_PROVINCE_NO_EMPTY));
        }
        if(!$this->_params['province_id']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_PROVINCE_ID_NO_EMPTY));
        }
        if(!$this->_params['city']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_CITY_NO_EMPTY));
        }
        if(!$this->_params['city_id']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_CITY_ID_NO_EMPTY));
        }
        if(!$this->_params['district']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_DISTRICT_NO_EMPTY));
        }
        if(!$this->_params['district_id']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_DISTRICT_ID_NO_EMPTY));
        }
        if(!$this->_params['business_district']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_BUSINESS_DISTRICT_NO_EMPTY));
        }
        if(!$this->_params['business_district_id']) {
            return $this->responseJson("FAILD", Lang::_M(JOB_BUSINESS_DISTRICT_ID_NO_EMPTY));
        }
        if(!$this->_params['work_date']) {
            return $this->responseJson("FAILD", Lang::_M(WORK_DATE_NO_EMPTY));
        }
        $this->_params['create_time'] = time();
        $Intention = new Intention();
        $addRst = $Intention->create($this->_params);
        if(!$addRst) {
            return $this->responseJson("FAILD", Lang::_M(ADD_INTENTION_FAILD));
        }
        return $this->responseJson("SUCCESS", Lang::_M(ADD_INTENTION_SUCCESS));
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
     * @apiParam {String} school 学校名称.
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
     * {"status":"SUCCESS","code":"0","msg":"更新成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"更新失败!"}
     */
    public function updateIntentionAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_UID_NO_EMPTY));
        }
        if(!$this->_params['intention_id']) {
            return $this->responseJson("FAILD", Lang::_M(INTENTION_ID_NO_EMPTY));
        }
        $this->_params['job_category_id'] && $updateInfo['job_category_id'] = $this->_params['job_category_id'];
        $this->_params['job_category_name'] && $updateInfo['job_category_name'] = $this->_params['job_category_name'];
        $this->_params['school_id'] && $updateInfo['school_id'] = $this->_params['school_id'];
        $this->_params['school'] && $updateInfo['school'] = $this->_params['school'];
        $this->_params['province'] && $updateInfo['province'] = $this->_params['province'];
        $this->_params['province_id'] && $updateInfo['province_id'] = $this->_params['province_id'];
        $this->_params['city'] && $updateInfo['city'] = $this->_params['city'];
        $this->_params['city_id'] && $updateInfo['city_id'] = $this->_params['city_id'];
        $this->_params['district'] && $updateInfo['district'] = $this->_params['district'];
        $this->_params['district_id'] && $updateInfo['district_id'] = $this->_params['district_id'];
        $this->_params['business_district'] && $updateInfo['business_district'] = $this->_params['business_district'];
        $this->_params['business_district_id'] && $updateInfo['business_district_id'] = $this->_params['business_district_id'];
        $this->_params['work_date'] && $updateInfo['work_date'] = $this->_params['work_date'];
        $where['uid'] = $this->_params['uid'];
        $where['id'] = $this->_params['intention_id'];
        $intentionModel = new Intention();
        $intention = $intentionModel->findOne($where);
        if(!$intention) {
            return $this->responseJson("FAILD", Lang::_M(INTENTION_NO_EXIST));
        }
        $urst = $intention->update($updateInfo);
        if(!$urst) {
            return $this->responseJson("FAILD", Lang::_M(INTENTION_UPDATE_FAILD));
        }
        return $this->responseJson("SUCCESS", Lang::_M(INTENTION_UPDATE_SUCCCESS));
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
     * {"status":"SUCCESS","code":"0","msg":"获取工作意向成功!", "data":""}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"获取工作意向失败!"}
     */
    public function intentionInfoAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_UID_NO_EMPTY));
        }
        $where['uid'] = $this->_params['uid'];
        $intentionModel = new Intention();
        $intentionInfo = $intentionModel->findOne($where);
        if(count($intentionInfo) <= 0) {
            return $this->responseJson("FAILD", Lang::_M(INTENTION_NO_EXIST));
        }
        $intention = $intentionInfo->toArray();
        $intention['create_time'] = date('Y-m-d', $intention['create_time']);
        $intention['work_date_id'] = $intention['work_date'];
        $intention['work_date'] = $this->work_date[$intention['work_date']];
        $return['info'] = $intention;
        return $this->responseJson("SUCCESS", Lang::_M(INTENTION_GET_SUCCESS), $return);
    }


    /**
     * @apiVersion 1.0.0
     * @api {post} /user/authUser  实名认证
     * @apiUse Token
     * @apiName authUser
     * @apiGroup user
     * @apiDescription 实名认证.
     * @apiParam {Number} uid 用户id.
     * @apiParam {String} real_name 真实姓名.
     * @apiParam {String} card_id 身份证号.
     * @apiParam {String} card_img_a 身份证正面.
     * @apiParam {String} card_img_b 身份证反面.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"认证申请成功,请耐心等待审核!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"认证申请失败!"}
     */
    public function authUserAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_UID_NO_EMPTY));
        }
        if(!$this->_params['real_name']) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_REAL_NAME_NOT_EMPTY));
        }
        if(!$this->_params['card_id']) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_CARD_ID_NOT_EMPTY));
        }
        if(!$this->_params['card_img_a']) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_CARD_IMG_A_NOT_EMPTY));
        }
        if(!$this->_params['card_img_a']) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_CARD_IMG_B_NOT_EMPTY));
        }
        $authInfo['uid'] = $this->_params['uid'];
        $authInfo['real_name'] = $this->_params['real_name'];
        $authInfo['card_id'] = $this->_params['card_id'];
        $authInfo['card_img_a'] = $this->_params['card_img_a'];
        $authInfo['card_img_b'] = $this->_params['card_img_b'];
        $verifyModel = new Verify();
        $where['uid'] = $this->_params['uid'];
        $verifyInfo = $verifyModel->findOne($where);
        if($verifyInfo) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_NO_REAPTE));
        }
        $authInfo['uid'] = $this->_params['uid'];
        $authInfo['status'] = 100;
        $authInfo['create_time'] = time();
        $verifyRst = $verifyModel->create($authInfo);
        if(!$verifyRst) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_FAILD));
        }
        return $this->responseJson("SUCCESS", Lang::_M(VERIFY_SUCCESS));

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
     * {"status":"SUCCESS","code":"0","msg":"获取认证列表成功!","data":"{
    "list": [
    {
    "id": "3",
    "uid": "10001",
    "real_name": "zhaokun",
    "card_id": "21148119890624501X",
    "card_img_a": "http://www.baidu.com/a",
    "card_img_b": "http://www.baidu.com/b",
    "status": "100",
    "create_time": "2016-09-04 20:59:29"
    }
    ]
    }"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"获取认证列表失败!"}
     */
    public function authUserListAction() {
        $status = $this->_params['status'] ? $this->_params['status'] : 100;
        $page = $this->_params['page'] ? $this->_params['page'] : 1;
        $size = $this->_params['size'] ? $this->_params['size'] : 30;
        $start = ($page - 1) * $size;
        $where['status'] = $status;
        $verifyModel = new Verify();
        $verifyList = $verifyModel->findAll($where,$start, $size);
        if($verifyList) {
            $verifyListArr = $verifyList->toArray();
            foreach($verifyListArr as $vk => &$verify) {
                $verify['create_time'] = date('Y-m-d H:i:s', $verify['create_time']);
            }
            return $this->responseJson("SUCCESS", Lang::_M(VERIFY_LIST_GET_SUCCESS), array('list'=>$verifyListArr));
        }
        return $this->responseJson("FAILD", Lang::_M(VERIFY_LIST_GET_FAILD));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/authVerify  认证审核
     * @apiUse Token
     * @apiName authVerify
     * @apiGroup user
     * @apiDescription 认证审核.
     * @apiParam {Number} verify_id 申请认证id
     * @apiParam {Number} status 审核状态(100=>通过,200=>拒绝).
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"审核成功!"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"审核失败!"}
     */
    public function authVerifyAction() {
        if(!$this->_params['verify_id']) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_ID_NOT_TMPEY));
        }
        if(!$this->_params['status']) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_STATUS_NOT_TMPEY));
        }

        $where['id'] = $this->_params['verify_id'];
        $verifyModel = new Verify();
        $verifyInfo = $verifyModel->findOne($where);
        if(!$verifyInfo) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_INFO_NOT_EXIST));
        }
        $upInfo['status'] = $this->_params['status'];
        $upRst = $verifyInfo->update($upInfo);
        if(!$upRst) {
            return $this->responseJson("FAILD", Lang::_M(VERIFY_USER_FAILD));
        }
        return $this->responseJson("SUCCESS", Lang::_M(VERIFY_USER_SUCCESS));
    }

    /**
     * @apiVersion 1.0.0
     * @api {post} /user/reputation  获取信誉值
     * @apiUse Token
     * @apiName reputation
     * @apiGroup user
     * @apiDescription 获取信誉值.
     * @apiParam {Number} uid 职位ID.
     * @apiUse Response
     * @apiSuccessExample {json} 成功返回样例:
     * {"status":"SUCCESS","code":"0","msg":"获取信誉值成功!", "data":"{
    "info": {
    "mount_guard": "50",
    "cancel": "10",
    "stood": "20",
    "leaveEarly": "12",
    "punctual": 0,
    "earnest": 0,
    "effect": 0,
    "performance": 0,
    "ability": 0
    }
    }"}
     * @apiUse Response
     * @apiErrorExample {json} 失败返回样例
     * {"status":"FAILD","code":"10001","msg":"获取信誉值失败!"}
     */
    public function reputationAction() {
        if(!$this->_params['uid']) {
            return $this->responseJson("FAILD", Lang::_M(RESUME_UID_NO_EMPTY));
        }
        $where['uid'] = $this->_params['uid'];
        $userCounter = new WorkCounter();
        $counterinfo = $userCounter->findOne($where);
        if(!$counterinfo) {
            return $this->responseJson("FAILD", Lang::_M(USER_WORK_INFO_EMPTY));

        }
        $return['mount_guard'] = $counterinfo->mount_guard ? $counterinfo->mount_guard : 0;
        $return['cancel'] = $counterinfo->cancel ? $counterinfo->cancel : 0;
        $return['stood'] = $counterinfo->stood ? $counterinfo->stood : 0;
        $return['leaveEarly'] = $counterinfo->leaveEarly ? $counterinfo->leaveEarly : 0;
        $evaluteModel = new Evaluate();
        $evainfo = $evaluteModel->findAll($where);
        if($evainfo) {
            $evainList = $evainfo->toArray();
            foreach($evainList as $ek => $einfo) {
                $punctualTmp += $einfo['punctual'];
                $earnestTmp += $einfo['earnest'];
                $effectTmp += $einfo['effect'];
                $performanceTmp += $einfo['performance'];
                $abilityTmp += $einfo['ability'];
            }

        }
        $return['punctual'] = $punctualTmp ? round(($punctualTmp / $counterinfo->mount_guard )) * 100 : 0;
        $return['earnest'] = $earnestTmp ? round(($earnestTmp / $counterinfo->mount_guard)) * 100 : 0;
        $return['effect'] = $effectTmp ? round(($effectTmp / $counterinfo->mount_guard)) * 100 : 0;
        $return['performance'] = $performanceTmp ? round(($performanceTmp / $counterinfo->mount_guard)) * 100 : 0;
        $return['ability'] = $abilityTmp ? round(($abilityTmp / $counterinfo->mount_guard)) * 100 : 0;
        return $this->responseJson("SUCCESS", Lang::_M(GET_USER_REPUTATION_SUCCESS), array('info' => $return));

    }

}