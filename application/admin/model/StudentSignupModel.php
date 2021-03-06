<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/12
 * Time: 14:17
 */
namespace app\admin\model;

use think\Exception;
use think\Model;
class StudentSignupModel extends Model
{
    /**
     * 执行报名操作
     * @param $userId
     * @param $itemId
     * @return array
     */
    public function doSignup($userId,$itemId){
        //判断用户是否完善信息
        $idcard = $this->name('user')->where('id',$userId)->value('id_card');
        if($idcard==''){
            return ['code' => 0, 'msg' => '请先完善您的个人信息'];
        }
        //判断是否已报名该项目
        $isExist = $this->name('student_signup_log')
            ->where(['items_id'=>$itemId, 'user_id'=>$userId, 'delete_time'=>0])
            ->find();
        if($isExist){
            return ['code' => 0, 'msg' => '您已报名该项目'];
        }
        //判断该项目已报名人数是否满了
        $found = $this->name('signup_items')->where(['id'=>$itemId,'delete_time'=>0])->find();
        if(!$found){
            return ['code' => 0, 'msg' => '无该报名项,请刷新'];
        }
        if($found['max_student_count']>0&&($found['real_student_count']===$found['max_student_count'])){
            return ['code' => 0, 'msg' => '该项目人数已满'];
        }
        //开启事务处理
        $this->startTrans();
        try{
            $result = $this->name('student_signup_log')->insert([
                'items_id'=>$itemId,
                'user_id'=>$userId,
                'create_time'=>time()
            ]);
            if (!$result) {
                throw new Exception("报名失败,请重试");
            }
            $result = $this->name('signup_items')->where('id',$itemId)->setInc('real_student_count',1);
            if (!$result) {
                throw new Exception("报名失败,请重试");
            }
            $this->commit();// 提交事务
        }catch(Exception $e){
            $this->rollback();// 回滚事务
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
        return ['code' => 1, 'msg' =>'报名成功'];
    }

    /**
     * admin执行报名移除操作
     * @param $id
     * @return array
     */
    public function doQuit($id){
        //先判断该报名记录是否存在
        $found = $this->name('student_signup_log')->where(['id' => $id, 'delete_time' => 0])->find();
        if (!$found) {
            return ['code' => 0, 'msg' => '无该报名记录,请刷新'];
        }
        //开启事务处理
        $this->startTrans();
        try {
            //删除报名记录
            $result = $this->name('student_signup_log')->where(['id' => $id])->update(['delete_time'=>time()]);
            if (!$result) {
                throw new Exception("移除失败,请重试");
            }
            //实际报名人数-1
            $result = $this->name('signup_items')->where('id',$found['items_id'])->setDec('real_student_count',1);
            if (!$result) {
                throw new Exception("移除失败,请重试");
            }
            $this->commit();// 提交事务
        } catch (Exception $e) {
            $this->rollback();// 回滚事务
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
        return ['code' => 1, 'msg' => '移除成功'];
    }

}