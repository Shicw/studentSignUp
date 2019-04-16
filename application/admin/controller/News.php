<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/16
 * Time: 13:04
 */
namespace app\admin\controller;

use app\admin\model\NewsModel;
use app\AdminBaseController;
use think\Controller;
use think\Db;
use think\Validate;

class News extends AdminBaseController
{
    /**
     * 查看公告列表
     * @return mixed
     */
    public function index(){
        //关键字查询
        $request = input('request.');
        $keyword = '';
        $conditions = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $conditions['title'] = ['like', "%$keyword%"];
        }
        $rows = Db::name('news')
            ->field(["FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') create_time",
                'id','title','content','read_count'
            ])
            ->where($conditions)
            ->where(['delete_time'=>0])
            ->order('id desc')
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
     * 查看公告详情
     */
    public function detail(){
        $id = $this->request->param('id');
        $data = Db::name('news')->where(['delete_time'=>0,'id'=>$id])->find();
        //阅读数量+1
        Db::name('news')->where(['delete_time'=>0,'id'=>$id])->setInc('read_count',1);
        $this->assign($data);
        return $this->fetch();
    }
    /**
     * 发布公告页面
     * @return mixed
     */
    public function add(){
        return $this->fetch();
    }

    /**
     * 发布提交
     */
    public function addPost(){
        //php后端验证
        if ($this->request->isPost()) {
            $validate = new Validate([
                'title' => 'require|min:4|max:255',
                'content' => 'require|min:4'
            ]);
            $validate->message([
                'title.require' => '标题不能为空',
                'title.min' => '标题最少4个字符',
                'title.max' => '标题最多255个字符',
                'content.require' => '内容不能为空',
                'content.min' => '内容最少4个字符',
                //'content.max' => '内容最多800个字符'
            ]);
            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            $model = new NewsModel();
            $result1 = $model->doAdd($data);
            if ($result1){
                $this->success('发布成功！',url('admin/News/index'));
            }else{
                $this->error('发布失败！');
            }
        }else{
            $this->error('请求错误');
        }
    }
    /**
      * 编辑公告页面
      * @return mixed
      */
    public function edit(){
        $id = $this->request->param('id');
        $data = Db::name('news')->where(['delete_time'=>0,'id'=>$id])->find();
        $this->assign($data);
        return $this->fetch();
    }

    /**
     * 公告修改提交
     */
    public function editPost(){
        //php后端验证
        if ($this->request->isPost()) {
            $validate = new Validate([
                'title' => 'require|min:4|max:255',
                'content' => 'require|min:4'
            ]);
            $validate->message([
                'title.require' => '标题不能为空',
                'title.min' => '标题最少4个字符',
                'title.max' => '标题最多255个字符',
                'content.require' => '内容不能为空',
                'content.min' => '内容最少4个字符',
                //'content.max' => '内容最多800个字符'
            ]);
            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            $model = new NewsModel();
            $result1 = $model->doEdit($data);
            if ($result1){
                $this->success('编辑成功！',url('admin/News/index'));
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $this->error('请求错误');
        }
    }

    /**
     * 删除公告
     */
    public function delete(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $id = $this->request->post('id');
        $model = new NewsModel();
        $result = $model->doDelete($id);

        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }
}