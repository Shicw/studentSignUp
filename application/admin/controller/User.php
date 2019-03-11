<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 15:43
 */
namespace app\admin\controller;

use app\admin\model\UserModel;
use app\AdminBaseController;
use think\Controller;
use think\Db;

class User extends AdminBaseController
{
    /**
     * 用户列表
     * @return mixed
     */
    public function index(){
        //关键字查询
        $request = input('request.');
        $keyword = '';
        $conditions = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $conditions['u.id|mobile|u.name|m.name|c.name'] = ['like', "%$keyword%"];
        }
        $rows = Db::name('user u')
            ->field(['u.id','u.name','u.username','u.sex','u.type','u.mobile','m.name major','c.name class',
                "IF(u.last_login_time>0, FROM_UNIXTIME(u.last_login_time,'%Y-%m-%d %H:%i:%s'), '无') last_login_time",
                "FROM_UNIXTIME(u.create_time,'%Y-%m-%d %H:%i:%s') create_time"
            ])
            ->join([
                ['major m','m.id=u.major_id'],
                ['class c','c.id=u.class_id']
            ])
            ->where($conditions)
            ->where(['u.type'=>['>',0],'u.delete_time'=>0])
            ->order('u.create_time desc')
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
        //获取专业列表
        $majorList = Db::name('major')->field(['id','name'])->where(['delete_time'=>0])->select();
        $this->assign('majorList',$majorList);
        return $this->fetch();
    }
}