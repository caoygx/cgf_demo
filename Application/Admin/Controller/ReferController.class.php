<?php

namespace Admin\Controller;

class ReferController extends BaseController
{
    protected $defaultOrder = "";

    protected $defaultSort = "";

    protected $dbConnection = [];
    function _initialize()
    {
        $this->dbConnection = C('log_db');
        $this->m = M('Refer','',C('log_db'));
        parent::_initialize();

    }

    public function _filter(&$map){
        if($map['request_time']){
            $times = explode(' - ',$map['request_time']);
            $map['request_time']  = array('between',$times);
        }
    }

    //use \Common\Controller\Video;




}



