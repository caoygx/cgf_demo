<?php

namespace Admin\Controller;

class LogRequestController extends BaseController
{
    protected $dbConnection = [];
    function _initialize()
    {
        parent::_initialize();
        //$this->dbConnection = C('log_db');
        $this->m = M('LogRequest');
    }


    //use \Common\Controller\Video;

    //排序字段
    //protected $sortBy = "update_time";



    function _before_index(){
        C('URL_MODEL',0); //解决时间搜索中 空格被转成+号，导致下一页内容无法显示
        //var_dump(urlencode(' - '));exit;
        if(empty($_REQUEST['listRows'])) $_REQUEST['listRows']= 50;

        empty($_REQUEST ['_order']) && $_REQUEST ['_order'] = 'id';
        empty($_REQUEST ['_sort']) && $_REQUEST ['_sort'] = 'asc';

        //$this->_replacePublic([]);
    }

    function index2()
    {
        $d = new \Common\Cgf\SqlToCgfDefinition('pm_log_request');
        $r = $d->generateCgfDefinitionFile();
        var_dump($r);
        exit;
    }

    function getSearchRefer(){
        $mRefer = M('Refer','',C('log_db'));
        $count = $this->m->count();
        $pageSize = 100;
        $reg = "/Referer: ([\S]+)/i";
        $total = ceil($count/$pageSize);

        for ($page = 0; $page<$total; $page++) {
            $r = $this->m->where(['rinse_status'=>0])->page($page, $pageSize)->select();
            foreach ($r as $k=>$v){
                //echo $v['id'],LF;
                //设为已清洗
                $this->m->where(['id'=>$v['id']])->setField('rinse_status',1);

                //给相同ip的访问数+1
                $mRefer->where(['ip'=>$v['ip']])->setInc('view_count');
                //echo $mRefer->getLastSql();echo LF;




                $detail = $v['detail'];

                preg_match($reg,$detail,$out);
                if(!empty($out[1])){
                    $data = [];
                    //$data['refer_url'] = str_replace(["\r\n","\r","\n"],["","",""],$out[1]);
                    $refer_url = $out[1];
                    if(strpos($refer_url,DOMAIN) !== false){

                    }else{
                        $url = parse_url($refer_url);
                        //var_dump($url);
                        $host = $url['host'];
                        if(empty($host)){
                            continue; //不是正规url格式的跳过
                        }
                        $data['refer_url'] = $refer_url;
                        $data['ip'] = $v['ip'];
                        $data['source'] = $host;
                        $data['request_id'] = $v['id'];
                        $data['request_time'] = $v['create_time'];
                        $mRefer->add($data);



                    }

                }
            }
        }

    }

    /**
     * 判断访问ip是否已注册用户
     */
    function isRegister(){
        $mRefer = M('Refer','',C('log_db'));
        $r = $mRefer->where(['status'=>0])->select();
        foreach ($r as $k => $v) {
            $dataUpdate=['id'=>$v['id'],'status'=>1];
            $user_id = $this->getUserIdByIp($v['ip']);
            if(!empty($user_id)){
                $dataUpdate['user_id']=$user_id;
            }
            $mRefer->save($dataUpdate);
        }
    }

    function getUserIdByIp($ip){
        //取此ip注册的第一个用户id
        $user_id = $this->m->where("user_id>0 and ip='$ip'")->getField('user_id');
        return $user_id;
    }



}



