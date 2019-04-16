<?php
namespace app\user\controller;

use app\admin\model\UserModel;
use app\UserBaseController;
use think\Db;

class Index extends UserBaseController
{
    /**
     * 用户首页
     * @return mixed
     */
    public function index(){
        //获取登录用户信息
        $user = getUser();
        $this->assign($user);

        $time = time();
        //获取正在进行中的报名项目
        $items = Db::name('signup_items')
            ->field(['name','id'])
            ->where(['delete_time'=>0,'begin_time'=>['<',$time],'end_time'=>['>',$time]])
            ->limit(4)
            ->select();
        //获取最新的5条公告
        $news = Db::name('news')->where('delete_time',0)->limit('5')->select();
        $this->assign([
            'items'=>$items,
            'news'=>$news
        ]);
        return $this->fetch();
    }
    /**
     * 修改密码页面
     */
    public function changePassword(){
        //获取登录用户信息
        $user = getUser();
        $this->assign($user);
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
