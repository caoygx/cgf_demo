<?php
if(PHP_SAPI == 'cli'){

    define('LF',"\n");
    $scheme = 'http://';

}else{

    define('LF',"<br />");


    //跨域
    //header('Access-Control-Allow-Origin:http://www.rrbrr.com');
    $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
    $allow_origin = array(
        'http://www.tpl.com',
    );

    if(in_array($origin, $allow_origin)){
        header('Access-Control-Allow-Origin:'.$origin);
        header('Access-Control-Allow-Credentials:true');

//    header('Access-Control-Allow-Methods:POST');
        //  header('Access-Control-Allow-Headers:x-requested-with,content-type');
    }


    //获取根域名
    /*$http_host = $_SERVER['HTTP_HOST'];
    if(filter_var($http_host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false){
        $domain = $http_host;
    }else{
        $arr = explode('.',$http_host);
        $c = count($arr);
        $domain = $arr[$c-2].'.'.$arr[$c-1];
    }
    define('DOMAIN', $domain);*/
    $scheme = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
}


define('SCHEME',$scheme);


define('ROOT',dirname(__DIR__));
define('DOMAIN', 'rrbrr.com');

define('URL_WWW', $scheme.'www.' . DOMAIN);
define('URL_M', $scheme.'m.'.DOMAIN);
define('URL_USER',$scheme. 'u.'.DOMAIN); //强制https，如果不强制，在http协议的播放页退出，则又会使用http的退出功能
define('URL_LOCAL',$scheme. 'local.'.DOMAIN);

define('URL_API',$scheme.'api.'.DOMAIN);
define('OSS', $scheme.'rrbrr.oss-cn-shanghai.aliyuncs.com/');
define('ASSETS_DIR',  __DIR__ . '/Public/assets');

//define('TMPL_PATH','../Template/');

if(file_exists(__DIR__."/pro.txt")){
    define('APP_DEBUG',true);
    define("CONF_ENV","pro");
    //require ROOT.'/ThinkPHP/vendor/autoload.php';
}elseif(file_exists(__DIR__."/test.txt")){
    //define('APP_DEBUG',true);
    define("CONF_ENV","test");
    //require ROOT.'/ThinkPHP/vendor/autoload.php';
}else{
    define('APP_DEBUG',true);
    define("CONF_ENV","dev");
    //require ROOT.'/ThinkPHP/vendor/autoload.php';
}

//由于app_debug开启后，所有配置文件里的配置将被缓存到一个文件中，导致配置文件中的定义不在被执行，所以单独再加载一个定义文件
require CONF_ENV."_define.php";

//header("Access-Control-Allow-Origin: *");


define('APP_PATH',ROOT.'/Application/');
define('RUNTIME_PATH',ROOT.'/Runtime/'); //runtime目录


require ROOT.'/ThinkPHP/ThinkPHP.php';

 
