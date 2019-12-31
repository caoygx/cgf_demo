<?php
namespace Admin\Controller;
use Common\Cgf\Cgf;
use Common\Entity\UserSubsidy;

class SitemapController extends BaseController {
    protected $defaultSort = "desc";
    function _initialize()
    {
        parent::_initialize();
        $this->m = M('GoodsActivity');
    }


	//排序字段
	//protected $sortBy = "update_time";



    function _before_index(){
        $_REQUEST['listRows'] = 50;
        $this->_replacePublic([]);
    }


	 
	//列表特殊搜索查询条件处理
	function _filter(&$map){

        if($map['act_goods_name']) $map['act_goods_name'] =  array('like',"%{$map['act_goods_name']}%");

        $memberno = I('memberno');
		if($memberno){
		    //将会员号转为openid
            //$r = M('user')->field("openid")->getByMemberno($memberno)->getField("openid");

            //$openid = M('user')->where(["memberno"=>$memberno])->getField("openid");

            //getFieldByName
            $openid = M('user')->getFieldByMemberno($memberno,"openid");
            $map['openid'] =  $openid;
        }

        $create_t = I('create_t');
		if($create_t){
            $timeRange = explode(' - ',$create_t);
            $map['create_t'] =  ['between',$timeRange];
        }

        $ch = I('ch');
		if($ch){
            //将渠道转为openid
            //$r = M('user')->field("openid")->getByMemberno($memberno)->getField("openid");

            $openids = M('user')->where(["ch"=>$ch])->getField("openid",true);

            $map['openid'] =  ["in",$openids];
        }
	}
	
	
	//处理列表结果
	function _join(&$voList){
	    
	}
	

	//公共模板替换，一般用于添加和编辑
    function _replacePublic($vo){



    }

	//添加前置操作
	function _before_add(){
		$this->isMobile = isMobile();
	}

	//编辑前置操作
	function _before_edit(){
		$this->isMobile = isMobile();
	}
	
	//编辑后置操作
	function _after_edit($data,$option){
		
	}

	//保存前置操作
	function _before_save(){
		//C('DEFAULT_FILTER',"");
		//$_POST['update_time'] = time();
	}

    function realExportExcel($list){

        header('Content-type: text/html; charset=utf-8');
        vendor('PHPExcel.Classes.PHPExcel');
        $xlsName  = "用户数据表";

        $xlsCell =[
            "prize_goods_name"=>"奖品名称",
            "prize_price"=>"采购价格",
            "draw_state_text"=>"抽奖状态",
            "prize_state_text"=>"中奖状态",
            "trans_state_text"=>"发奖状态",
            "trans_kuaidi_num"=>"物流信息",
            //"??"=>"卡密",
            "create_t"=>"中奖时间",
            "cname"=>"收货人",
            "phone"=>"收货电话",
            "address"=>"收货地址",
        ];


        //var_dump($xlsData);exit;
        foreach ($list as $k => $v)
        {
            //$xlsData[$k]['status'] = 1 ? '正常':'锁定';
            //$xlsData[$k]['addtime'] = date("Y-m-d H:i:s", $v['addtime']);
        }
        exportExcel($xlsName,$xlsCell,$list);
    }

    function _before_exportExcel(){
        $this->_before_index();
    }

	function exportExcel(){
	    $this->index();
    }


    function auctionOrder($xlsName='', $xlsCell=array(), $xlsModel=''){//导出Excel
        $xlsName  = "User用户数据表";

        $xlsCell =[
            "state"=>"订单状态",
            "auc_count"=>"拍卖次数  ",
            "??"=>"参加次数",
            "prize_price"=>"单价",
            "purchase_price"=>"采购价",
            "??"=>"配送信息",
            "create_t"=>"创建时间",
            "trans_kuaidi_num"=>"物流信息",
            "??"=>"卡密",
            "??"=>"收货人",
            "??"=>"手机",
            "??"=>"地址",
        ];


        $xlsModel = M('prize_draw_log');

        $xlsData  = $xlsModel->select();
        foreach ($xlsData as $k => $v)
        {
            $xlsData[$k]['status'] = 1 ? '正常':'锁定';
            $xlsData[$k]['addtime'] = date("Y-m-d H:i:s", $v['addtime']);
        }
        exportExcel($xlsName,$xlsCell,$xlsData);

    }

    function getBidUserDetailList($bidUserList,$goods_activity_id){


        $userList = [];
        $mUser = M('user');
        $mUserSubsidy = M('userSubsidy');
        $mGoodsActivity = M('goodsActivity');
        $rGoodsActivity= $mGoodsActivity->field('name')->where(['id'=>$goods_activity_id])->find();
        foreach ($bidUserList as $k=>$bidInfo){
            /*$temp = [];
            $temp['openid'] = $bidInfo['openid'];
            $temp['昵称'] = $bidInfo['name'];
            $temp['会员号'] = $bidInfo['memberno'];
            $temp['创建时间'] = datetime($bidInfo['create_t']);
            $temp['更新时间'] = datetime($bidInfo['modify_t']);
            $temp['总次数'] = $bidInfo['total_times'];
            $temp['剩余'] = $bidInfo['current_times'];

            //用户roi充值信息
            $rUser = $mUser->where(['openid'=>$temp['openid']])->find();
            $temp['roi'] = $rUser['roi'];
            $temp['全额'] = $rUser['balance'];
            $temp['充值'] = $rUser['balance'];



            //补贴信息
            $r = $mUserSubsidy->where(['openid'=>$bidInfo['openid'],'goods_activity_id'=>$goods_activity_id])->find();
            if($r){
                $temp['补贴额'] = $r['real_subsidy'];
                $temp['商品价格'] = $r['price'];
                $temp['参与次数'] = $r['num'];
                //$temp['real_subsidy'] = $r
            }*/

            $temp = [];
            $temp['id'] = $goods_activity_id;
            $temp['openid'] = $bidInfo['openid'];
            //$temp['name'] = $bidInfo['name'];
            $temp['memberno'] = $bidInfo['memberno'];
            $temp['create_t'] = datetime($bidInfo['create_t']);
            $temp['modify_t'] = datetime($bidInfo['modify_t']);
            $temp['total_times'] = $bidInfo['total_times'];
            $temp['current_times'] = $bidInfo['current_times'];

            //用户roi充值信息
            $rUser = $mUser->where(['openid'=>$temp['openid']])->find();
            $temp['roi'] = round($rUser['roi'],2);
            $temp['balance'] = $rUser['balance'];
            $temp['recharge_amount'] = $rUser['recharge_amount'];
            $temp['name'] = $bidInfo['name'].'-'.$rUser['cname']."-".$rUser['alipay_name'];


            /*$eUserSubsidy = new UserSubsidy();
            $eUserSubsidy->openid;*/
            //补贴信息
            $r = $mUserSubsidy->where(['openid'=>$bidInfo['openid'],'goods_activity_id'=>$goods_activity_id])->find();
            if($r){
                $temp['real_subsidy'] = $r['real_subsidy'];
                $temp['price'] = $r['price'];
                $temp['num'] = $r['num'];
                //$temp['real_subsidy'] = $r
            }

            $temp['goods_name'] = $rGoodsActivity['name'];


            $userList[] = $temp;
        }
        return $userList;
    }

    function running(){
        $goodsId = I('goods_id');
        $redis = \Think\Cache\Driver\Redis::getInstance('redis');




        if(empty($goodsId)){
            $bidUserDetailList = [];
            $r = $this->m->where(["state"=>1])->select();
            $st = gettimeofday(1);
            foreach ($r as $k => $v) {
                //$r = $redis->get("auction:current_user_{$v['id']}");
                $r = $redis->get("auction:{$v['id']}:bid_user");
                if($r){

                    $oneGoodsList = $this->getBidUserDetailList($r,$v['id']);
                    if(!empty($oneGoodsList)){
                        $bidUserDetailList = array_merge($bidUserDetailList,$oneGoodsList);
                    }
                    //$bidUserDetailList = $this->getBidUserDetailList($r,$v['id']);

                    //$table .= arrayToTable($bidUserDetailList,$v['id']);
                }

            }
            $et = gettimeofday(1);
            //echo $et-$st;
            //var_dump($bidUserDetailList);exit('x');
            $this->list = $bidUserDetailList;
            $this->toview();
            return ;
        }


    }

    function running_old(){
        $goodsId = I('goods_id');
        $redis = \Think\Cache\Driver\Redis::getInstance('redis');

        $table='';

        if(empty($goodsId)){
            $r = $this->m->where(["state"=>1])->select();
            foreach ($r as $k => $v) {
                $r = $redis->get("auction:current_user_{$v['id']}");
                $table .= arrayToTable($r,$v['id']);
            }
            $this->table = $table;
            $this->toview();
            return ;
        }


        $prefixKeys = [
            //'auction_activity_goods_',
            'bid_user_prefix_',
            'user_bid_prefix_',
            'user_bid_list_prefix_',
            'user_bid_total_prefix_',
            'user_bid_times_prefix_',
            'goods_lock_prefix_',
            'real_user_lock_prefix_',
            'current_user_',
        ];




        $arr1 = array (
            'id' => 1658336,
            'goods_id' => 488,
            'issue_id' => '2018112599565098',
            'state' => 1,
            'bid_price' => '339.89',
            'name' => 'Apple iPhone XS Max (A2104) 256GB  移动联通电信4G手机 双卡双待',
            'memo' => NULL,
            'init_price' => 0,
            'price' => 10999,
            'sort' => 1,
            'countdown' => 10,
            'openid' => NULL,
            'win_name' => NULL,
            'win_t' => NULL,
            'user_type' => 1,
            'win_no' => NULL,
            'win_num' => 0,
            'win_cost' => 0,
            'robot_id' => 492,
            'init_param' => '121.7',
            'ration' => 1,
            'create_t' => 1543142492,
            'modify_t' => 1543142492,
            'now_openid' => 'qq_090b60307f40f171d2e52358',
            'now_name' => '134****9999',
            'now_t' => 1543377086,
            'now_user_type' => '1',
            'now_price' => '339.89',
            'start_time' => 1543142492,
            'net_price' => 0,
            'robot_auction_times' => 23464,
            'realuser_auction_times' => 10525,
            'pre_issue_id' => 0,
            'step_price' => 0.01,
            'pur_price' => 10999,
            'pre_sur_profit' => 456.20999999999998,
            'current_sur_profit' => 0,
            'robot_logout' => 0,
            'auction_per_price' => 1,
            'if_push' => 0,
            'if_notwin_push' => 0,
            'disabled_channel' => 'Ios1:115,Ios3:115',
            'spool_profit' => 456.20999999999998,
            'remain_profit' => 0,
            'goods_name' => 'Apple iPhone XS Max (A2104) 256GB  移动联通电信4G手机 双卡双待',
            'is_change_spool_profit' => 1,
        );



        $arr2 = array (
            0 =>
                array (
                    'openid' => 'qq_090b60307f40f171d2e52358',
                    'name' => '134****9999',
                    'area' => '山东省 烟台市',
                    'ch' => 'iosqy',
                    'bid_num' => '3000',
                    'if_not_win_goods' => '0',
                    'total_times' => '3001',
                    'current_times' => 2365,
                    'u_type' => 'real',
                    'is_winner' => 0,
                ),
            1 =>
                array (
                    'openid' => 'r_default_123456789',
                    'name' => '李浩',
                    'u_type' => 'robot',
                    'area' => '江苏省 扬州市',
                    'robot_type' => 'L',
                    'bid_turn' => '1',
                    'is_winner' => 0,
                ),
            2 =>
                array (
                    'openid' => 'wx_866064edd60f11477dc84135',
                    'name' => '大衣衣服',
                    'area' => '北京 北京',
                    'ch' => 'Ios2',
                    'bid_num' => '6688',
                    'if_not_win_goods' => '0',
                    'total_times' => '10888',
                    'current_times' => 2582,
                    'u_type' => 'real',
                    'is_winner' => 0,
                ),
        );

        $arr3 = array (
            0 =>
                array (
                    'openid' => 'qq_090b60307f40f171d2e52358',
                    'name' => '134****9999',
                    'area' => '山东省 烟台市',
                    'ch' => 'iosqy',
                    'bid_num' => '3000',
                    'if_not_win_goods' => '0',
                    'total_times' => '3001',
                    'current_times' => 2366,
                    'u_type' => 'real',
                    'is_winner' => 0,
                ),
            1 =>
                array (
                    'openid' => 'wx_866064edd60f11477dc84135',
                    'name' => '大衣衣服',
                    'area' => '北京 北京',
                    'ch' => 'Ios2',
                    'bid_num' => '6688',
                    'if_not_win_goods' => '0',
                    'total_times' => '10888',
                    'current_times' => 2582,
                    'u_type' => 'real',
                    'is_winner' => 0,
                ),
        );

        /*        if(count($arr1) == count($arr1, 1)){//1维数组转2维数组
                    $newArr =[];
                    $newArr[] = $arr1;
                    $arr1 = $newArr;
                }
                $table .= arrayToTable($arr1,$goodsId);
                echo $table;exit;*/

        $table='';
        foreach ($prefixKeys as $k=>$v){
            $r = $redis->get("auction:{$v}{$goodsId}");
            //$r = $redis->get('auction:robot_user1432201');
            if(!empty($r) ){
                if(is_array($r)){
                    if(count($r) == count($r, 1)){//1维数组转2维数组
                        $newArr =[];
                        $newArr[] = $r;
                        $r = $newArr;
                    }
                    $table .= arrayToTable($r,$v.$goodsId);
                }else{
                    var_dump($r);
                }
            }

        }
        $this->table = $table;
        $this->toview();
        //var_dump($redis);
    }




}


