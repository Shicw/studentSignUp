<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 15:00
 */
namespace app;
use think\Db;
use think\Controller;
class AdminBaseController extends Controller
{
    public function _initialize(){
        $this->checkAdminLogin();
    }
    //判断用户是否登录
    public function checkAdminLogin()
    {
        $adminId = getAdminId();
        if (empty($adminId)) {
            $this->redirect('admin/Login/index');
        }
    }
}