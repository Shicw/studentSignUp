<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 15:51
 */
namespace app\admin\controller;

use app\admin\model\ClassModel;
use app\admin\model\UserModel;
use app\AdminBaseController;
use think\Controller;
use think\Db;

class Classes extends AdminBaseController
{
    /**
     * 班级管理页
     */
    public function index(){
        //获取班级列表
        $rows = Db::name('class')->where(['delete_time'=>0])->paginate(15,false);
        $page = $rows->render();
        $this->assign([
            'rows' => $rows,
            'page' => $page
        ]);
        return $this->fetch();
    }
    /**
     * 添加班级
     */
    public function addPost(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $post = $this->request->post();
        if($post['name']==''){
            $this->error('班级名称不能为空');
        }
        $model = new ClassModel();
        $result = $model->doAdd($post);//添加

        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }
    /**
     * 获取详情
     */
    public function getDetail(){
        $id = $this->request->param('id');
        //获取班级信息
        $model = new ClassModel();
        $result = $model->getDetail($id);

        $this->success('请求成功','',$result);
    }
    /**
     * 修改班级提交
     */
    public function editPost(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $post = $this->request->post();

        $model = new ClassModel();
        $result = $model->doEdit($post);

        if($result['code']==1){

            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }
    /**
     * 删除班级
     */
    public function delete(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $id = $this->request->post('id');

        $model = new ClassModel();
        $result = $model->doDelete($id);//删除

        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }
}