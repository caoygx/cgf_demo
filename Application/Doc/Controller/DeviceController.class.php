<?php
namespace Home\Controller;
use Common\CommonController;

class DeviceController extends CommonController {
	protected $nodeId = [];
    protected $autoInstantiateModel = false;
	//protected $pre = "lez_";
	public  function _initialize(){


    }

    function  getDeviceId(){
	    if(I('device_id')){
	        echo json_decode(I('device_id'));
        }
	    $m = M('device',"vpn_","api");
        $id = uniqid();
        $data = [];
        $data['device_id'] = $id;
        $m->add($data);
        $ret = [];
        $ret['device_id'] =$id;
        echo json_encode($ret);
    }





	 

}




