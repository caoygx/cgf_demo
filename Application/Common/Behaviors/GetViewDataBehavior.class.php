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
class GetViewDataBehavior extends \Think\Behavior{

    public function run(&$controller){}
    // 行为扩展的执行入口必须是run
    public function run2($object, $class){


        $action = strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);

        $arrCacheUrl = C('cache_url');
        array_walk($arrCacheUrl,function(&$v){$v = strtolower($v);});

        if(!in_array($action,$arrCacheUrl)){
            return false;
        }

        //$method = new \ReflectionMethod($module, $action);
        //$method->invoke($module);

        //$class = new \ReflectionClass($module);



        $url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $keyUrl= "viewData_".$url;
        $viewData = S($keyUrl);
        if(!empty($viewData)) {
            C('fromCache',true);
            //var_dump($viewData);exit('x');
            //$method = new \ReflectionMethod($module, $action);

            $passign = $class->getMethod('passign' );
            $passign->invokeArgs($object,[$viewData]);

            $toview = $class->getMethod( 'toview');
            $toview->invoke($object);

            return true;
        }

    }

    
}
