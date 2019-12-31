<?php

namespace Admin\Controller;
//use Think\Controller;
class IndexController extends BaseController
{

    //登录显示管理员图像 名字
    public function index()
    {

        $this->display();
    }

    // 导入 Excel
    public function excel() {

        header('Content-type: text/html; charset=utf-8');

        vendor('PHPExcel.Classes.PHPExcel');

$this->expUser();
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

    function drawOrder($xlsName='', $xlsCell=array(), $xlsModel=''){//导出Excel
        $xlsName  = "User用户数据表";

        $xlsCell =[
            "prize_goods_name"=>"奖品名称",
            "prize_price"=>"采购价格",
            "draw_state"=>"抽奖状态",
            "prize_price"=>"中奖状态",
            "trans_state"=>"发奖状态",
            "trans_kuaidi_num"=>"物流信息",
            "??"=>"卡密",
            "create_t"=>"中奖时间",
            "??"=>"收货人",
            "??"=>"收货电话",
            "??"=>"收货地址",
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

    function editor(){

        $parentDir = dirname(ROOT);
        $filepath = $parentDir."/auction/auction_front/view/app/activity/"; //线上
        //$filepath = $parentDir."/auction_front/view/app/activity/";
        $filename = "activity.html";
        if(!empty(I('filename'))) $filename = I('filename');


        if(IS_POST){
            $content = I('content');
            $filename = I('filename');
            $ext = pathinfo($filename,PATHINFO_EXTENSION );
            if($ext != 'html') exit;
            $path = $filepath."/".$filename;
            file_put_contents($path,$content);
            $this->success();
        }else{
            $path = $filepath."/".$filename;
            $content = file_get_contents($path);
            $this->assign('content',$content);
            $this->assign('filename',$filename);
            //$this->aa="aaaaaa";
            $this->display();
        }
    }

}