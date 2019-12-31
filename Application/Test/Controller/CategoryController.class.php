<?php
namespace Test\Controller;

class CategoryController extends BaseController {

    function testGetAll(){
        $mCategory = D('Category');
        $r = $mCategory->getAll(0,true);
        $this->assertGreater(1,count($r));
        $this->assertArrayHasKey('children',$r[0]);


        $r = $mCategory->getAll(0,false);
        $this->assertNotArrayHasKey('children',$r[0]);

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