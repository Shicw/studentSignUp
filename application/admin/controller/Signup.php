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
     * 查看报名项目页面
     * @return mixed
     */
    public function index(){
        //关键字查询
        $request = input('request.');
        $keyword = '';
        $conditions = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $conditions['id|name'] = ['like', "%$keyword%"];
        }
        $rows = Db::name('signup_items')
            ->field(["FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') create_time",
                "FROM_UNIXTIME(begin_time,'%Y-%m-%d %H:%i:%s') begin_time",
                "FROM_UNIXTIME(end_time,'%Y-%m-%d %H:%i:%s') end_time",
                'id','name','description','max_student_count','real_student_count'
            ])
            ->where($conditions)
            ->where(['delete_time'=>0])
            ->order('create_time desc')
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
    /**
     * 修改页面
     * @return mixed
     */
    public function edit(){
        $id = $this->request->param('id');
        //获取详情
        $model = new SignupModel();
        $data = $model->getDetail($id);
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

        $model = new SignupModel();
        $post['begin_time'] = strtotime($post['begin_time']);
        $post['end_time'] = strtotime($post['end_time']);
        $result = $model->doEdit($post);//添加

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

        $model = new SignupModel();
        $result = $model->doDelete($id);//删除

        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }
}