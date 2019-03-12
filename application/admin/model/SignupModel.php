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
            'begin_time' => $data['begin_time'],
            'end_time' => $data['begin_time'],
            'create_time' => time()
        ]);
        if ($result) {
            return ['code' => 1, 'msg' => '添加成功'];
        } else {
            return ['code' => 0, 'msg' => '添加失败'];
        }
    }
}