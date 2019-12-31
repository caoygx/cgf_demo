<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2013 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Common\Behaviors;
class SetViewDataBehavior extends \Think\Behavior{

    public function run(&$controller){

        //如果是从缓存里取的数据，则不用再缓存了

        if( C('fromCache')){
            return false;
        }
        //不在缓存名单，直接return
        $action = strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);
        $arrCacheUrl = C('cache_url');
        array_walk($arrCacheUrl,function(&$v){$v = strtolower($v);});
        if(!in_array($action,$arrCacheUrl)){
            return false;
        }

        //缓存viewData
        $url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $keyUrl= "viewData_".$url;

        $viewData = $controller->get();
        S($keyUrl,$viewData);

    }

    
}
