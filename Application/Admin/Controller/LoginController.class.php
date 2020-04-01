<?php

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{

    //用户的登陆
    public function login()
    {
       $admin = M('admin');
        //dump($_POST);
        if (I('sub')) {
            $map = I('');
            unset($map['sub']);
            $map['status'] = 1;
            $map['pwd'] = md5(I('pwd'));
            $u = $admin->where($map)->find();
            if ($u) {
                $u['user_id'] = $u['id'];
                setUserAuth($u);
                $Auth = new \Think\Auth();
                $authList = $Auth->getAuthList($u['id'], 1);

                $redirectUrl = "index/index";
                if(!in_array($redirectUrl,$authList)){ //如果没有首页权限，取有权限的页面中第一个作为跳转页
                    $redirectUrl = current($authList); //if it have not authorization to access the index page,take the first page of have authorization
                    $rAuthRule = M('authRule')->where(['name'=>$redirectUrl])->find();
                    $redirectUrl = $rAuthRule['name']; //获取跳转url,由于原权限名被转成小写，导致无法跳转。
                }
                $redirectUrl = '/admin/'.$redirectUrl;
                //var_dump($redirectUrl);exit;
                $this->redirect($redirectUrl);

            } else {
                $this->error("用户名或密码不正确");
            }
        }
        $this->display();

    }

    //退出登录
    public function loginOut()
    {
        clearUserAuth();
        $this->redirect('Login/login');
    }

}