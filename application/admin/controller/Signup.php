<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/12
 * Time: 10:29
 */
namespace app\admin\controller;

use app\admin\model\SignupModel;
use app\AdminBaseController;
use think\Controller;
use think\Db;

class Signup extends AdminBaseController
{
    /**
     * 新建报名项目页面
     */
    public function add(){
        return $this->fetch();
    }

    /**
     * 新建报名提交
     */
    public function addPost(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $post = $this->request->post();
        $model = new SignupModel();
        $result = $model->doAdd($post);//添加

        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }

}