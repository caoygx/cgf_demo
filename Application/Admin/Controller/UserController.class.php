<?php

nameSpace Admin\Controller;

class UserController extends BaseController
{
    /**
     * @var string 默认排序字段
     */
    protected $defaultOrder = "id";

    function _before_save()
    {
        if(!I('birthday')){
            unset($_POST['birthday']);
        }

    }

    //新用户设置密码
    function setPassword(){
        if(IS_GET){
            $this->cookie_prefix=C('COOKIE_PREFIX');
            $this->toview();
        }else {

            $user_id = I2('id');
            $password = I2('password');
            $password = password_hash($password, PASSWORD_DEFAULT);
            $this->m->where(['id'=>$user_id])->setField('password',$password);
            $this->success('成功');
        }
    }

}
