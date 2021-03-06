<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 15:09
 */
namespace app\admin\controller;

use app\admin\model\UserModel;
use think\Controller;
use think\Db;

class Login extends Controller
{
    /**
     * 登录页
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }
    /**
     * 登录提交
     */
    public function doLogin(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $post = $this->request->post();
        $ip = $this->request->ip();
        $username = $post['username'];
        $password = $post['password'];
        if($username=='' || $password==''){
            $this->error('用户名密码不能为空');
        }
        $model = new UserModel();
        $result = $model->doLogin($username,$password,'admin',$ip);//登录验证
        if($result['code']==1){
            $this->success($result['msg'],'/admin/Index/index');
        }else{
            $this->error($result['msg']);
        }
    }
    /**
     * 注销
     */
    public function loginOut(){
        session('admin',null);
        $this->success('注销成功');
    }
}