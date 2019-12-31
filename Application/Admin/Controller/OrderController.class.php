<?php
namespace Admin\Controller;
use Common\Cgf\Cgf;
use Common\Cgf\Definition;

class OrderController extends BaseController
{
    function __construct($pre = '', $modelName = '')
    {
        parent::__construct($pre, $modelName);
        $this->m = D('OrderView');
    }

    //private $tableName = "pm_order"; //正式的通过函数获取


    function _before_index(){
        C('URL_MODEL',0); //解决时间搜索中 空格被转成+号，导致下一页内容无法显示
        //var_dump(urlencode(' - '));exit;
        if(empty($_REQUEST['listRows'])) $_REQUEST['listRows']= 5;
        if(empty($_REQUEST['_order'])) $_REQUEST['_order']= '`o`.`modify_t`';
        if(empty($_REQUEST['_sort'])) $_REQUEST['_sort']= 'desc';
        $this->_replacePublic([]);
    }

    /*function index()
    {
        $join = [];
        $join = [' LEFT JOIN __USER__ u ON a.openid = u.openid','LEFT JOIN __GOODS_ACTIVITY__ ga ON ga.id = a.act_goods_id'];
        $option['join'] = $join;

        $fields = 'a.*,u.memberno,u.ch,u.address,u.tel,u.mobile,u.cname,ga.goods_id,ga.`name`,ga.realuser_auction_times,ga.win_cost,ga.now_price';

        $tableName = $this->m->getTableName();
        //$_REQUEST ['_order']="`{$tableName}`.id";
        $_REQUEST ['_order']="`a`.id";
        $this->indexLink($option);



    }*/

    protected function _search($name = '') {
        //生成查询条件
        if (empty ( $name )) {
            $name = CONTROLLER_NAME;
        }
        //var_dump($_REQUEST);
        //var_dump($this->m->getDbFields ());

        $map = array ();
        foreach ( $this->m->getDbFields () as $key => $val ) {
            if (isset ( $_REQUEST [$val] ) && $_REQUEST [$val] !== '') {
                $map [$val] = trim($_REQUEST [$val]);
            }
        }


        //var_dump($map);
        /*$dbFields = ['user_type','act_goods_id','goods_name','create_t','ch','status','memberno','openid','status_flag']; //&goods_name=&create_t=&ch=&status=2&memberno=&openid=
        $map = array ();
        foreach ($dbFields as $key => $val ) {
            if (isset ( $_REQUEST [$val] ) && $_REQUEST [$val] !== '') {
                $map [$val] = trim($_REQUEST [$val]);
            }
        }*/

        //$map['a.user_type'] = I('user_type');
        return $map;

    }

    //列表特殊搜索查询条件处理
    function _filter(&$map){

        $mobile = I('mobile');
        if(isset($_REQUEST['mobile'])){
            if($mobile==''){

            }elseif($mobile == 0){
                //$map['mobile'] = 'is null';
                $map['_string'] = 'mobile is null ';
                unset($map['mobile']);
            }elseif ($mobile == 1){
                $map['_string'] = 'mobile is not null ';
                unset($map['mobile']);
            }
        }

        /*$create_t = I('create_t');
        if($create_t){
            $timeRange = explode(' - ',$create_t);
            $timestamps = array_map(function($datatime){
                return strtotime($datatime);
            },$timeRange);
            $map['create_t'] =  ['between',$timestamps];
        }else{
            $time = strtotime("-30 days");
            $map['create_t'] = ['gt',$time];
        }*/

        $date = I('date');
        if($date == 1){
            $dateStart = strtotime(date("Y-m-d", time()));
            $map = [];
            $map['_string'] = " o.status = '2' AND o.user_type = '1' AND u.status_flag = '1' AND o.create_t >= $dateStart  AND (o.openid not LIKE 'yk_%' OR (o.openid LIKE 'yk_%' AND u.mobile is NOT NULL))";
            //$date = date("Y-m-d", strtotime('-1 days'));
            //$map['_string'] = "o.create_t > $date ";
        }elseif ($date == 2){
            $dateStart = strtotime(date("Y-m-d", strtotime('-1 days')));
            $dateEnd = strtotime(date("Y-m-d", time()));
            $map = [];
            $map['_string'] = " o.status = '2' AND o.user_type = '1' AND u.status_flag = '1' AND o.create_t >= $dateStart AND o.create_t <= $dateEnd AND (o.openid not LIKE 'yk_%' OR (o.openid LIKE 'yk_%' AND u.mobile is NOT NULL))";
        }

        if($map['goods_name']) $map['goods_name'] =  array('like',"%{$map['goods_name']}%");

    }


    //处理列表结果
    //getFieldsOfHasRelateTable
    function _join(&$voList){

        foreach($voList as $k => &$v){
            //$v['phone'] = !empty($v['phone']) ? $v['phone'] : $v['mobile'];
            $v['create_t'] = date('Y-m-d H:i:s',$v['create_t']);
            $v['pur_t'] = date('Y-m-d H:i:s',$v['pur_t']);
        }

        //将导出功能注入到此处
        if(ACTION_NAME == 'exportExcel'){
            $this->realExportExcel($voList);
        }
    }


    //公共模板替换，一般用于添加和编辑
    function _replacePublic($vo){
        //状态select html控件替换
        /*$this->opt_trans_state = $this->definition->list['trans_state']['options'];

        $this->trans_state_selected = I('trans_state');

        $this->opt_prize_state = $this->definition->list['prize_state']['options'];
        //var_dump(Cgf::$definition['prize_draw_log']['list']['prize_state']);exit;
        $this->prize_state_selected = I('prize_state');*/

    }


    function _before_exportExcel(){
        $this->_before_index();
    }

    function exportExcel(){
        $this->index();
    }

    function realExportExcel($list){

        header('Content-type: text/html; charset=utf-8');
        vendor('PHPExcel.Classes.PHPExcel');
        $xlsName  = "用户数据表";

        $xlsCell =[
            "order_id"=>"订单号",
            "goods_name"=>"商品名",
            "price"=>"价格",
            "company"=>"快递",
            "express_no"=>"快递单号",
            "create_t"=>"时间",
            "realname"=>"收货人",
            "mobile"=>"收货电话",
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



    function updateExpress(){
        $id = I('id');
        if(!$id)    $this->error('id不能为空');

        //$order_id = $this->m->where(['id'=>$id])->getField('order_id');
        $rOrder = $this->m->find($id);
        if(empty($rOrder))  $this->error('订单不存在');;
        $order_id = $rOrder['order_id'];

        $mExpress = M('express');
        $rExpress = $mExpress->getByOrder_no($order_id);
        $_POST['modify_t'] = time();
        $_POST['pur_t'] = time();
        //$_POST['pur_t'] = strtotime($_POST['pur_t']);
        if(empty($rExpress)){
            //insert
            $_POST['order_no'] = $order_id;
            $_POST['activity_id'] = $rOrder['act_goods_id'];
            $_POST['create_t'] = time();
            if($mExpress->create() !== false){
                $id = $mExpress->add();
                if(empty($id)) $this->error('save failed');

                $openid = $rOrder['openid'];
                $rUser = M('User')->getByOpenid($openid);

                //send sms
                $mobile = '';
                if(!empty($rUser['tel'])){
                    $mobile = $rUser['tel'];
                }elseif(!empty($rUser['phone'])){
                    $mobile = $rUser['phone'];
                }elseif(!empty($rUser['mobile'])){
                    $mobile = $rUser['mobile'];
                }else{

                }
                if(!empty($mobile)){
                    $msg = [];
                    $msg['phone'] = $mobile;
                    $extra['goods']=$rOrder['goods_name'];
                    $extra['express_no']=$_POST['express_no'];
                    $msg['extra']=json_encode($extra);
                    $r = $this->send($msg);
                }

            }
        }else{
            //update
            $_POST['id'] = $rExpress['id'];
            if($mExpress->create() !== false){
                $id = $mExpress->save();
            }
        }



        $this->success();




    }


    public function send($memberdata){
        //curl_get_content
        $bass = new \Common\Bassmsg();
        $data['msm_type']='boshitong';
        $data['appid']='paimai';
        $data['send_type']='send';
        $data['tmp']='deliverGoods';
        $data['mobile']=$memberdata['phone'];
        if(!empty($memberdata['extra'])){
            $data['extra']=$memberdata['extra'];
        }
        $data['ip']=get_client_ip();
        $data['sign']=$bass->createSign($data);
        return 	$bass->curl($data,$bass->sendmsg,'1');
        /*if($data['tmp']=="Winning"){
            return 	$bass->curl($data,$bass->sendmsg,'1');
        }else{
            return 	$bass->curl($data,$bass->sendUrl,'1');
        }*/
    }




}