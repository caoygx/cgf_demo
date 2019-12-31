<?php
namespace Common\Model;
class CommentModel extends CommonModel {
		
	//protected $pk  = 'id'; //sb nid引起
	//protected $_map = array('id'=>'nid');
	public $_validate	=	array(
		//array('title','require','名不能为空'),
		);

/*	public $_auto		=	array(
                    array('content','remove_xss',self::MODEL_BOTH,'function'),
                    );*/

	function _initialize(){
		parent::_initialize();
		if(C('GROUP_NAME') == 'Admin'){ //后台保存
            //to do
		}else{ //非后台保存
                $this->_auto		=	array(
                    array('content','remove_xss',self::MODEL_BOTH,'function'),
            );
		}	
	}

	 
	
	/**
	 * 得到一条记录
	 * @param unknown_type $id 
	 */
	public function getOne($id){
			if(!is_numeric($id)) return;
			$r = $this->find($id);
			return $r;
	}
 
	
	/**
	 * 标准化数据
	 * @param unknown_type $r
	 */
	function standardizeData(&$r){
	    $r['cover'] = img($r['cover']);
        $r['duration'] = date('i:s',$r['duration']);
	}

	function getLists($where = [],$num=5){
	    $r = $this->where($where)->limit($num)->select();
	    foreach ($r as $k => &$v){
	        $this->standardizeData($v);
        }
        return $r;
    }
	

	
}

