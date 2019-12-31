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
/**
 * 系统行为扩展：页面Trace显示输出
 */
class RenderBehavior extends \Think\Behavior{

    // 行为扩展的执行入口必须是run
    public function run(&$params){
        if(C('save_response')){
            $logId = C('logId');
            $data = [];
            $data['id'] = $logId;
            $data['response'] = $params;
            //$m = M('LogRequest','',C('log_db'));
            //$m->save($data);
            //var_dump($params);exit;
        }

    }

    
}
