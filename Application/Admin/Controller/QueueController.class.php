<?php

namespace Admin\Controller;

class QueueController extends BaseController
{

    public function index()
    {
        /*
           $cOrder = A('User/Order');
        $cOrder->query();
          */
        $r = $this->m->select();
        foreach ($r as $k => $v) {
            $message = json_decode($v['message'],true);
            extract($message);
            if(empty($module)) $module = "User";
            //var_dump($parameter);
            //var_dump("{$module}/{$controller}/{$action}");
            $r = R("{$module}/{$controller}/{$action}",$parameter);
            if($r){
                $this->m->delete($v['id']);
            }
            //var_dump($r);
        }
    }
}


