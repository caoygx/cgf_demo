<?php
namespace Common\Model;
class CategoryModel extends CommonModel {

	public $_auto		=	array(
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_BOTH,'function'),
		);

	public $_validate	=	array(
		array('title','require','标题不能为空'),
		array('content','require','内容不能为空'),
		);
		
 	//保存数据
	function msave(){
		

		$id = $_REQUEST [$this->getPk ()];
		load('@.dede_string');
		$_POST['content'] = filter_script($_POST['content']);
		$_POST['description'] = cn_substrR(strip_tags($_POST['content']),255);
		if (false === $this->create ()) {
			//return $this->getError ();
			return false;
		}
		//$this->display("index");exit;
		
		if(empty($id)){	
			$r=$this->add();
			
		}else{
			$r=$this->save();
			
		}
		
		return $r;
	}
	

	/**
	 * 得到一条记录
	 * @param unknown_type $id 
	 */
	public function getOne($id){
			if(!is_numeric($id)) return;
			$r = $this->find($id);
			//$u = D('Member');
			//$r['place'] = $u->where("id = {$r['user_id']}")->getField('place');
			//$p = explode('/',$r['location']);
			//dump($p);
			//$r['province'] = $p[0];
			//$r['city'] = $p[1];
			//dump($r);
			return $r;
	}
	
	 
	
	/**
	 * 标准化数据
	 * @param unknown_type $r
	 */
	protected function standardizeData(&$r){
	}

	//获取所有分类，包含子分类
	function getAll($pid=0,$containsChildren=true){
	    $where = [];
	    $where['pid'] = $pid;
	    $where['status'] = 1;
        $data = $this->where($where)->order('sort asc')->limit('0,6') -> select();
        if($containsChildren){
            foreach($data as $k => &$v){
                $r = $this->where(['pid' =>$v['id']])->order('sort asc')->select();
                $v['children'] = $r;
            }
        }
        return $data;
    }



}


