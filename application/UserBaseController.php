<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 15:02
 */
namespace app;
use think\Db;
use think\Controller;
class UserBaseController extends Controller
{
    public function _initialize(){
        $this->checkUserLogin();
    }
    //判断用户是否登录
    public function checkUserLogin()
    {
        $userId = getUserId();
        if (empty($userId)) {
            $this->redirect('User/Login/index');
        }
    }
}