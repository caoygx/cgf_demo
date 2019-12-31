<?php
namespace Common;
use Think\Controller;
use Org\Util\Rbac;
use Org\Util\Cookie;
use Common\XPage;
use Com\Wechat;
use Com\WechatAuth;

class CommonController extends Controller {
	protected $m = null;
	protected $user = array(); //用户信息数组.  合理方法public $user存储返回到页面上的字段， private fullUser存储用户所有属性，用于后端代码访问一些非公开的信息
	protected $user_id; //用户user_id
	protected $u = null;
	protected $autoInstantiateModel = true;
	protected $tempStorageOpenidUser = []; //微信等第三方登录的用户信息临时存储
	protected $isMobile;
	protected $enableLitePage = false; //开启简易分页，用于列表顶部分页组件
    protected $isUserModel=false; //标识$this->m是否属于用户model，默认false，用户中心所有model需要自己指定，或在base里统一设置

    protected $enableLog=true;


    /** @var  Wechat */
    protected $wechat;

    /** @var  WechatAuth */
    protected $auth;

    protected $token;

    protected $openid;

    protected $platform; //android,ios,wxapp,wx,wap,pc,

    /**
     * @var \Common\Cgf\Cgf
     */
    protected $cgf;

	public function __construct($pre = '',$modelName=''){
		parent::__construct();
		if(empty($modelName)) $modelName = CONTROLLER_NAME;
		if($pre){ //有表前缀
			new CommonModel($modelName,$pre);
		}else{
			try{
                //检测表存在，则实例化
				$model = M();
                $tablename = strtolower(C('DB_PREFIX').parse_name($modelName));
				$sqlCheckTable = "SELECT * FROM information_schema.tables WHERE table_name = '$tablename'";
                $tableExist = $model->query($sqlCheckTable);


                //debug($tableExist);
				if($this->autoInstantiateModel){
                    if(!empty($tableExist)){
                        if(existModel($modelName)){
                            $this->m = D($modelName);
                        }

                        //文件model不存在，new默认model
                        if(empty($this->m)){
                            $this->m = M($modelName);
                        }

                        //是用户中心的model，所有查询带上user_id=xx 条件下
                        if($this->isUserModel && !empty($this->user_id)){
                            $this->m->where(['user_id'=>$this->user_id]);
                        }
                    }else{
                        //echo "{$modelName} 表不存在";
                    }

				}
			}catch(Exception $e){
				//echo $e->getMessage();
				//
			}
		}
		
		
		//简单的权限验证操作
		if (method_exists ( $this, '_permissionAuthentication' )) {
			$this->_permissionAuthentication ();
		}

		//if(empty($this->m)) exit(CONTROLLER_NAME.'对象不存在');





	}
	
	
	function _initialize() {
		
		//由于 Think\controller construct 里先调用了_initialize ，
		// 但userBase 验证登录是放在_initialize,导致此类construct 还没执行，就被跳转了
		// 跳转代码获取不到ret_format 导出返回信息仍是html 跳转
		//所以要此代码从construct 移动到此处
        if(IS_AJAX){
            C('ret_format','json');
        }elseif(!empty(I(C('VAR_JSONP_HANDLER')))){
            C('ret_format','jsonp');
        }
		
		if($this->enableLog && !IS_CLI)	$this->requestLog();

		//白名单优先
		if(!empty(C('whitelist'))) {
            //只允许白名单中的controller
            $wl_control = C('whitelist.controller');
            $wl_action = C('whitelist.action');
            $wl_url = C('whitelist.url');
            $wl_url = array_map(
                function($value) {
                    return strtolower($value);
                },
                $wl_url
            );
            $current_url = CONTROLLER_NAME . '/' . ACTION_NAME;
            //var_dump(lcfirst($current_url));
            //var_dump($wl_url);exit;
            if (in_array(lcfirst(CONTROLLER_NAME), $wl_control)
                || in_array(lcfirst(ACTION_NAME), $wl_action)
                || in_array(strtolower($current_url), $wl_url)

            ) {
                //通过白名单
            } else {
                $this->error('control 1 非法访问');
            }
        }

        //黑名单
        if(!empty(C('blacklist'))){
            //禁用访问黑名单中的controller
            $bl_control = C('blacklist.controller');
            $bl_action = C('blacklist.action');
            $bl_url = C('blacklist.url');
            $current_url = CONTROLLER_NAME.'/'.ACTION_NAME;
            if( in_array(lcfirst(CONTROLLER_NAME),$bl_control)
                || in_array(lcfirst(ACTION_NAME),$bl_action)
                || in_array(strtolower($current_url),$bl_url)
            ){
                $this->error('control 2 非法访问');
            }

        }



        $referer = empty($_SERVER['HTTP_REFERER']) ? '/' : $_SERVER['HTTP_REFERER'];
        C('referer',$referer);
        $this->platform = $this->getPlatform();
        //$this->referer = $_SERVER['HTTP_REFERER'];


		/*//url带openid 自动写cookie,session等登录标识
		$open_id = I('open_id');
		if($open_id){
			$r =  M('User')->where(["open_id" => $open_id,"type" => I('type')])->find();
			if(!empty($r)){
				$r['user_id'] = $r['id'];
				$this->tempStorageOpenidUser = $r;
				setUserAuth($r); //登录前在getAuth 里增加个标识，如果get open_id有值，不必取cookie,直接标识为登录
			}
		}
		

		//exit('x');exit;
		//用户信息
		if(!empty($this->user_id)){
		    $m = M('User');
			$r = $m->find($this->user_id);
			//var_dump($r);
			//echo $m->getLastSql();
			//exit;
			if(empty($r['nickname']) && !empty($r['username'])) $r['nickname'] = $r['username'];
			$this->assign ( 'user', $r );
		}

		if(C('USER_AUTH_ON')){
			import ( '@.ORG.Util.RBAC_WEB' );
			$app = 'USER';

		}else{
			import ( 'ORG.Util.RBAC' );
			$app = APP_NAME;
		}*/
	}

	function getPlatform(){
	    $platform = I('server.platform');
	    if(empty($platform)){
	        if(IS_MOBILE){
	            if(is_weixin()){
	                $platform = 'wx';
                }else{
                    $platform = 'wap';
                }
            }else{
	            $platform = 'pc';
            }
        }
        return $platform;
    }

    /**
     * 设置用户id
     * @param $user_id
     */
    protected function setUserId($user_id){
        $_REQUEST['user_id'] = $_POST['user_id']  = $_GET['user_id'] = $user_id;//$this->user_id;
    }


	public function index() {

		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}


		$name=CONTROLLER_NAME;
		//$model = D ($name);
		if (! empty ( $this->m )) {
			$this->_list ( $this->m, $map,$this->sortBy );
		}
		$this->toview ();
		return;
	}


	//有连接表显示列表
	public function indexLink($option=array())
	{
        //列表过滤器，生成查询Map对象
        $map = $this->_search ();
        if (method_exists ( $this, '_filter' )) {
            $this->_filter ( $map );
        }
        $name=CONTROLLER_NAME;
        if (! empty ( $this->m )) {
            if ($option['join']) {
                $this->_listLink($this->m, $map, $option);
            } else {
                $this->_list($this->m, $map);
            }
        }

        if(!IS_AJAX){
            $tplContent = $this->generateListTpl();
        }

        $this->pageTitle = $this->getControllerTitle(CONTROLLER_NAME)."列表";

        $this->cgf="cgf";
        $this->toview();

	}

    public function msg($result,$text = '',$url=''){
		if(false !== $result){
			$this->success($text."成功");
		}else{
			$this->error($text."失败");
		}
	}
	
	//获取用户登录凭证信息
	function getAuth(){
		$u = getUserAuth();
		if(!ONLINE){
			//$u['user_id'] = 4;
		}

		//===============================================临时代码 所有付费用户绑定完后，就要删除 同时要删除get-weixin-code.html里110行的临时代码 ===============================================
		if(is_weixin() && !empty($u)){
            $code = I('code');
            if(!empty($code)) { //是微信用户，且已经用手机登录过了，而且没有绑定过unionid,且unionid没有被其它用户绑定过，则绑定
                $rU = M('User')->find($u['user_id']);
                if(empty($rU['wx_union_id']) || $rU['wx_union_id']==null ){

                    $conf = C('wechat');
                    $this->auth = new WechatAuth($conf['appid'], $conf['appSecret']);
                    if (empty($token)) {
                        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$conf['appid']}&secret={$conf['appSecret']}&code={$code}&grant_type=authorization_code";
                        $accessToken = file_get_contents($url);
                        $accessToken = json_decode($accessToken, 1);

                        //var_dump($accessToken);
                        $token = $accessToken['access_token'];
                        $open_id = $accessToken['openid'];
                        C('openid',$open_id);

                        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$token}&openid=$open_id";
                        //echo $url;
                        $userinfo = file_get_contents($url);
                        $wxUserInfo = json_decode($userinfo, true);
                        if($wxUserInfo['errcode'] == '41001'){
                            tplog("wx_error:".$userinfo['errmsg'],'ERR', '', LOG_PATH.'/wx.log');
                        }

                        if(!empty($wxUserInfo['unionid'])){
                            $rUnionIdUser = M('User')->where(['wx_union_id'=>$wxUserInfo['unionid']])->find();
                            if(empty($rUnionIdUser)){
                                $mUser = D('User');
                                $userInfo = $mUser->wxUserInfoToUser($wxUserInfo);
                                $mUser->where(['id' => $rU['id']])->save($userInfo);
                            }

                        }


                    }
                }




            }
        }

        //===============================================临时代码 所有付费用户绑定完后，就要删除 ===============================================




		if(empty($u)){

            $open_id = I('open_id');
            $type = I('type');


            $code = I('code');

            if(!empty($open_id) && in_array($type,['wx','wb','qq','gzh']) ){ //公众号搜索进入
                $field = $type.'_open_id';
                $where[$field] = $open_id;
                $u['user_id'] = M('User')->where($where)->getField('id');

                //微信公众号用户浏览，第一次要设置cookie,相当于登录操作
                if($type=='gzh'){
                    setUserAuth($u);
                }
            }elseif(!empty($code)){ //公众号链接进入

                $conf = C('wechat');
              /*  $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$conf['appid']}&secret={$conf['appSecret']}&code={$code}&grant_type=authorization_code";
                $r = file_get_contents($url);
                var_dump($r);//exit;*/


                //$this->wechat = new Wechat($conf['token'], $conf['appid'], $conf['crypt']);
                $this->auth = new WechatAuth($conf['appid'], $conf['appSecret']);
                //$token = S('weixin_token');
                if(empty($token)){
                    //$accessToken = $this->auth->getAccessToken('code',$code);

                    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$conf['appid']}&secret={$conf['appSecret']}&code={$code}&grant_type=authorization_code";
                    $accessToken = file_get_contents($url);
                    $accessToken = json_decode($accessToken,1);

                    //var_dump($accessToken);
                    $token =$accessToken['access_token'];
                    $open_id=$accessToken['openid'];

                    C('openid',$open_id);

                    $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$token}&openid=$open_id";
                    //echo $url;
                    $userinfo = file_get_contents($url);
                    $userinfo = json_decode($userinfo,true);

                    //var_dump($userinfo);//exit('x==========');

                    if($userinfo['errcode'] == '41001'){
                        tplog("wx_error:".$userinfo['errmsg'],'ERR', '', LOG_PATH.'/wx.log');
                    }

                    if(!empty($userinfo['unionid'])){
                        $mUser = M('User');
                        $rUser = $mUser->where(['wx_union_id'=>$userinfo['unionid']])->find();

                        if(!empty($rUser)){
                            $u['user_id'] = $rUser['id'];
                            setUserAuth($u);

                        }else{
                            $id = $this->registerLinkGzh($userinfo);
                            $u['user_id'] = M('User')->where(['id'=>$id])->getField('id');

                            //微信公众号用户浏览，第一次要设置cookie,相当于登录操作
                            setUserAuth($u);
//                        var_dump($u);
//                        var_dump($userinfo);exit('============');
                            //var_dump($userinfo);exit('x');

                            //S('weixin_token',$token,$accessToken['expires_in']-120);
                        }
                    }

                }
                /*$this->auth->setAccessToken($token);
                $this->token = $token;
                $this->openid = $open_id;
                exit('x');
                $info = $this->auth->getUserInfo($this->openid);
                var_dump($info);exit('x');
                $this->registerUser();*/



            }

            if(empty($u)){
                return false;
            }

		}

		//要去数据库验证有没有此id
        $tableInfo = new TableInfo('list');
        $selectFields = $tableInfo->createListSelectFields('user');



        $dbUserInfo = M('User')->field($selectFields)->find($u['user_id']);
		if(empty($dbUserInfo)){
            debug('没有此用户');
			//echo '没有此用户';
            return false;

		}

        $dbUserInfo['nickname'] =  !empty($dbUserInfo['nickname']) ? $dbUserInfo['nickname'] : ( !empty($dbUserInfo['username']) ? $dbUserInfo['username'] :  '用户') ;

		$dbUserInfo['avatar'] = img($dbUserInfo['avatar'],'user_avatar');
        $this->user_id = $dbUserInfo['id'];
		$this->user = $dbUserInfo;
		$this->assign('user_id',$this->user_id);
		$this->assign('user',$this->user);
		return $dbUserInfo;
	}

    /**
     * 公众号链接新用户注册,unionid注册
     * @param $info
     */
	function registerLinkGzh($info){
        $userInfo = [];
        $userInfo['unionid'] = $info['unionid'];
        $userInfo['gzh_open_id'] = $info['openid'];
        $userInfo['province'] = $info['province'];
        $userInfo['city'] = $info['city'];
        $userInfo['avatar'] = $info['headimgurl'];
        $userInfo['sex'] = $info['sex'];
        $userInfo['nickname'] = $info['nickname'];
        $sex_map=[0=>2,1=>1,2=>0];
        $userInfo['sex'] = $sex_map[$info['sex']];

        $extra = [];
        $extra['subscribe'] = $info['subscribe'];
        $extra['groupid'] = $info['groupid'];
        $extra['tagid_list'] = $info['tagid_list'];
        $extra['subscribe_time'] = $info['subscribe_time'];

        $userInfo['extra'] = json_encode($extra,JSON_UNESCAPED_UNICODE);
        //wx_open_id
        /** @var \Common\Model\UserModel $mUser */
        $mUser = D('User');
        $r = $mUser->oauthUnionidAdd('wx',$userInfo);
        return $r;
    }

    /**
     * 公众号搜索新用户注册
     */
    function registerUser(){



        /** @var \Common\Model\UserModel $mUser */
        $mUser = D('User');
        $field = 'wx_open_id';
        $r = $mUser->where(['gzh_open_id' => $this->openid ])->find();
        if(empty($r)){
            $info = $this->auth->getUserInfo($this->openid);
            if(empty($info)){
                $message = "token:{$this->token}| open_id: {$this->openid}";
                tplog($message, 'ERR', '', LOG_PATH.'/wx.log');
            }

            $userInfo = [];
            $userInfo['province'] = $info['province'];
            $userInfo['city'] = $info['city'];
            $userInfo['avatar'] = $info['headimgurl'];
            $userInfo['sex'] = $info['sex'];
            $userInfo['nickname'] = $info['nickname'];
            $sex_map=[0=>2,1=>1,2=>0];
            $userInfo['sex'] = $sex_map[$info['sex']];

            $extra = [];
            $extra['subscribe'] = $info['subscribe'];
            $extra['groupid'] = $info['groupid'];
            $extra['tagid_list'] = $info['tagid_list'];
            $extra['subscribe_time'] = $info['subscribe_time'];

            $userInfo['extra'] = json_encode($extra,JSON_UNESCAPED_UNICODE);
            //wx_open_id
            $r = $mUser->oauthAdd($this->openid,'gzh',$userInfo);
        }

    }


    /**
     * 访问日志，记录用户请求的参数
     */
    function requestLog(){


        $data = array();
        $data['url'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(IS_POST){
            $params = $_POST;
        }elseif(IS_GET){
            $params = $_GET;
        }
        if(empty($params)) $params['input'] = file_get_contents("php://input");
        $data['params'] = json_encode($params);
        //$data['cookie'] = json_encode($_COOKIE);
        //$data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['ip'] = get_client_ip();
        $detail = array();
        $detail['request'] = $_REQUEST;

        $header = [];
        $fields = ['HTTP_USER_ID','HTTP_DEVICE_VID','HTTP_DEVICE_ID','HTTP_PLATFORM','HTTP_VERSION']; //'HTTP_USER_AGENT',
        foreach ($fields as $k => $v){
            if(empty($_SERVER[$v])) continue;
            $header[$v] = $_SERVER[$v];
        }
        /*$this->version = I('server.HTTP_VERSION');
        $this->device_id = I('device_id') ?:I('server.HTTP_DEVICE_ID');
        $this->platform = I('server.HTTP_PLATFORM');
        $user_id = I('user_id') ?: I('server.HTTP_USER_ID');
        $detail['server'] = $_SERVER;*/
        //$detail['header'] = $header;
        //$data['detail'] = json_encode($detail);
        $url = $_SERVER['REQUEST_METHOD']." ".$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']." ".$_SERVER['SERVER_PROTOCOL']."\r\n";
        $request = $url.getallheaders(true);

        $raw_post = '';
        if(IS_POST){
            $raw_post = http_build_query($_POST);
            if(empty($raw_post)){
                $raw_post = file_get_contents("php://input");
            }
        }
        $request .= "\r\n".$raw_post;

        $data['detail'] = $request;
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['platform'] = I('server.HTTP_PLATFORM');
        $data['user_id'] = cookie('user_id');//cookie可能取出null,要求字段必须可为null
        $data['create_time'] = date("Y-m-d H:i:s");
        $data['method'] = $_SERVER['REQUEST_METHOD'];
        $data['date_int'] = time();


        try{
            $m = M('LogRequest','',C('log_db'));
            //$m->create($data);
            $logId = $m->add($data);
            C('logId',$logId);
        }catch (\Exception $e){
            tplog($e->getMessage());
        }


        //echo $m->getLastSql();exit;

    }

    /**
     * 记录响应，调用的地方有:\Think\Control->ajaxReturn()
     * @param $id
     * @param $response
     */
    function responseLog($id,$response){
       /* $data = [];
        $data['id'] = $id;
        $data['response'] = $response;
        $m = M('LogRequest','',C('log_db'));
        $m->save($data);*/

    }
	
	public function lists() {

	    //列表过滤器，生成查询Map对象
	    $map = $this->_search ();
	    if (method_exists ( $this, '_filter' )) {
	        $this->_filter ( $map );
	    }
	    $name=CONTROLLER_NAME;
	    //$model = D ($name);
	    if (! empty ( $this->m )) {
	        $this->_list ( $this->m, $map );
	    }
        $this->toview ();
        return;
	    //exit('lists erorr');
	   // $this->display ();
	    //return;
	}

	/**
     +----------------------------------------------------------
	 * 取得操作成功后要返回的URL地址
	 * 默认返回当前模块的默认操作
	 * 可以在action控制器中重载
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	function getReturnUrl() {
		return __CONTROLLER__ . '/'  .   C ( 'DEFAULT_ACTION' );
	}

	/**
     +----------------------------------------------------------
	 * 根据表单生成查询条件
	 * 进行列表过滤
     +----------------------------------------------------------
	 * @access protected
     +----------------------------------------------------------
	 * @param string $name 数据对象名称
     +----------------------------------------------------------
	 * @return HashMap
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
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
		return $map;

	}

    /**
     * 获取查询的字段
     * @return array
     */
	function getField(){
        $tableInfo = new TableInfo('list');
        $tableName = $this->m->getTableName();
        $selectFields = $tableInfo->createListSelectFields($tableName);
        return $selectFields;
    }
	/**
     +----------------------------------------------------------
	 * 根据表单生成查询条件
	 * 进行列表过滤
     +----------------------------------------------------------
	 * @access protected
     +----------------------------------------------------------
	 * @param Model $model 数据对象
	 * @param HashMap $map 过滤条件
	 * @param string $sortBy 排序
	 * @param boolean $asc 是否正序
     +----------------------------------------------------------
	 * @return void
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	protected function _list($model, $map, $sortBy = '', $asc = false) {
		//排序字段 默认为主键名
		if (!empty( $_REQUEST ['_order'] )) {
			$order = $_REQUEST ['_order'];
		} else {
			$order = ! empty ( $sortBy ) ? $sortBy : $model->getPk ();
		}
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		//$setOrder = setOrder(array(array('viewCount', 'a.view_count'), 'a.id'), $orderBy, $orderType, 'a');
		if (!empty(  $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ;
		} else {
			$sort = $asc ? 'asc' : 'desc';
		}
		//取得满足条件的记录数
		$pk = $model->getPk();
		$count = $model->where ( $map )->count ();//echo $model->getlastsql();exit('count');
		if ($count > 0) {
			import ( "ORG.Util.Page" );
			//创建分页对象
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} elseif(!empty($this->listRows)){
			    $listRows = $this->listRows;
            } else {
				$listRows = '10';
			}

            if(strtolower(MODULE_NAME) == 'user'){
                unset($_GET['user_id']);
            }
			$p = new \Think\Page ( $count, $listRows );

			$p->rollPage = 7;
			//echo C('PAGE_STYLE');exit;
			$p->style = C('PAGE_STYLE');//设置风格
			//分页查询数据
			//var_dump($p->listRows);exit;


            //========================================== cgf  start =========================================

            //$tableName = $this->m->getTableName();
            //$selectFields = $tableInfo->createListSelectFields($tableName);
            //$cgf = new \Common\Cgf\Cgf();

            //$selectFields = $tableInfo->createListSelectFields($tableName);
            //1.生成查询字段
            $selectFields = $this->cgf->generateListSelectColumn();
            //var_dump($selectFields);exit;
            if(strpos($order,'`') === false) $order = "`" . $order . "` ";
			$voList = $model->field($selectFields)->where($map)->order($order.' '. $sort)->limit($p->firstRow . ',' . $p->listRows)->select ( );

			//去掉前台不显示的字段，与上面$selectFields功能重复
			/*if(C('ret_format') == 'json' || C('ret_format') == 'jsonp'){
				$tableInfo = new TableInfo('list');
				$tableName = $this->m->getTableName();
				$fields = $tableInfo->generateHomeListFields($tableName);
				foreach ($voList as $k => &$v){
					foreach ($v as $column => $value){
						if(!in_array($column,$fields)) unset($v[$column]);
					}
				}
            }*/


            //2.当前表有关联的表字段时，取关联表信息并合并。实现join功能
            $this->cgf->mergeRelatedTableData($voList);

            //3.调用字段显示处理函数
            $this->cgf->executeColumnCallback($voList);


            //与后台管理的list里调用相关显示函数有重复，如|optionValue
            //if (method_exists ( $this, 'dateToViewModel' ))  $this->dateToViewModel ( $voList );



            //========================================== cgf  end =========================================


            if (method_exists ( $this, '_join' )) $this->_join ( $voList );

            //将导出功能注入到此处
            if(ACTION_NAME == 'exportExcel'){
                $this->realExportExcel($voList);
            }

			//var_dump($voList);exit;
			//echo $model->getlastsql();exit('x');
			//分页跳转的时候保证查询条件

			foreach ( $map as $key => $val ) {
				if (! is_array ( $val ) && !in_array($key,['_logic'])) {
					//$p->parameter .= "$key=" . urlencode ( $val ) . "&";
                    if(strtolower(MODULE_NAME) == 'user' && $key =='user_id'){
                        continue;
                    }
					$p->parameter[$key] =  urlencode ( $val );
				}
			}
			//分页显示
			$page = $p->show ();
			//列表排序显示

			$sortImg = $sort == 'desc' ? "glyphicon-arrow-down" : "glyphicon-arrow-up"; //排序图标 glyphicon glyphicon-arrow-up
            if($sort=='desc'){
                $sortImg = 'glyphicon-arrow-down';
            }elseif($sort='asc'){
                $sortImg = 'glyphicon-arrow-up';
            }else{
                $sortImg = 'glyphicon-sort';
            }

			$sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
			$sort = $sort == 'desc' ? 'asc' : 'desc'; //页面上显示的下一次排序方式
			//模板赋值显示

			$this->assign ( 'list', $voList );
			$this->assign ( 'sort', $sort );
			$this->assign ( 'order', $order );
			$this->assign ( 'sortImg', $sortImg );
			$this->assign ( 'sortType', $sortAlt );
			$this->assign ( "page", $page );
			$this->assign ( "totalPages", $p->totalPages );
			$this->assign ( "nowPage", $p->nowPage );
			$this->assign ('totalRows',$count);


			//顶部简易分页
			if($this->enableLitePage){
				$nextIndex = $p->nowPage+1;
				if($nextIndex > $p->totalPages) $nextIndex = $p->totalPages;
				$nextPageUrl = $p->url($nextIndex);
				$prevIndex = $p->nowPage-1;
				if($prevIndex < 1) $prevIndex = 1;
				$prevPageUrl = $p->url($prevIndex);
				$this->assign('nextPageUrl',$nextPageUrl);
				$this->assign('prevPageUrl',$prevPageUrl);
            }
		}else{
            $this->assign ( 'list', [] );
		}
		//cookie( '_currentUrl_', __SELF__ );
		return;
	}




	/**
     +----------------------------------------------------------
	 * 根据表单生成查询条件
	 * 进行列表过滤
	 * 返回结果，不输出
     +----------------------------------------------------------
	 * @access protected
     +----------------------------------------------------------
	 * @param Model $model 数据对象
	 * @param HashMap $map 过滤条件
	 * @param string $sortBy 排序
	 * @param boolean $asc 是否正序
     +----------------------------------------------------------
	 * @return void
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	protected function _getlist($model, $map, $sortBy = '', $asc = false) {
		//排序字段 默认为主键名
		if (isset ( $_REQUEST ['_order'] )) {
			$order = $_REQUEST ['_order'];
		} else {
			$order = ! empty ( $sortBy ) ? $sortBy : $model->getPk ();
		}
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		//$setOrder = setOrder(array(array('viewCount', 'a.view_count'), 'a.id'), $orderBy, $orderType, 'a');
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		} else {
			$sort = $asc ? 'asc' : 'desc';
		}
		//取得满足条件的记录数
		$pk = $model->getPk();
		$count = $model->where ( $map )->count ( $pk );
		if ($count > 0) {
			import ( "ORG.Util.Page" );
			//创建分页对象
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $count, $listRows );
			//echo C('PAGE_STYLE');exit;
			$p->style = C('PAGE_STYLE');//设置风格
			//分页查询数据
			//var_dump($p->listRows);exit;
			$voList = $model->where($map)->order( "`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select ( );
			//echo $model->getlastsql();
			//分页跳转的时候保证查询条件
			foreach ( $map as $key => $val ) {
				if (! is_array ( $val )) {
					$p->parameter .= "$key=" . urlencode ( $val ) . "&";
				}
			}
			//分页显示
			$page = $p->show ();
			//列表排序显示
			$sortImg = $sort; //排序图标
			$sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 'asc' : 'desc'; //页面上显示的排序方式
			//模板赋值显示
			return array('list' => $voList ,
						 'sort' => $sort,
						 'order' => $order);
			//$this->assign ( 'sortImg', $sortImg );
			//$this->assign ( 'sortType', $sortAlt );
			//$this->assign ( "page", $page );*
			/*$this->assign ( 'list', $voList );
			$this->assign ( 'sort', $sort );
			$this->assign ( 'order', $order );
			$this->assign ( 'sortImg', $sortImg );
			$this->assign ( 'sortType', $sortAlt );
			$this->assign ( "page", $page );*/
		}
		//cookie( '_currentUrl_', __SELF__ );
		return;
	}

	/**
     +----------------------------------------------------------
	 * 连接查询列表显示
	 * 进行列表过滤
     +----------------------------------------------------------
	 * @access protected
     +----------------------------------------------------------
	 * @param Model $model 数据对象
	 * @param HashMap $map 过滤条件
	 * @param string $sortBy 排序
	 * @param boolean $asc 是否正序
     +----------------------------------------------------------
	 * @return void
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	protected function _listLink($model,$map,$option=array(),  $sortBy = '', $asc = false,$sql='') {

		extract($option);


        //$option['join'] = $join; //有查询条件，开启连接查询

        $field || $field = "*";
        $table || $table = $model->getTableName();
        //$table = "{$this->trueTableName} j";
        //$r = $this->table($table)->field($field)->join($join)->where($map)->count();

        //dump($r);
        //return $r;

        //排序字段 默认为主键名
        if (isset ( $_REQUEST ['_order'] )) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = ! empty ( $sortBy ) ? $sortBy : $model->getPk ();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序
        //$setOrder = setOrder(array(array('viewCount', 'a.view_count'), 'a.id'), $orderBy, $orderType, 'a');
        if (isset ( $_REQUEST ['_sort'] )) {
            $sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }

        //取得满足条件的记录数
        $pk = $model->getPk();

        if ($option['num'] ){ //限制取几条记录，直接返回指定条记录
            if($sql){
                $voList = $model->query($sql);
            }elseif($option['join']){
                if(strpos($order,'`') === false) $order = "`" . $order . "` ";
                $voList = $model->table($table)->alias('a')->field($field)->join($option['join'])->where($map)->order( $order .' '. $sort)->limit($p->firstRow . ',' . $p->listRows)->select ( );
            }else{
                $voList = $model->where($map)->order( "`" . $order . "` " .' '.  $sort)->limit($p->firstRow . ',' . $p->listRows)->select ( );
            }
            return $voList;
        }else{ //分页

            if($sql){
                $count = $count = $model->query(getCountSql($sql));
                $count = $count[0];
            }elseif($option['join']){
                //if(strpos($order,'`') === false) $order = "`" . $order . "` ";
                $count = $model->table($table)->alias('a')->field($field)->join($join)->where($map)->count();

            }else{
                $count = $model->where ( $map )->count ( $pk );
            }
            if($count<0) return;

            import ( "ORG.Util.Page" );
            //创建分页对象
            if (! empty ( $_REQUEST ['listRows'] )) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows = '';
            }
            $p = new \Think\Page ( $count, $listRows );
            //echo C('PAGE_STYLE');exit;
            //$s =  rand(1,25);echo $s;
            $p->style = C('PAGE_STYLE');//设置风格
            //分页查询数据



            if($sql){
                $voList = $model->query($sql);
            }elseif($option['join']){
                if(strpos($order,'`') === false) $order = "`" . $order . "` ";
                $voList = $model->table($table)->alias('a')->field($field)->join($join)->where($map)->order( $order .' '. $sort)->limit($p->firstRow . ',' . $p->listRows)->select ( );
            }else{
                $voList = $model->where($map)->order( "`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select ( );
            }

            //高亮关键字
            if(C('highLightKeyword') && $_REQUEST['keyword']){
                $keyword = $_REQUEST['keyword'];
                foreach($voList as $k => $v){
                    $voList[$k]['jtitle'] = hightLightKeyword($v['jtitle'],$keyword);
                    $voList[$k]['request'] = hightLightKeyword($v['request'],$keyword);
                    $voList[$k]['ctitle'] = hightLightKeyword($v['ctitle'],$keyword);
                }
            }
            //分页跳转的时候保证查询条件
            foreach ( $map as $key => $val ) {
                if (! is_array ( $val )) {
                    $p->parameter .= "$key=" . urlencode ( $val ) . "&";
                }
            }
            //分页显示
            $page = $p->show ();
            //列表排序显示
            $sortImg = $sort; //排序图标
            $sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 'asc' : 'desc'; //页面上显示的排序方式
            //模板赋值显示
            $this->assign ( 'list', $voList );
            $this->assign ( 'sort', $sort );
            $this->assign ( 'order', $order );
            $this->assign ( 'sortImg', $sortImg );
            $this->assign ( 'sortType', $sortAlt );
            $this->assign ( "page", $page );
            $this->assign ( "totalPages", $p->totalPages );
            $this->assign ( "nowPage", $p->nowPage );
            $this->assign ('totalRows',$count);
        }
        //cookie( '_currentUrl_', __SELF__ );
        return;
	}




	//添加页面
	public function add() {
		if (method_exists ( $this, '_replacePublic' )) {
			$this->_replacePublic ( $vo );
		}
		$this -> assign('action','add');
		$this->toview();
		//$this->display ();
	}


	//编辑页面
	function edit() {
		//exit('s');
		//$name=CONTROLLER_NAME;
		//$model = M ( $name );
		//var_dump($this->m);exit;
		$id = I($this->m->getPk ());
		$where=[];
		$where['id'] = $id;
		$vo = $this->m->where($where)->find();

		if (method_exists ( $this, '_replacePublic' )) {
			$this->_replacePublic ( $vo );
		}
		//cookie( '_currentUrl_', __SELF__ );
		$this->vo = $vo;
        $this -> assign('action','edit');
		if(IS_MOBILE){
			$this->toview("","wapadd");
		}else{
			$this->toview("","add");
		}
		//$this->assign ( 'vo', $vo );
		//$this->display ('add');
	}

    //保存添加和编辑
    function save() {
        //var_dump($this->isAjax());exit;
        $id = I($this->m->getPk ());
        //$vo = $this->m->getById ( $id );

        if(empty($id)){

            $_POST['user_id'] = $this->user_id; //添加时默认加上用户id
            if (false === $this->m->create ()) {
                $this->error ( $this->m->getError () );
            }
            $r=$this->m->add ();
        }else{

            if (false === $this->m->create ()) {
                $this->error ( $this->m->getError () );
            }
            $r=$this->m->save ();
        }
        //保存当前数据对象

        //echo $this->m->getLastSql();exit;
        if ($r!==false) { //保存成功
            $jumpUrl = cookie ( '_currentUrl_' );
            if(empty(jumpUrl)){
                $jumpUrl = CONTROLLER_NAME;//."/index";
            }
            $this->assign ( 'jumpUrl', $jumpUrl );
            $this->success ('保存成功!',$jumpUrl);
        } else {
            //失败提示
            $this->error ('保存失败!');
        }


    }

	/**
     +----------------------------------------------------------
	 * 默认删除操作
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	public function delete() {
		//删除指定记录
		$name=CONTROLLER_NAME;
		//$model = M ($name);
		if (! empty ( $this->m )) {
			$pk = $this->m->getPk ();
			$id = I($pk);
			if (!empty ( $id )) {
				$condition = array ($pk => array ('in', explode ( ',', $id ) ) );
				$list=$this->m->where ( $condition )->setField ( 'status', 0 );
				if ($list!==false) {
					$this->success ('删除成功！',cookie ( '_currentUrl_' ));
				} else {
					$this->error ('删除失败！');
				}
			} else {
				$this->error ( '非法操作' );
			}
		}
	}
	public function foreverdelete() {
		//删除指定记录
		$name=CONTROLLER_NAME;
		//$model = D ($name);
		if (! empty ( $this->m )) {
			$pk = $this->m->getPk ();
            $id = I($pk);
			if (isset ( $id )) {
				$condition = array ($pk => array ('in', explode ( ',', $id ) ) );

				//用户中心增加用户id条件
				if(MODULE_NAME == 'User') $condition['user_id'] = $this->user_id;
                $r = $this->m->where($condition)->select();
                if(empty($r)) $this->error ( '非法操作' );
				if (false !== $this->m->where ( $condition )->delete ()) {


                    if (!empty(I(C('VAR_JSONP_HANDLER'))) || IS_AJAX){
                        $method_name = '_after_' . ACTION_NAME;
                        if(method_exists($this,$method_name)){
                            //if(is_callable([$this,$method_name])){
                            $this->$method_name($r);
                           /* if ($after->isPublic()) {
                                $after->invoke($module);
                            }*/
                        }
                    }

                    $this->assign ( 'jumpUrl', cookie ( '_currentUrl_' ) );
					$this->success ('删除成功！',cookie ( '_currentUrl_' ));
				} else {
					$this->error ('删除失败！');
				}
			} else {
				$this->error ( '非法操作' );
			}
		}
		$this->forward ();
	}

	public function clear() {
		//删除指定记录
		$name=CONTROLLER_NAME;
		//$this->m = D ($name);
		if (! empty ( $this->m )) {
			if (false !== $this->m->where ( 'status=1' )->delete ()) {
				$this->assign ( "jumpUrl", $this->getReturnUrl () );
				$this->success ( L ( '_DELETE_SUCCESS_' ) );
			} else {
				$this->error ( L ( '_DELETE_FAIL_' ) );
			}
		}
		$this->forward ();
	}
	/**
     +----------------------------------------------------------
	 * 默认禁用操作
	 *
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws FcsException
     +----------------------------------------------------------
	 */
	public function forbid() {
		$name=CONTROLLER_NAME;
		//$model = D ($name);
		$pk = $this->m->getPk ();
		$id = $_REQUEST [$pk];
		$condition = array ($pk => array ('in', $id ) );
		$list=$this->m->forbid ( $condition );
		if ($list!==false) {
			$this->assign ( "jumpUrl", $this->getReturnUrl () );
			$this->success ( '状态禁用成功' );
		} else {
			$this->error  (  '状态禁用失败！' );
		}
	}
	public function checkPass() {
		$name=CONTROLLER_NAME;
		//$model = D ($name);
		$pk = $this->m->getPk ();
		$id = $_GET [$pk];
		$condition = array ($pk => array ('in', $id ) );
		if (false !== $this->m->checkPass( $condition )) {
			$this->assign ( "jumpUrl", $this->getReturnUrl () );
			$this->success ( '状态批准成功！' );
		} else {
			$this->error  (  '状态批准失败！' );
		}
	}

	public function recycle() {
		$name=CONTROLLER_NAME;
		//$model = D ($name);
		$pk = $this->m->getPk ();
		$id = $_GET [$pk];
		$condition = array ($pk => array ('in', $id ) );
		if (false !== $this->m->recycle ( $condition )) {

			$this->assign ( "jumpUrl", $this->getReturnUrl () );
			$this->success ( '状态还原成功！' );

		} else {
			$this->error   (  '状态还原失败！' );
		}
	}

	public function recycleBin() {
		$map = $this->_search ();
		$map ['status'] = - 1;
		$name=CONTROLLER_NAME;
		//$model = D ($name);
		if (! empty ( $this->m )) {
			$this->_list ( $this->m, $map );
		}
		$this->display ();
	}

	/**
     +----------------------------------------------------------
	 * 默认恢复操作
	 *
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws FcsException
     +----------------------------------------------------------
	 */
	function resume() {

		//恢复指定记录
		$name=CONTROLLER_NAME;
		//$model = D ($name);
		$pk = $this->m->getPk ();
		$id = $_GET [$pk];
		$condition = array ($pk => array ('in', $id ) );
		if (false !== $this->m->resume ( $condition )) {
			$this->assign ( "jumpUrl", $this->getReturnUrl () );
			$this->success ( '状态恢复成功！' );
		} else {
			$this->error ( '状态恢复失败！' );
		}
	}


function saveSort() {
		$seqNoList = $_POST ['seqNoList'];
		if (! empty ( $seqNoList )) {
			//更新数据对象
		$name=CONTROLLER_NAME;
		//$model = D ($name);
			$col = explode ( ',', $seqNoList );
			//启动事务
			$this->m->startTrans ();
			foreach ( $col as $val ) {
				$val = explode ( ':', $val );
				$this->m->id = $val [0];
				$this->m->sort = $val [1];
				$result = $this->m->save ();
				if (! $result) {
					break;
				}
			}
			//提交事务
			$this->m->commit ();
			if ($result!==false) {
				//采用普通方式跳转刷新页面
				$this->success ( '更新成功' );
			} else {
				$this->error ( $this->m->getError () );
			}
		}
	}

	protected function msgText($nextModel,$nextModelText,$id){
		$app = __APP__;
		$url = __CONTROLLER__;

		return "发布成功!  <a href='$app/$nextModel/add'>发布{$nextModelText}信息</a> <a href='$url/edit/id/$id'>返回修改信息</a> <a href='$url/'>返回列表</a>";
	}

	public function show($content="",$charset='',$contentType='',$prefix=''){
		$id = I('id');
		$vo = $this->m->getById ( $id );
		if (method_exists ( $this, '_show' )) {
			$this->_show ( $vo );
		}
		$this->vo = $vo;
		$this->toview();

    }






	function upload($stype='file'){
	    $uploadInfo = $this->commonUpload($stype);
        $this->upload = $uploadInfo;
        $this->toview();
    }

    /**
     * 通用上传，支持多张上传
     * @param string $moduleDir 模块目录名
     * @return array 上传结果，一张图片，一个array,key为上传控件的名字
     */
	protected function commonUpload($stype='file'){

	    $type = I('type','file');
		if(C('UPLOAD_STRORAGE') == 'oss'){
            //传到aliyun
            C('UPLOAD_SITEIMG_OSS.savePath',$stype.'/');
            $setting=C('UPLOAD_SITEIMG_OSS');
            $upload = new \Think\Upload($setting);
            $info = $upload->upload();
		}else{
            $config = array(
                'subName'    =>    array('date','Ymd'),
            );
            //$modelName = "file/";
            $rootPath = C('SAVE_PATH');
            $upload = new \Think\Upload($config);
            $upload->maxSize   =     31457280 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','doc','docx','rar','zip','tar','tar.gz','tgz','7z','txt','flv','mp4','mov');// 设置附件上传类型
            $upload->rootPath  =     $rootPath; // 设置附件上传根目录
            $upload->savePath  =     $stype.'/'; // 设置附件上传（子）目录
            //传到本地
            $info   =   $upload->upload();
		}

        if(!$info) {
            $this->error($upload->getError());
        }else{
			$ret = [];
            $f = M('image');


            $multiple = I('multiple');

            //从数组中取出重复的元素

            if(!$multiple){
                $file_names = array_column($info,'key');
                $unique_arr = array_unique ( $file_names );

                //有多个文件的file对象的名称
                $muti_file_key = array_diff_assoc ( $file_names, $unique_arr );
            }
            //var_dump($repeat_arr);
            //exit;

            $goods_id = 1;
			foreach ($info as $k => $fileInfo){

				/* $cropInfo = I('avatar_data');
				 $cropInfo = json_decode($cropInfo,1);
				 foreach ($cropInfo as &$v){
					 $v = round($v);
				 }*/

				$filePath = $fileInfo['savepath'].$fileInfo['savename'];
				/* $data = [];
				 if( $this->crop($fileInfo,$cropInfo['width'],$cropInfo['height'],$cropInfo['x'],$cropInfo['y'],$cropInfo['rotate'])){
					 $filePath .= "_{$cropInfo['width']}x{$cropInfo['height']}.{$fileInfo['ext']}";
				 }
				 $data['url'] = URL_IMG.'/'.$filePath;*/
				//$data = $info['avatar_file'];

                $data = [];
				$data['res_id'] = $goods_id;
				$data['type'] = 20;
				//$data['user_id'] = $this->user_id;
				$data['hd_url'] = $filePath;
				$data['nhd_url'] = $filePath;
				$data['create_t'] = time();
				/*$data['title'] = I('title');
				$data['content'] = I('content');
				$data['type'] = $type;
				$data['input_name'] = trim(trim($fileInfo['key'],"'"),'_');*/
				$id = $f->add($data);

				if( $multiple
                    || !empty($muti_file_key) &&  in_array($data['input_name'],$muti_file_key)){ //多文件上传，返回数组
                    $ret[$data['input_name']][] = ["id" => $id,'path' => $filePath,'url' => img($filePath,'big'), ];
                }else{
                    $ret[$data['input_name']] = ["id" => $id,'path' => $filePath,'url' => img($filePath,'big'), ];
                }
            }

            return $ret;
            //$this->success();
            //var_dump($data);exit('x');
            //$this->toview($data);
        }
	}

	function responseFormat(){
	    $format = "";
	    if(IS_AJAX || C('RETRUN_FORMAT') == "android_json" || I('ret_format') == 'json' || $_SERVER['HTTP_ACCEPT'] == 'application/json'){ //json,app: code,msg,data
	        return "json";
	    }elseif (!empty(I(C('VAR_JSONP_HANDLER')))){ //jsonp
	        return "jsonp";
	    }elseif(isMobile()){ 
	        return "wap";
	    }else{
	        return "web";
	    }
	}

	/**
	* @name 根据请求方式，显示对应的格式到页面
    * @param  数据  array $data
	* @param  格式类型  int $type
    * @return   member
    */
	public function toview($data = "",  $tpl=""){

        if(!APP_DEBUG) {
            //action结束，缓存viewData
            \Think\Hook::listen('setViewData', $this); // //tag('setViewData',$this);
        }


		if(empty($data)) $data = $this->get();
		//var_dump($data);//exit;
		//if(!empty($tpl)) $this->display($tpl);
		//var_dump($_SERVER);exit;
		if(IS_AJAX || C('RETRUN_FORMAT') == "android_json" || I('ret_format') == 'json' || $_SERVER['HTTP_ACCEPT'] == 'application/json'){ //json,app: code,msg,data
			if(empty($data)) $data = (object)$data;
		    $this->success($data,"",1);
		}elseif (!empty(I(C('VAR_JSONP_HANDLER')))){ //jsonp 
			$this->ajaxReturn(array("code" =>1, "msg" => "","data" => $data),'JSONP');
		}elseif(isMobile()){ //wap

			empty($tpl) && $tpl = RAW_ACTION_NAME;
			$wapTpl = "wap_".$tpl;
			$templateFile   =   $this->view->parseTemplate($wapTpl);
			
			//var_dump($templateFile);exit;
			//if()
            $www_host = parse_url(URL_WWW)['host'];
            if($_SERVER['HTTP_HOST'] == $www_host){
                redirect(URL_M.__SELF__);
            }
            /*
            elseif ($_SERVER['HTTP_HOST'] == $news_host){
                //新闻则跳转到wap的新闻模块
                redirect(URL_M.'news/'.__SELF__);
            }*/

            //var_dump(SCHEME.$_SERVER['HTTP_HOST'] ,URL_M, SCHEME.$_SERVER['HTTP_HOST'] , URL_USER,URL_M.__SELF__);exit;
			//if(SCHEME.$_SERVER['HTTP_HOST'] !=URL_M && SCHEME.$_SERVER['HTTP_HOST'] != URL_USER) redirect(URL_M.__SELF__);




			if(is_file($templateFile)) $this->display($wapTpl);
			else $this->display($tpl);
		}else{ //web

    		$this->display($tpl);
		}
		
		
		/* if(!empty(I(C('VAR_JSONP_HANDLER')))){ //ajax返回,默认json格式
			$this->ajaxReturn($data,$type);
		}elseif(IS_AJAX){ //jsonp格式
			//var_dump($data);exit;
			$this->success($data,"成功！",1);
		}elseif(C('RETRUN_FORMAT') == "android_json" || I('ret_format') == 'json'){
			$this->ajaxReturn($data); //android格式数据必须有个[]
	 
		}elseif(isMobile()){
			$this->display("wap".__ACTION__);
		}else{ //html
    		$this->display($tpl);
		} */
	}

	/*function success($data,$msg = 'success',$code = 1,$jumpUrl = ''){
        $this->dispatchJump2($data,$msg,$code,$jumpUrl);
	}*/

    /**
     * @param string $firstParam
     * @param string $secondParam
     * @param string $jumpUrl
     * @param bool $ajax
     */
	function success($firstParam='成功',$secondParam='',$jumpUrl='',$ajax=false){
		//第一个参数是数组或对象，说明是app返回，则第二个参数是msg
		if(is_array($firstParam) || is_object($firstParam)){ //api返回
			$data = $firstParam;
			$msg = $secondParam;
		}else{ //pc返回,第一个参数做msg,第二个参数做跳转url
			$data = '';
			$msg = $firstParam;
			$jumpUrl = $secondParam;
		}
        $this->dispatchJump2($data,$msg,1,$jumpUrl,$ajax);
	}
	function error($message='',$jumpUrl='',$ajax=false,$status=0){
        $ret_format = $this->responseFormat();
        if(in_array($ret_format,['json','jsonp']) ){
            $data           =   [];
            $data['code'] =   $status;
            $data['msg']   =   $message;
            $data['data']    =   (object)array();
            if($jumpUrl)   $data['jumpUrl']    =   $jumpUrl;

            $this->ajaxReturn($data,$ret_format);
        }

        /*if("json" == $this->responseFormat() || "jsonp" == $this->responseFormat()) $ajax = 1;
		if($ajax || IS_AJAX) {// AJAX提交
			$data           =   is_array($ajax)?$ajax:array();
			$data['code'] =   $status;
			$data['msg']   =   $message;
			$data['data']    =   (object)array();

            $type = C('ret_format');
            if($type != 'json' && $type != 'jsonp') $type = 'json';
			$this->ajaxReturn($data,$type);
		}*/
		if(is_int($ajax)) $this->assign('waitSecond',$ajax);
		if(!empty($jumpUrl)) $this->assign('jumpUrl',$jumpUrl);
		// 提示标题
		$this->assign('msgTitle',$status? L('_OPERATION_SUCCESS_') : L('_OPERATION_FAIL_'));
		//如果设置了关闭窗口，则提示完毕后自动关闭窗口
		if($this->get('closeWin'))    $this->assign('jumpUrl','javascript:window.close();');
		$this->assign('status',$status);   // 状态
		//保证输出不受静态缓存影响
		C('HTML_CACHE_ON',false);
		if($status) { //发送成功信息
			$this->assign('message',$message);// 提示信息
			// 成功操作后默认停留1秒
			if(!isset($this->waitSecond))    $this->assign('waitSecond','1');
			// 默认操作成功自动返回操作前页面
			if(!isset($this->jumpUrl)) $this->assign("jumpUrl",$_SERVER["HTTP_REFERER"]);
            if(isMobile()){
                $this->display(C('TMPL_ACTION_SUCCESS_WAP'));
            }else{
                $this->display(C('TMPL_ACTION_SUCCESS'));
            }
		}else{
			$this->assign('error',$message);// 提示信息
			//发生错误时候默认停留3秒
			if(!isset($this->waitSecond))    $this->assign('waitSecond','3');
			// 默认发生错误的话自动返回上页
			if(!isset($this->jumpUrl)) $this->assign('jumpUrl',"javascript:history.back(-1);");
            if(isMobile()){
                $this->display(C('TMPL_ACTION_ERROR_WAP'));
            }else{
                $this->display(C('TMPL_ACTION_ERROR'));
            }
			// 中止执行  避免出错后继续执行
			exit ;
		}
	}

	//	$this->dispatchJump2($message,1,$jumpUrl,$ajax);
	function dispatchJump2($data, $msg='', $status = 1, $jumpUrl='', $ajax=false){

		if (!empty(I(C('VAR_JSONP_HANDLER')))){ //jsonp
            if(empty($data)) $data = (object)[];
			$this->ajaxReturn(array("code" =>$status, "msg" => $msg,"data" => $data),'JSONP');
		}

		if(IS_AJAX) {// AJAX和ret_format=json
			if(empty($data)) $data = (object)[];
			$ret = [];
            $ret['code'] =   $status;
            $ret['msg']    =   $msg;
            $ret['data']   =   $data;
            $ret['jumpUrl']    =   $jumpUrl;
			$this->ajaxReturn($ret);
		}

		if(is_int($ajax)) $this->assign('waitSecond',$ajax);
		if(!empty($jumpUrl)) $this->assign('jumpUrl',$jumpUrl);
		// 提示标题
		$this->assign('msgTitle',$status? L('_OPERATION_SUCCESS_') : L('_OPERATION_FAIL_'));
		//如果设置了关闭窗口，则提示完毕后自动关闭窗口
		if($this->get('closeWin'))    $this->assign('jumpUrl','javascript:window.close();');
		$this->assign('status',$status);   // 状态
		//保证输出不受静态缓存影响
		C('HTML_CACHE_ON',false);
		if($status) { //发送成功信息
			$this->assign('message',$msg);// 提示信息


            if($this->jumpMenu){
                $this->jumpMenu = str_replace('{$info_id}', C('info_id'),$this->jumpMenu);
                $this->assign('jumpMenu',$this->jumpMenu);
            }

			// 成功操作后默认停留1秒
			if(!isset($this->waitSecond))    $this->assign('waitSecond','1');
			// 默认操作成功自动返回操作前页面
			if(!isset($this->jumpUrl)) $this->assign("jumpUrl",$_SERVER["HTTP_REFERER"]);
            if(isMobile()){
                $this->display(C('TMPL_ACTION_SUCCESS_WAP'));
            }else{
                $this->display(C('TMPL_ACTION_SUCCESS'));
            }
		}else{
			$this->assign('error',$msg);// 提示信息
			//发生错误时候默认停留3秒
			if(!isset($this->waitSecond))    $this->assign('waitSecond','3');
			// 默认发生错误的话自动返回上页
			if(!isset($this->jumpUrl)) $this->assign('jumpUrl',"javascript:history.back(-1);");
            if(isMobile()){
                $this->display(C('TMPL_ACTION_ERROR_WAP'));
            }else{
                $this->display(C('TMPL_ACTION_ERROR'));
            }
			// 中止执行  避免出错后继续执行
			exit ;
		}
	}

    /**
     * @param string $firstParam data | msg
     * @param string $secondParam msg  | jumpUrl
     * @param string $jumpUrl
     * @param bool $ajax
     */
	//function response($firstParam='',$secondParam='',$jumpUrl=''){
    function error_new($msg='',$jumpUrl='',$ajax=false){
       /* //第一个参数是数组或对象，说明是app返回，则第二个参数是msg
        if(is_array($firstParam) || is_object($firstParam)){ //api返回
            $data = $firstParam;
            $msg = $secondParam;
        }else{ //pc返回,第一个参数做msg,第二个参数做跳转url
            $data = '';
            $msg = $firstParam;
            $jumpUrl = $secondParam;
        }*/

        $status = 0;
        $ret_format = $this->responseFormat();
        if(in_array($ret_format,['josn','jsonp']) ){
            $data           =   [];
            $data['code'] =   $status;
            $data['msg']   =   $msg;
            $data['data']    =   (object)array();
            $this->ajaxReturn($data,$ret_format);
        }

        //保证输出不受静态缓存影响
        C('HTML_CACHE_ON',false);

        $this->assign('error',$msg);// 提示信息
        //发生错误时候默认停留3秒
        if(!isset($this->waitSecond))    $this->assign('waitSecond','3');
        // 默认发生错误的话自动返回上页
        if(!isset($this->jumpUrl)) $this->assign('jumpUrl',"javascript:history.back(-1);");
        if(isMobile()){
            $this->display(C('TMPL_ACTION_ERROR_WAP'));
        }else{
            $this->display(C('TMPL_ACTION_ERROR'));
        }
        // 中止执行  避免出错后继续执行
        exit ;
    }

	//用户信息
	function userinfo(){
		if(empty($this->user_id)) return;

		$u = M('User');
		$userinfo = $u->find($this->user_id);
		unset($userinfo['id']);
		unset($userinfo['pwd']);
		unset($userinfo['open_id']);
		unset($userinfo['bind']);
		$userinfo = json_encode($userinfo);
		$this->userinfo = $userinfo;

	}

	//右边栏
	function right(){
		$f = M('Family');
		$r = $f->where("status = 1")->order("num desc")->limit(5)->select();
		$this->listByNum = $r;

	}

	//设置标题
	function setTitle($title){
		$this->pageTitle = empty($title) ? C('SITE_TITLE') :  $title.'_'.C('SITE_TITLE');
		//$title && $title = $title."_";
		//$this->pageTitle = $title.C('SITE_TITLE');
	}

	//验证码
	public function createVerifyCode(){
		$Verify = new \Think\Verify();
		$Verify->entry();
	}

    function setParam($key,$value){
        $_REQUEST[$key] = $_POST[$key] = $_GET[$key] = $value;
    }


}
