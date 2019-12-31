<?php
namespace Test\Controller;

class UserCourseController extends BaseController {


    function testInsert(){
        $id = 209;
        $user_id = 1;
        $rOrderInfo = M('Order')->find($id);
        $projectInfo = json_decode($rOrderInfo['snapshot'], 1);
        $projectInfo['course_id'] = $projectInfo['id'];
        $openStatus =  D('UserCourse')->insert($user_id,$projectInfo);
        $this->assertEquals(1,$openStatus);
        //var_dump($openStatus);
        //exit;

    }

}