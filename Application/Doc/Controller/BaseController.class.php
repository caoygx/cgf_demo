<?php
namespace Doc\Controller;
use Common\CgfController;
class BaseController extends CgfController{
    function _initialize(){
        parent::_initialize();
       /* if($_SERVER['PHP_AUTH_USER']==C('PHP_AUTH_USER') && $_SERVER['PHP_AUTH_PW']==C('PHP_AUTH_PW')){
            //echo('验证通过');
        }else{
            header('WWW-Authenticate: Basic realm="please login"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Unauthorized.';
            exit;
        }*/
    }

}