<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/12
 * Time: 10:59
 */
namespace app\admin\model;

use think\Model;
class SignupModel extends Model
{
    protected $table = 'signup_items';

    /**
     * 添加报名项目
     * @param $data
     * @return array
     */
    public function doAdd($data){
        $result = $this->insert([
            'name' => $data['name'],
            'description' => $data['description'],
            'max_student_count' => $data['max_student_count'],
            'real_student_count' => 0,
            'begin_time' => strtotime($data['begin_time']),
            'end_time' =>strtotime($data['end_time']),
            'create_time' => time()
        ]);
        if ($result) {
            return ['code' => 1, 'msg' => '添加成功'];
        } else {
            return ['code' => 0, 'msg' => '添加失败'];
        }
    }
    /**
     * 获取信息
     * @param $id
     * @return array
     */
    public function getDetail($id){
        $result = $this->where('id',$id)->find()->getData();
        return $result;
    }
    /**
     * 删除
     * @param $id
     * @return array
     */
    public function doDelete($id){
        $find = $this->field(['id'])->where(['id'=>$id,'delete_time'=>0])->find();
        if(!$find){
            return ['code' => 0, 'msg' => '该记录不存在,可能已被删除'];
        }
        $result = $this->where('id',$id)->update(['delete_time'=>time()]);
        if ($result) {
            return ['code' => 1, 'msg' => '删除成功'];
        } else {
            return ['code' => 0, 'msg' => '删除失败'];
        }
    }
    /**
     * 修改
     * @param $post
     * @return array
     */
    public function doEdit($post){
        $find = $this->field(['id'])->where(['id'=>$post['id'],'delete_time'=>0])->find();
        if(!$find){
            return ['code' => 0, 'msg' => '该记录不存在,可能已被删除'];
        }
        $result = $this->where('id',$post['id'])->update($post);
        if ($result) {
            return ['code' => 1, 'msg' => '修改成功'];
        } else {
            return ['code' => 0, 'msg' => '没有新的修改信息'];
        }
    }
}