<?php

namespace Admin\Controller;
use Common\TableInfo;
class CommentController extends BaseController
{

    function _before_add(){
        $course_title = M('Course')->where(["id" => I2('course_id')])->getField('title');
        $this->assign('course_title',$course_title);
    }



    function _before_save(){
        //从刷单用户中随机获取用户id
        /*$sql = "
SELECT
	*
FROM
	user AS t1
JOIN (
	SELECT
		ROUND(
			RAND() * (		(	SELECT		MAX(id)		FROM	`user`	) - (SELECT MIN(id) FROM user)	) + (SELECT MIN(id) FROM user)	) AS id
) AS t2
WHERE
	t1.id >= t2.id 
ORDER BY
	t1.id
LIMIT 1
        ";*/

        $reply_id = I('reply_id');
        if($reply_id){ //回复
            $course_id = $this->m->where(['id'=>$reply_id])->getField('course_id');
            //var_dump($course_id);exit;
            $this->setParam('course_id',$course_id);
        }


        //echo strtotime('-3 year');exit;
        $sql = "select max(id) as maxId from comment where id < 70000 limit 1";
        $r = $this->m->query($sql);
        $maxId = $r[0]['maxId'];

        $start_x = $maxId - 69;

        $create_time = $this->generateCommentTime($start_x);
        $this->setParam('create_time',$create_time);
        $this->setParam('id',$maxId+1);
        //var_dump($_POST);
        //exit;


        //普通评论
        $sql = 'select id from user where type=9 order by rand() LIMIT 1';
        //$rand_user_id = M('User')->where('type=9')->order('rand()')->getField('id');
        //echo M('User')->getLastSql();exit;
        //var_dump($r);exit;
        $r = $this->m->query($sql);
        $rand_user_id = $r[0]['id'];
        $this->setUserId($rand_user_id);
        //$_POST['user_id'] = 2;
        //$this->user_id=2;
    }

    function generateCommentTime($x){

        $start_time = 1415692132;
    //for($x = $start_x; $x < 100; $x++){
        $addend =  log($x,1.000005);
        $addend = ceil($addend);
        $current_time = $start_time + $addend;
        /*echo datetime($current_time);
        echo LF;*/
    //}
        return datetime($current_time);
        //return $current_time;

    }


    //保存添加和编辑
    function save() {

        if(haveUploadFile()){
            $uploadInfo = $this->commonUpload();
            if(!empty($uploadInfo)){
                foreach ($uploadInfo as $k => $v){
                    $_POST[$k] = $v['path'];
                }
            }
        }
        //var_dump($this->isAjax());exit;
        //$id = I($this->m->getPk ());
        $id = I('id');
        //$vo = $this->m->getById ( $id );


        //自动验证
        $tableInfo = new TableInfo();
        $tableName = $this->m->getTableName();
        $rules = $tableInfo->getValidateRules($tableName);
        $auto = $tableInfo->getAutoComplete($tableName);
        //var_dump($auto);exit;
        //$data = $this->m->create();

            //unset($_POST['id']);
            $r  = $this->m->validate($rules)->create ();
            /*var_dump($_GET);
            var_dump($_POST);
            var_dump($_REQUEST);
            var_dump($r);eixt;*/
            //$_POST['user_id'] = $this->user_id; //添加时默认加上用户id
            if (false === $this->m->validate($rules)->create ()) {
                $this->error ( $this->m->getError () );
            }
            $r=$this->m->add ();
            $id = $r;


        //保存当前数据对象
        if(method_exists($this,'_after_save') && $id) $this->_after_save($id);

        //echo $this->m->getLastSql();exit;
        if ($id!==false) { //保存成功
            //$this->assign ( 'jumpUrl', cookie( '_currentUrl_' ) );
            if($this->successRedirectUrl){
                $redirectUrl = $this->successRedirectUrl.$id;
            }else{
                $redirectUrl = cookie( '_currentUrl_' );
            }
            $this->success (["id"=>$id],'成功',$redirectUrl);
        } else {
            //失败提示
            $this->error ('失败了!');
        }


    }

    //保存后，根据id更新关联表
    function _after_save($id){
        $ids = I('ids');
        M('File')->where(['id'=>['in',$ids]])->setField('tid',$id);
    }

    function topic(){

        $this->index();
    }

    function _filter(&$map){
        if(ACTION_NAME == 'topic'){
            //获取没有回复的评论
            //SELECT * FROM `comment` WHERE reply_id=0  and id  not in(SELECT reply_id FROM `comment` WHERE reply_id>0)
            //SELECT * FROM `comment` as topic WHERE reply_id=0  and  not EXISTS(  SELECT id FROM `comment` as reply WHERE topic.id=reply.reply_id)
            $map['reply_id'] = 0;
            $map['_string'] = 'id  not in(SELECT reply_id FROM `comment` WHERE reply_id>0)';

            //$map['reply_id'] = 0;
        }

        $content = I('content');
        if($content){
            $map['content'] = array('like',"%$content%");
        }

    }



}