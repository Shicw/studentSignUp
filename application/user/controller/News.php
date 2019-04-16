<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/16
 * Time: 14:16
 */
namespace app\user\controller;
use app\UserBaseController;
use think\Db;

class News extends UserBaseController
{
    /**
     * 查看公告详情
     */
    public function detail(){
        //获取登录用户信息
        $user = getUser();
        $this->assign($user);
        $id = $this->request->param('id');
        $data = Db::name('news')->where(['delete_time'=>0,'id'=>$id])->find();
        //阅读数量+1
        Db::name('news')->where(['delete_time'=>0,'id'=>$id])->setInc('read_count',1);
        $this->assign($data);
        return $this->fetch();
    }
}