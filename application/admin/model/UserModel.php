<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 15:09
 */
namespace app\admin\model;

use think\Model;
class UserModel extends Model
{
    protected $table = 'user';
    /**
     * 验证用户名密码
     * @param $username
     * @param $password
     * @param $ip
     * @param $type
     * @return array
     */
    public function doLogin($username, $password, $type, $ip){
        $find = $this->where(['username' => $username, 'password' => md5($password)])
            ->find();
        if ($find) {
            $find = $find->toArray();
            session($type, $find);//保存session
            //更新最后登录时间
            $this->where('id', $find['id'])->update(['last_login_time' => time(),'last_login_ip'=>$ip]);
            return ['code' => 1, 'msg' => '登录成功', 'data' => $find];
        } else {
            return ['code' => 0, 'msg' => '用户名或密码错误'];
        }
    }

    /**
     * 修改密码
     * @param $username
     * @param $oldPassword
     * @param $newPassword
     * @return array
     */
    public function changePassword($username, $oldPassword, $newPassword){
        //判断旧密码
        $find = $this->where(['username'=>$username,'password'=>md5($oldPassword)])->find();
        if(!$find){
            return ['code' => 0, 'msg' => '旧密码错误'];
        }
        $update = $this->where('id',$find['id'])->update(['password'=>md5($newPassword)]);
        if ($update) {
            return ['code' => 1, 'msg' => '修改成功'];
        } else {
            return ['code' => 0, 'msg' => '修改失败'];
        }
    }

    /**
     * 获取用户信息
     * @param $id
     * @return array
     */
    public function getDetail($id){
        $result = $this->where('id',$id)->find()->getData();
        return $result;
    }
    /**
     * 添加用户
     * @param $data
     * @return array
     */
    public function doAdd($data){
        $result = $this->insert([
            'username' => $data['username'],
            'password' => md5('123456'),//初始密码
            'name' => $data['name'],
            'sex' => 2,
            'type' => 1,
            'create_time' => time()
        ]);
        if ($result) {
            return ['code' => 1, 'msg' => '添加成功'];
        } else {
            return ['code' => 0, 'msg' => '添加失败'];
        }
    }
    /**
     * 删除用户
     * @param $id
     * @return array
     */
    public function doDelete($id){
        $find = $this->field(['id'])->where(['id'=>$id,'delete_time'=>0])->find();
        if(!$find){
            return ['code' => 0, 'msg' => '该用户不存在,可能已被删除'];
        }
        $result = $this->where('id',$id)->update(['delete_time'=>time()]);
        if ($result) {
            return ['code' => 1, 'msg' => '删除成功'];
        } else {
            return ['code' => 0, 'msg' => '删除失败'];
        }
    }
    /**
     * 修改用户
     * @param $post
     * @return array
     */
    public function doEdit($post){
        $find = $this->field(['id'])->where(['id'=>$post['id'],'delete_time'=>0])->find();
        if(!$find){
            return ['code' => 0, 'msg' => '该用户不存在,可能已被删除'];
        }
        $result = $this->where('id',$post['id'])->update($post);
        if ($result) {
            return ['code' => 1, 'msg' => '修改成功'];
        } else {
            return ['code' => 0, 'msg' => '没有新的修改信息'];
        }
    }
    /**
     * 注册用户
     * @param $data
     * @return array
     */
    public function doRegister($data){
        $result = $this->insert([
            'username' => $data['username'],
            'password' => md5($data['password']),
            'sex' => 2,
            'type' => 1,
            'create_time' => time()
        ]);
        if ($result) {
            return ['code' => 1, 'msg' => '注册成功'];
        } else {
            return ['code' => 0, 'msg' => '注册失败'];
        }
    }
}