<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 15:43
 */
namespace app\admin\controller;

use app\admin\model\UserModel;
use app\AdminBaseController;
use think\Controller;
use think\Db;

class User extends AdminBaseController
{
    /**
     * 用户列表
     * @return mixed
     */
    public function index(){
        //关键字查询
        $request = input('request.');
        $keyword = '';
        $conditions = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $conditions['name|mobile|username'] = ['like', "%$keyword%"];
        }
        $rows = Db::name('user u')
            ->field(['u.*',"FROM_UNIXTIME(u.create_time,'%Y-%m-%d %H:%i:%s') create_time",
                "FROM_UNIXTIME(u.birthday,'%Y-%m-%d') birthday"
            ])
            ->where($conditions)
            ->where(['u.type'=>1,'u.delete_time'=>0])
            ->order('u.create_time desc')
            ->paginate(15,false, [
                'query' => [
                    'keyword' => $keyword,
                ]
            ]);
        $page = $rows->render();
        $this->assign([
            'rows' => $rows,
            'page' => $page
        ]);
        return $this->fetch();
    }

    /**
     * 用户添加页面
     * @return mixed
     */
    public function add(){
        return $this->fetch();
    }

    /**
     * 用户添加提交
     */
    public function addPost(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $post = $this->request->post();
        if($post['username']==''){
            $this->error('用户名不能为空');
        }
        if($post['name']==''){
            $this->error('姓名不能为空');
        }
        $model = new UserModel();
        $result = $model->doAdd($post);//添加

        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }
    /**
     * 用户修改页面
     * @return mixed
     */
    public function edit(){
        $id = $this->request->param('id');
        //获取用户详情
        $model = new UserModel();
        $data = $model->getDetail($id);
        //加载专业班级选择框列表信息
        $classList = Db::name('class')->where(['delete_time'=>0])->select();
        $this->assign('classList',$classList);
        $this->assign($data);
        return $this->fetch();
    }

    /**
     * 修改提交
     */
    public function editPost(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $post = $this->request->post();

        $model = new UserModel();
        $post['birthday'] = strtotime($post['birthday']);
        $result = $model->doEdit($post);//添加

        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }

    /**
     * 删除用户
     */
    public function delete(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $id = $this->request->post('id');

        $model = new UserModel();
        $result = $model->doDelete($id);//删除

        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }
}