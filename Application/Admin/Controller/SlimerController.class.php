<?php
namespace Admin\Controller;

use Common\CommonController;

class SlimerController extends BaseController
{
    function index()
    {
        //scandir('./slimer_image');
        $dir = './slimer_image/'.date('ymd');
        $this->list = glob($dir.'/*.png');
        //var_dump($this->list);exit('x');
        $this->toview();
      /*  var_dump($list);
        foreach ($list as $k => $v) {


        }*/

    }


}