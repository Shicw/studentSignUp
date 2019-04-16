<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/16
 * Time: 13:04
 */
namespace app\admin\model;

use think\Model;
class NewsModel extends Model
{
    protected $table = 'news';
    /**
     * 删除公告
     * @param $id
     * @return array
     */
    public function doDelete($id){
        $result = $this->where(['id'=>$id])->update(['delete_time'=>time()]);
        if($result){
            return ['code'=>1,'msg'=>'公告删除成功'];
        }else{
            return ['code'=>0,'msg'=>'公告删除失败'];
        }
    }

    /**
     * 发布公告
     * @param $data
     * @return array
     */
    public function doAdd($data){
        $result = $this->insert([
            'title' => $data['title'],
            'content' => $data['content'],
            'read_count' => 0,
            'create_time' => time(),
            'delete_time' =>0,
        ]);
        if($result){
            return ['code'=>1,'msg'=>'公告发布成功'];
        }else{
            return ['code'=>0,'msg'=>'公告发布失败'];
        }

    }
    /**
     * 发布公告
     * @param $data
     * @return array
     */
    public function doEdit($data){
        $found = $this->where(['delete_time'=>0,'id'=>$data['id']])->find();
        if(!$found){
            return ['code'=>0,'msg'=>'该公告不存在'];
        }
        $result = $this->where(['id'=>$data['id']])->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
        if($result){
            return ['code'=>1,'msg'=>'公告编辑成功'];
        }else{
            return ['code'=>0,'msg'=>'没有新的修改信息'];
        }

    }
}