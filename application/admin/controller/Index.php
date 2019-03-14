<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 15:08
 */
namespace app\admin\controller;

use app\admin\model\UserModel;
use app\AdminBaseController;
use think\Db;

class Index extends AdminBaseController
{
    public function index(){
        $time = time();
        $todayBegin = strtotime(date('Y-m-d',time()));
        //获取用户数量
        $userCount = Db::name('user')
            ->where(['delete_time'=>0,'type'=>1])
            ->count();
        //今日报名项目数量
        $itemsCount = Db::name('signup_items')
            ->where(['delete_time'=>0,'begin_time'=>['<',$time],'end_time'=>['>',$time]])
            ->count();
        //今日报名人数
        $signupLogCount = Db::name('student_signup_log')
            ->where(['delete_time'=>0,'create_time'=>['between',[$todayBegin,$todayBegin+86400]]])
            ->count();

        $loginLog = Db::name('user')->where(['delete_time'=>0])
            ->order('last_login_time desc')
            ->limit(5)->select();
        $this->assign([
            'userCount'=>$userCount,
            'itemsCount'=>$itemsCount,
            'signupLogCount'=>$signupLogCount,
            'loginLog'=>$loginLog
        ]);
        return $this->fetch();
    }
    /**
     * 修改密码页面
     */
    public function changePassword(){
        return $this->fetch();
    }
    /**
     * 修改密码提交
     */
    public function changePasswordPost(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $post = $this->request->post();
        $username = $post['username'];
        $oldPassword = $post['oldPassword'];
        $newPassword = $post['newPassword'];
        if($username=='' || $newPassword=='' || $oldPassword==''){
            $this->error('用户名,旧密码和新密码不能为空');
        }
        $model = new UserModel();
        $result = $model->changePassword($username,$oldPassword,$newPassword);//登录验证
        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }

}
