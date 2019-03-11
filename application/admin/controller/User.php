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

            $conditions['name|mobile|username'] = ['like', "%$keyword%"];
        }
        $rows = Db::name('user u')
            ->field(['u.*',"FROM_UNIXTIME(u.create_time,'%Y-%m-%d %H:%i:%s') create_time",
                "IF(u.last_login_time>0, FROM_UNIXTIME(u.last_login_time,'%Y-%m-%d %H:%i:%s'), '无') last_login_time"
            ])
            ->where($conditions)
            ->where(['u.type'=>1,'u.delete_time'=>0])
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
        return $this->fetch();
    }
    public function add(){
        $classList = Db::name('class')->where('delete_time',0)->select();
        $this->assign('classList',$classList);
        return $this->fetch();
    }
}