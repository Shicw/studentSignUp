<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13
 * Time: 17:12
 */
namespace app\user\controller;

use app\admin\model\UserModel;
use think\Controller;
use think\Db;
use think\Validate;

class Register extends Controller
{
    /**
     * 注册页面
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * 注册提交
     */
    public function doRegister(){
        if ($this->request->isPost()) {
            $validate = new Validate([
                'username' => 'require|max:20|min:6',
                'password' => 'require|alphaDash|max:20|min:6',
            ]);
            $validate->message([
                'username.require' => '用户名不能为空',
                'username.min' => '用户名至少6个字符',
                'username.max' => '用户名最多20个字符',
                'password.require' => '密码不能为空',
                'password.min' => '密码最少6个字符',
                'password.max' => '密码最多20个字符',
                'password.alphaDash' => '字母、数字,-和_',
            ]);
            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $model = new UserModel();
            $result = $model->doRegister($data);
            if ($result['code']===1) {
                $this->error($result['msg'],url('/user/Login/index'));
            }
            $this->success($result['msg']);
        } else {
            $this->error("请求错误");
        }
    }

}