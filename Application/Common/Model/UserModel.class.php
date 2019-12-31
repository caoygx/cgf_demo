<?php
namespace Common\Model;
class UserModel extends CommonModel {
	public $_auto		=	array(
		//array('create_time','time',self::MODEL_INSERT,'function'),

	    array('salt','autoSalt',1,'callback'),
	    array('ip','get_client_ip',1,'function'),
	);
    protected $_validate2 = array(
        array('username','require','用户名必须填写！',self::MUST_VALIDATE),
        array('username','','帐号名称已经存在！',1,'unique',1), // 在新增的时候验证name字段是否唯一
        array('username','/^[\x{4e00}-\x{9fa5}A-Za-z0-9_\-@\.]{1,16}$/u','帐号名称格式不正确！',1,'regex',1), // 验证账号格式，中文+字母+@.-
        array('require','require','密码必须填写！',self::MUST_VALIDATE),
        array('password',"1,20",'密码格式不正确',self::EXISTS_VALIDATE,'length'), // 自定义函数验证密码格式
        array('repassword','password','确认密码不正确',self::EXISTS_VALIDATE,'confirm'), // 验证确认密码是否和密码一致
    );

    function _initialize()
    {
        if(I('password')){
            $this->_auto[] = array('password','pwd',3,'callback');
        }
    }

    function usernameAdd($data = ''){
        $this->_validate = array(
            array('username','require','用户名必须填写！',self::MUST_VALIDATE),
            array('username','','帐号名称已经存在！',1,'unique',1), // 在新增的时候验证name字段是否唯一
            array('username','/^[\x{4e00}-\x{9fa5}A-Za-z0-9_\-@\.]{1,16}$/u','帐号名称格式不正确！',1,'regex',1), // 验证账号格式，中文+字母+@.-
            array('password','require','密码必须填写！',self::MUST_VALIDATE),
            array('password',"1,20",'密码格式不正确',self::MUST_VALIDATE,'length'), // 自定义函数验证密码格式
            array('repassword','password','确认密码不正确',self::EXISTS_VALIDATE,'confirm'), // 验证确认密码是否和密码一致
        );
        if(false === $this->create($data))  return false;
        return $this->add();

    }

    function emailAdd($data = ''){
        $this->_validate = array(
            array('email','require','邮箱必须填写！',self::MUST_VALIDATE),
            array('email','','邮箱已经存在！',1,'unique',1),
            array('email','email','邮箱格式不正确！',1,'regex',1),
            array('password','require','密码必须填写！',self::MUST_VALIDATE),
            array('password',"1,20",'密码格式不正确',self::MUST_VALIDATE,'length'), // 自定义函数验证密码格式
            array('repassword','password','确认密码不正确',self::EXISTS_VALIDATE,'confirm'), // 验证确认密码是否和密码一致
        );
        if(false === $this->create($data))  return false;
        return $this->add();

    }

    function mobileAdd($data = ''){
        $this->_validate = array(
            array('mobile','require','手机必须填写！',self::MUST_VALIDATE),
            array('mobile','','手机已经存在！',1,'unique',1),
            array('mobile','mobile','手机格式不正确！',1,'regex',1),
        );
        if(false === $this->create($data))  return false;
        return $this->add();

    }

	function msave($data = ''){
	    //$this->_auto[] = array('password','pwd',3,'callback'); //是编辑用户其它字段也更新密码，还是只更新密码字段才触发生成密码？
		if(false === $this->create($data))  return false;
		if(I($this->getPk())){
            return $this->save();
        }else{
	        return $this->add();
        }
	}

	//自动 完成密码加密
	protected function pwd($password){
	    //debug($password);
	    $pwd = password_hash($password, PASSWORD_DEFAULT);
        //debug(password_verify($password, $pwd));
        //debug($pwd);//exit;
        return $pwd;
	}
	
	//自动生成salt
	protected function autoSalt(){
	     return substr(uniqid(mt_rand()), 0, 4);
	}
	
	//第三方注册，已注册则返回userid
	function oauthAdd($open_id, $type, $userInfo){
		$where = [];
		$field = $type.'_open_id';
		$where[$field] = $open_id;
		$r = $this->where ($where)->find();
		if(!empty($r)) return false;

		$data = $userInfo;
		$data [$field] = $open_id;

		//$data ['nickname'] = $userInfo ['nickname'];
		//$data ['avatar'] = $userInfo ['figureurl_2'];
		$data ['ip'] = get_client_ip ();
		$data['lastlogin_ip'] = get_client_ip ();
		return $this->add ( $data );
		//session ( 'id', $this->getLastInsID () );
		//$u['user_id'] = $this->getLastInsID();

	}


    /**
     * 微信unionid用户注册
     * @param $wxUserInfo
     * @param $additionalInformation other fields of user
     * @return bool|mixed
     */
	function oauthAddByWxUnionid($wxUserInfo,$additionalInformation=[]){
        $userInfo = $this->wxUserInfoToUser($wxUserInfo);
        $wxUnionid = $userInfo['wx_union_id'];
        $where = [];
        $field = 'wx_union_id';
        $where[$field] = $wxUnionid;
        $r = $this->where ($where)->find();
        if(!empty($r)) return false;

        $userInfo ['ip'] = get_client_ip ();
        $userInfo['lastlogin_ip'] = get_client_ip ();
        $userInfo = array_merge($userInfo,$additionalInformation);

        return $this->add ( $userInfo );

    }

    /**
     * 微信用户格式转用户表数组
     * @param $wxUserInfo
     * @return array 用户表字段
     */
	function wxUserInfoToUser($wxUserInfo){

        $userInfo = [];
        $userInfo['wx_union_id'] = $wxUserInfo['unionid'];
        $userInfo['gzh_open_id'] = $wxUserInfo['openid'];
        $userInfo['province'] = $wxUserInfo['province'];
        $userInfo['city'] = $wxUserInfo['city'];
        $userInfo['avatar'] = $wxUserInfo['headimgurl'];
        $userInfo['sex'] = $wxUserInfo['sex'];
        $userInfo['nickname'] = $wxUserInfo['nickname'];
        $sex_map=[0=>2,1=>1,2=>0];
        $userInfo['sex'] = $sex_map[$wxUserInfo['sex']];

        $extra = [];
        $extra['subscribe'] = $wxUserInfo['subscribe'];
        $extra['groupid'] = $wxUserInfo['groupid'];
        $extra['tagid_list'] = $wxUserInfo['tagid_list'];
        $extra['subscribe_time'] = $wxUserInfo['subscribe_time'];
        $userInfo['extra'] = json_encode($extra,JSON_UNESCAPED_UNICODE);
        return $userInfo;
    }


    /**
     * 小程序用户添加 to add user for wxapp 
     * @param $wxUserInfo
     * @return array 用户表字段
     */
    function wxappUserAdd($wxUserInfo,$additionalInformation){

        $userInfo = [];
        $userInfo['wx_union_id'] = $wxUserInfo['unionId'];
        $userInfo['wxapp_open_id'] = $wxUserInfo['openId'];
        $userInfo['province'] = $wxUserInfo['province'];
        $userInfo['city'] = $wxUserInfo['city'];
        $userInfo['avatar'] = $wxUserInfo['avatarUrl'];
        $userInfo['nickname'] = $wxUserInfo['nickName'];
        $sex_map=[0=>2,1=>1,2=>0];
        $userInfo['sex'] = $sex_map[$wxUserInfo['gender']];

        $wxUnionid = $userInfo['wx_union_id'];
        $where = [];
        $field = 'wx_union_id';
        $where[$field] = $wxUnionid;
        $r = $this->where ($where)->find();
        if(!empty($r)) return false;

        $userInfo ['ip'] = get_client_ip ();
        $userInfo['lastlogin_ip'] = get_client_ip ();
        $userInfo = array_merge($userInfo,$additionalInformation);

        return $this->add ( $userInfo );

    }

    //第三方注册，已注册则返回userid
    function oauthUnionidAdd( $type, $userInfo){
	    if(empty($userInfo['unionid'])){
	        $this->error = 'unionid 不能为空';
	        return false;
        }
        $where = [];
        $field = $type.'_union_id';
        $where[$field] = $userInfo['unionid'];
        $r = $this->where ($where)->find();
        if(!empty($r)) return false;

        $data = $userInfo;
        $data [$field] = $userInfo['unionid'];


        //$data ['nickname'] = $userInfo ['nickname'];
        //$data ['avatar'] = $userInfo ['figureurl_2'];
        $data ['ip'] = get_client_ip ();
        $data['lastlogin_ip'] = get_client_ip ();
        return $this->add ( $data );
        //session ( 'id', $this->getLastInsID () );
        //$u['user_id'] = $this->getLastInsID();

    }

	
	function existOpenId($open_id){
		$r = $this->getByOpen_id($open_id);
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
     * 10年前代码
     * @param unknown_type $r
     */
 /*   protected function standardizeData(&$r){
        foreach($r as $k => $v){
            if(empty($v['nickname'])){
                $r[$k]['nickname'] = $v['uname'];
            }
        }
    }*/

    /**
     * 标准化数据
     * @param unknown_type $r
     */
    function standardizeData(&$r){
        //substr_replace($tel, '****', 3, 4);
        if(!empty($r['nickname'])){
            $r['nickname'] =  $r['nickname'];
        }elseif ( !empty($r['username'])){
            $r['nickname'] =  $r['username'];
        }elseif( !empty($r['mobile'])){
            $r['nickname'] = substr_replace($r['mobile'], '******', 2, 6);
        }else{
            $r['nickname'] = '用户';
        }
        $r['avatar'] = img($r['avatar']);
        //$r['nickname'] = $r['nickname'] ?? $r['username'];
    }

    function getList($where = [],$num=5){
        $r = $this->whereWidthFilterField($where)->order("update_time desc")->limit($num)->select();
        foreach ($r as $k => &$v){
            $this->standardizeData($v);
        }
        return $r;
    }



	
	/**
	 * 列表
	 * @param unknown_type $uid
	 */
	public function getListOption(){
		//echo C('DB_PREFIX');
		//$t = M('topic');
		$result = array();
		$r = $this->limit(3)->select();
		$result['list'] = $r;
		$ids = array();
		foreach($r as $k => $v){
			$ids[] = $v['id'];
		}
		//$ids = implode(',', $ids);
		
		$o = M('Option');
		$map['topic_id'] = array('in', $ids);
		$r = $o->where($map)->select();
		//$options = array();
		
		foreach($r as $k => $v){
			$result['child'][$v['topic_id']][] = $v;
		}
		
		//echo $o->getLastSql();
		//var_dump($result);
		return $result;
	}
	
 
	
	function getSpouse($id){
		//$sql = "select * from familytree where spouse = '$id'";
		//var_dump($id);exit;
		$r = $this->where("spouse = '$id'")->find();
		//var_dump($r);
		//echo $this->getLastSql();
		//$r = $this->query($sql);
		return $r;
	}
	
	function getChild($id){
		//$sql = "select * from familytree where fid = '$id'";
		$r = $this->where("fid = '$id'")->select();
		//echo $this->getLastSql();
		//$r = $this->query($sql);
		return $r;
	}
	
	function getTree($id = 1){
		
		$this->level++;
		$sql = "select * from familytree where id='$id'"; //自己信息
		$self = $this->find($id);
		//var_dump($self);exit;
		
		//$id = $r['id'];
		//与妻子节点合并
		$spouse = $this->getSpouse($id);
		//var_dump($spouse);
		
		$node = array();
		$node['id'] = $self['id'];
		$node['name'] = $self['name'].'_'.$spouse['name'];
		$node['spouseID'] = $spouse['id'];
		$node['click'] = "show({$self['id']})";
		//$node['id'] = $id;
		//var_dump($node);
		
		//输出节点
		/*echo str_repeat('——',$this->level);
		$url = U("familytree/addChild",array('fid'=>$self['id'], 'mid' => $spouse['id']));
		echo '<a href="'.$url.'">'.$self['name'],'|',$spouse['name'].'</a>','<br />';*/
		
		//exit;
		$childs = $this->getChild($id);
		
		if(is_array($childs) && !empty($childs))
		foreach($childs as $k => $v){
			$node['children'][] = $this->getTree($v['id']);
			//return $this->getTree($v['id']);
		}
		$this->level--;
		return $node;
		
	/*id:3, name:"右键操作 3", open:true,
				children:[*/	
	}
	
	//登录成功后处理
	function loginSuccess($u){
        !empty($u['id']) && $u['user_id'] = $u['id'];
	    setUserAuth($u);
	    
	    //记录登录信息
	    $ip		=	get_client_ip();
	    $time	=	time();
	    $data = array();
	    $data['id']	=	$u['id'];
	    $data['lastlogin_time']	=	$time;
	    $data['lastlogin_ip']	=	$ip;
	    $data['login_count']	=	array('exp','login_count+1');
	    $this->save($data);
	}

	//通过用户名获取用户信息
    public function getByUsername($username){
	    if(empty($username)){
	        return false;
        }
        $map['username'] = $username;
	    return $this -> where($map) -> find();
    }


}

