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
        //获取选课起止时间设置
        $selectStartStopTime = Db::name('option')->where('name','select_start_and_stop_time')->value('value');
        $selectStartStopTime = json_decode($selectStartStopTime,1);
        $this->assign('select',$selectStartStopTime);
        //获取选课起止时间设置
        $createStartStopTime = Db::name('option')->where('name','create_start_and_stop_time')->value('value');
        $createStartStopTime = json_decode($createStartStopTime,1);
        $this->assign('create',$createStartStopTime);
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
            addLog('修改密码',getAdminId());//记录日志
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }
    /**
     * 选课起止时间设置
     */
    public function selectTimeSetting(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $post = $this->request->post();
        $startTime = strtotime($post['startTime']);
        $stopTime  = strtotime($post['stopTime']);
        if($stopTime <= $startTime){
            $this->error('结束时间不能小于开始时间');
        }
        $option = json_encode(['start_time'=>$startTime,'stop_time'=>$stopTime]);
        $result = Db::name('option')->where('name','select_start_and_stop_time')->update(['value'=>$option]);
        if($result){
            addLog('修改选课起止时间',getAdminId());//记录日志
            $this->success('修改成功');
        }else{
            $this->error('没有新的修改信息');
        }
    }
    /**
     * 开课起止时间设置
     */
    public function createTimeSetting(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $post = $this->request->post();
        $startTime = strtotime($post['startTime']);
        $stopTime  = strtotime($post['stopTime']);
        if($stopTime <= $startTime){
            $this->error('结束时间不能小于开始时间');
        }
        $option = json_encode(['start_time'=>$startTime,'stop_time'=>$stopTime]);
        $result = Db::name('option')->where('name','create_start_and_stop_time')->update(['value'=>$option]);
        if($result){
            addLog('修改开课起止时间',getAdminId());//记录日志
            $this->success('修改成功');
        }else{
            $this->error('没有新的修改信息');
        }
    }
}
