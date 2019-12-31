<?php
namespace Test\Controller;

use T\UnitTest;

class BaseController extends UnitTest {
    function index(){
        //通过自动遍历测试类的方式执行测试
        $this->run(true);
    }
}