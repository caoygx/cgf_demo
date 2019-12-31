<?php

nameSpace Admin\Controller;

use Common\CgfController;

class BaseController extends CgfController
{
    //禁用后台log
    protected $enableLog=false;

    protected $isAdmin;

    /**
     * @var string 默认排序字段
     */
    protected $defaultOrder = "id";

    /**
     * @var string 默认排序方式
     */
    protected $defaultSort = "desc";
    function _initialize()
    {
        parent::_initialize();

        //cli 跳过权限验证
        if(IS_CLI) return true;

        //权限验证
        $this->getAuth();
        if (empty($this->user_id)) {
            $this->error('请先登录', U('Login/login'));
        }else{
            //$_REQUEST['user_id'] = $_POST['user_id']  = $_GET['user_id'] = $this->user_id; //设置登录的用户id,用户读取自己的记录
        }

        //判断用户是否是超级管理员
        $access = M('auth_group_access');
        $rAccess = $access->where(['uid'=>$this->user_id])->find();
        if ($this->user_id == 1 || $rAccess['group_id'] == 1) {
            $this->isAdmin = true;
        }

/* 
//配置菜单导入db
        $m = M('authRule');
        $menu = C('menu');
        foreach ($menu as $k=>$v){
            $data = [];
            $data['module'] = 'admin';
            $data['pid'] = '0';
            $data['type'] = '2';
            if(substr($v['url'],0,1) == '/'){
                $data['name'] = substr($v['url'],1);
            }else{
                $data['name'] = $v['url'];
            }

            $data['title'] = $v['title'];
            $pid = $m->add($data);
            foreach ($v['children'] as $k2=>$v2){
                $data = [];
                $data['module'] = 'admin';
                $data['pid'] = $pid;
                $data['type'] = '2';
                if(substr($v2['url'],0,1) == '/'){
                    $data['name'] = substr($v2['url'],1);
                }else{
                    $data['name'] = $v2['url'];
                }
                $data['title'] = $v2['title'];
                $m->add($data);
            }
        }
*/
        //超管不验证权限
        if($this->isAdmin){
            //return true;
            $menu = C('menu');
        }else{
            //后台权限判断
            //$rule = CONTROLLER_NAME . '/' . ACTION_NAME;
            $rule = CONTROLLER_NAME ; //只精确到模块验证
            $Auth = new \Think\Auth();
            if (!$Auth->check($rule, $this->user_id)) {
                $this->error("你没有权限");
            }
            $authList = $Auth->getAuthList($this->user_id,1);

        }



        $this->assign('menu',$menu);
        $this->assign('admin_name',$this->user['name']);





        //$this->getMenuTitleByUrl('a');

        //导航条
        //strtolower(CONTROLLER_NAME) ==
        //var_dump($_SERVER);exit;

    }


    //默认排序字段
    function _before_lists(){
        if(empty($_REQUEST['_order'])){
            $_REQUEST['_order'] = $this->defaultOrder;
        }

        if(empty($_REQUEST['_sort'])) {
            $_REQUEST['_sort'] = $this->defaultSort;
        }
    }

    //默认排序字段
    function _before_index(){
        if(empty($_REQUEST['_order'])){
            $_REQUEST['_order'] = $this->defaultOrder;
        }

        if(empty($_REQUEST['_sort'])) {
            $_REQUEST['_sort'] = $this->defaultSort;
        }
    }

    //获取用户登录凭证信息
    function getAuth()
    {
        $u = getAdminAuth();
        if (empty($u)) return false;
        $dbUserInfo = M('Admin')->find($u['user_id']);
        if (empty($dbUserInfo)) {
            echo '未登录,非法用户';
            return false;
        }
        $this->user_id = $dbUserInfo['id'];
        $this->user = $dbUserInfo;
        return $dbUserInfo;

    }

    /**
     * overrite commonController的 _search
     * @param string $name
     * @return array|\Common\HashMap
     */
    protected function _search($name = '') {
        $map = parent:: _search($name);

        //管理员能查看所有人发布的信息，其它人，只能查看自己发布的信息，要带上登录的user_id.
        //但如果要搜索某个user_id时，则出现问题，造成忽略了user_id,无法搜索指定的信息
        //后台暂时放弃区分用户id,
        if($this->isAdmin){
            //unset($map['user_id']);
        }
        return $map;

    }



}