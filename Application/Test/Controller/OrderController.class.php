<?php
namespace Test\Controller;

class OrderController extends BaseController {

    function testSendGoods(){

        /** @var \User\Controller\OrderController $contrl */
        //$contrl = A('User/Order');
        $contrl = new \User\Controller\OrderController('','Order');

        $payInfo = [];
        $payInfo['order_no'] = '1709190000000197';
        $payInfo['pay_order_id'] = 'test001';
        $payInfo['paymethod'] = 'test001';
        $payInfo['callback_data'] = 'test001';


        //有跳转
        //$r = $contrl->sendGoods($payInfo);
        //var_dump($r);exit;

       /* $mCategory = D('Category');
        $r = $mCategory->getAll(0,true);
        $this->assertGreater(1,count($r));
        $this->assertArrayHasKey('children',$r[0]);


        $r = $mCategory->getAll(0,false);
        $this->assertNotArrayHasKey('children',$r[0]);*/

       /* $r = $mCategory->getAll(7);
        var_dump($r);exit;*/

        /*
        $autotest = A('Doc/Autotest');
        $params = [];
        $params['user_id'] = 1;
        $params['course_id'] = "function|getNotBuyCourseId";

        $this->assertNotEmpty( $autotest->getNotBuyCourseId($params) );

        $t = new \Common\TableInfo();

        $this->assertTrue($t->testTrue());

        */
    }


}