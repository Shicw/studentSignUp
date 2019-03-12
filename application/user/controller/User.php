<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/12
 * Time: 11:40
 */
namespace app\user\controller;
use app\admin\model\UserModel;
use app\UserBaseController;
use think\Db;

class User extends UserBaseController
{
    /**
     * 个人信息页面
     */
    public function info(){
        //获取session中登录用户信息
        $user = getUser();
        //根据班级id获取专业班级
        $user['class'] = Db::name('class')->where('id',$user['class_id'])->value('name');
        $this->assign($user);
        //加载专业班级选择框列表信息
        $classList = Db::name('class')->where(['delete_time'=>0])->select();
        $this->assign('classList',$classList);
        return $this->fetch();
    }

    /**
     * 个人信息修改提交
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
            session('user',$post);//将信息更新到session
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }

    /**
     * 照片提交
     */
    public function photoPost(){
        //获取上传的照片
        $file = request()->file('photo');
        //获取当前用户信息
        $user = getUser();
        //将文件保存到指定目录下
        $info = $file->move(ROOT_PATH . 'public/upload/photo');
        if ($info) {
            //获取保存的图片文件名
            $fileName = '/upload/photo/'.$info->getSaveName();
            $fileName = str_replace('\\','/',$fileName);
            $this->success('照片上传成功','',$fileName);
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }
    }
}