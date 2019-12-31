<?php

namespace Common\Controller;
use Common\CommonController;
use Common\TableInfo;


trait Video
{

    public function _filter(&$map){
        $title = I('get.title');
        if($title){
            $map['title'] = array('like',"%$title%");
        }

        $course_id = I('course_id');
        if($course_id){
            $r = M('CourseVideo')->field('video_id')->where(['course_id'=>$course_id])->select();
            if($r){
                unset($map['course_id']);
                $ids = array_column($r,'video_id');
                $map['id'] = ['in',$ids];
            }
        }

    }



    function _before_index()
    {
        $_REQUEST['_order'] = 'sort';
        $_REQUEST['_sort'] = 'asc';
    }

    function add()
    {
        //A('User/upload');
        $vod = new \Common\Aliyunvod();
        $this->uploadAuth = (array)$vod->create_upload_video();
        $this->toview();
    }

    function edit() {

        $id = $_REQUEST [$this->m->getPk ()];
        $where=[];
        $where['id'] = $id;
        if(MODULE_NAME == 'User') $where['user_id'] = $this->user_id;
        $vo = $this->m->where($where)->find();
        if (method_exists ( $this, '_replacePublic' )) {
            $this->_replacePublic ( $vo );
        }
        //cookie( '_currentUrl_', __SELF__ );
        $this->vo = $vo;
        $this -> assign('action','edit');

        //自动获取添加模板
        layout(false);
        $tableInfo = new TableInfo('edit');
        $tableInfo->data = $vo;
        $tableName = $this->m->getTableName();
        $form = $tableInfo->generateForm($tableName);
        $this->form = $form;

        layout(true);
        $this->pageTitle = $this->getControllerTitle(CONTROLLER_NAME)."编辑";
        $this->toview("","Public/add");
        //$this->display();
    }
    function _after_edit(){
        //echo 'edit';exit('sbbb');
    }

    protected function _after_foreverdelete($list){

        //删除关联表
        $mCV = M('CourseVideo');
        $ids = array_column($list,'id');
        $mCV->where(['video_id'=>['in',$ids]])->delete($ids);


        //删除云视频，危险操作，后台不开启
        /*$vod = new \Common\Aliyunvod();
        foreach ($list as $k => $v){
            $r = $vod->delete($v['video_id']);
        }*/

    }

    function select(){

        $where = [];
        $where['user_id'] = $this->user_id;
        $where['status'] = 1;
        $kw = I('kw');
        if(!empty($kw)) {
            $where['title'] = array('like', "%$kw%");
        }
        $list = $this->m->field('id,title')->where($where)->select();
        $this->list = $list;

        $course_id = I('course_id');
        $this->course = M('Course')->field('title')->find($course_id);

        $this->toview();
    }

    /**
     * 视频搜索自动完成
     */
    function soVideo(){
        $where = [];
        $where['status'] = 1;
        $kw = I('kw');
        if(!empty($kw)) {
            $where['title'] = array('like', "%$kw%");
        }
        $list = $this->m->where($where)->limit(10)->getField('title',true);
        echo json_encode($list,JSON_UNESCAPED_UNICODE);
        exit;
    }



    function handlerSelect(){
        $course_id = I('course_id');
        $ids = I('selectedVideo');
        $dataList = [];
        foreach ($ids as $k => $v){
            $dataList[] = array('course_id'=>$course_id,'video_id'=>$v);
        }
        //var_dump($dataList);exit;
        $r = M('CourseVideo')->addAll($dataList);
        if($r !== false){
            $this->success('成功');
        }else{
            $this->error('失败');
        }
    }


    //链接外部视频
    function link(){
        if(IS_GET){
            $this->toview();
        }else{
            $source_url = I('source_url','','trim');
            $source_url = str_replace(["\r\n","\r"],["\n","\n"],$source_url);
            $urls = explode("\n",$source_url);
            $urls = array_filter($urls,"trim");
            $thirdparty = new \Common\ThirdpartyVideo();
            foreach ($urls as $k => $v) {
                $v = $thirdparty->getVideoInfo(trim($v));
                var_dump($v);
            }
            exit;
        }
    }

    function show(){
        $id = I2('id');
        $m = M('video');
        $r = $m->find($id);
        if(empty($r)) $this->error('视频不存在');

        // if($r['upload_status'] == 0) $this->error('视频还在上传处理中');
        //if($r['upload_status'] == 1) $this->error('视频还在转码中');

        $course_id = $r['course_id'];
        $rCourse = M('Course')->find($course_id);
        /** @var UserCourseModel $mUC */
        $mUC = D('UserCourse');
        $this->getAuth();
        $userCourse = $mUC->getUserCourse($this->user_id);
        //$remain_days = $mUC->getRemainDays($course_id);


        $this->vo = $r;
        $this->pageTitle = $r['title'];

        $vod = new \Common\Aliyunvod();
        $vod_auth = $vod->get_video_playauth($r['video_id']);
        if($vod_auth === false) $this->error('视频还在转码处理中,请稍后再试');
        $this->vod_auth = $vod_auth;

        $this->toview();

    }


    function refresh_upload_video() {
        $video_id = I('video_id');
        $response = $this->m->refresh_upload_video($video_id);
        $this->toview($response);
    }


}



