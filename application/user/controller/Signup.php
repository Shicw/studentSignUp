<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/12
 * Time: 11:40
 */
namespace app\user\controller;
use app\admin\model\StudentSignupModel;
use app\UserBaseController;
use think\Db;

class Signup extends UserBaseController
{
    /**
     * 查看报名项目列表
     */
    public function index(){
        $time = time();
        $rows = Db::name('signup_items')
            ->field(["FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') create_time",
                "FROM_UNIXTIME(begin_time,'%Y-%m-%d %H:%i:%s') begin_time",
                "FROM_UNIXTIME(end_time,'%Y-%m-%d %H:%i:%s') end_time",
                'id','name','description','max_student_count','real_student_count'
            ])
            ->where(['delete_time'=>0,'begin_time'=>['<',$time],'end_time'=>['>',$time]])
            ->order('create_time desc')
            ->paginate(15,false);
        $page = $rows->render();
        $name = getUser()['name'];
        $this->assign([
            'rows' => $rows,
            'page' => $page,
            'name' => $name
        ]);
        return $this->fetch();
    }
    /**
     * 报名提交
     */
    public function signupPost(){
        if(!$this->request->isPost()){
            $this->error('请求失败');
        }
        $itemId = $this->request->post('itemId');
        $userId = getUserId();

        $model = new StudentSignupModel();
        $result = $model->doSignup($userId,$itemId);

        if($result['code']==1){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }
}