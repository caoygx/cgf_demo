<?php
namespace Admin\Controller;
use Common\Cgf\Cgf;
use Common\Cgf\Definition;

class GoodsController extends BaseController
{
    function __construct($pre = '', $modelName = '')
    {
        parent::__construct($pre, $modelName);
    }



    function _before_index(){
        C('URL_MODEL',0); //解决时间搜索中 空格被转成+号，导致下一页内容无法显示
        //var_dump(urlencode(' - '));exit;
        if(empty($_REQUEST['listRows'])) $_REQUEST['listRows']= 100;
        $this->_replacePublic([]);
    }


    //列表特殊搜索查询条件处理
    function _filter(&$map){

        if($map['name']){
            $map['name'] = ['like',"%{$map['name']}%"];
        }
    }


    //处理列表结果
    //getFieldsOfHasRelateTable
    function _join(&$voList){

        foreach($voList as $k => &$v){
            $v['create_t'] = date('Y-m-d H:i:s',$v['create_t']);
            $v['modify_t'] = date('Y-m-d H:i:s',$v['modify_t']);
        }

        //将导出功能注入到此处
        if(ACTION_NAME == 'exportExcel'){
            //$this->realExportExcel($voList);
        }
    }


    //公共模板替换，一般用于添加和编辑
    function _replacePublic($vo){

    }








}