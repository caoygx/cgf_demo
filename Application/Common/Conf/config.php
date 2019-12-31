<?php
$custom = require CONF_ENV . ".php";

//公共配置
$conf = array(


    /* 数据库设置 */
    'DB_TYPE'   => 'mysql',
    'DB_HOST'   => '127.0.0.1',
    'DB_PORT'   => '3306',
    'DB_NAME'   => 'cgf_demo',
    'DB_USER'   => 'root',
    'DB_PWD'    => '123456',
    'DB_PREFIX' => 'cgf_',
    'DB_CHARSET'     => 'utf8mb4',      // 数据库编码默认采用utf8

    //if(version>1.0)
    'DB_PARAMS'      => array(
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL, //字段使用原始的大写
        // \PDO::ATTR_STRINGIFY_FETCHES => false, //数字不转字符串
        // \PDO::ATTR_EMULATE_PREPARES => false //数字不转字符串
    ),

    'log_db'     => [
        'DB_TYPE'    => 'mysql',     // 数据库类型
        'DB_HOST'    => '', // 服务器地址
        'DB_NAME'    => 'log',          // 数据库名
        'DB_USER'    => 'dbdata',      // 用户名
        'DB_PWD'     => 'dbdata',          // 密码
        'DB_PORT'    => '3306',        // 端口
        'DB_PREFIX'  => '',    // 数据库表前缀
        'DB_CHARSET' => 'utf8',      // 数据库编码默认采用utf8
        'DB_PARAMS'  => array(
            \PDO::ATTR_TIMEOUT => 2,
            \PDO::ATTR_CASE    => \PDO::CASE_NATURAL, //字段使用原始的大写
        ),
    ],

    //默认操作
    "f_action"   => 'status|showStatus=$user[\'id\'],edit:编辑:id',//,edit:编辑:id,foreverdel:永久删除:id
    'tpl_fields' => [
        "common" => [
            "f_list"   => "id:编号|8%,title:信息名:edit,create_time|toDate='y-m-d':创建时间,status|getStatus2:状态,edit:编辑:id",
            "f_action" => 'status|showStatus=$user[\'id\']',
            'f_add'    => 'title,create_time',
        ],


        "order"   => [
            "f_action" => 'wxpaySendGoods:微信补发货:order_no,alipaySendGoods:支付宝补发货:order_no',
        ],
        "comment" => [
            "f_action" => 'status|showStatus=$user[\'id\'],edit:编辑:id',
        ],
        "user"    => [
            "f_action" => 'status|showStatus=$user[\'id\'],',
            'f_add'    => 'title,create_time',
        ],

    ],

    'save_response' => true, //是否保存响应信息

    'admin_eamil' => 'admin@qq.com', //错误信息接收邮箱

    //邮件配置
    'M_DOMAIN'    => '163.com', //域名
    'M_HOST'      => 'smtp.163.com', //邮件服务器
    'M_USER'      => 'admin',     //用户名
    'M_PASSWORD'  => '123456', //密码
    'M_PROT'      => '',    //端口


    'ret_format'     => '', //返回格式




    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES' => array( //定义路由规则
        'video/:id\d'              => 'video/show',
    ),


    'SITE_TITLE' => '管理',

    //手机验证码key
    'code_keys'  => [
        'login'          => '_login_code',
        'bind'           => '_bind_code',
        'bindBank'       => '_bindBank_code',
        'withdrawalCode' => '_withdrawalCode_code'
    ],

    'sms_tpl'         => [
        'default'    => '',
        'withdrawal' => '',
    ],


    //debug模式下开启
    'DB_FIELDS_CACHE' => false,
    'TMPL_CACHE_ON'   => false,

    'sms_code_expire'           => 300, //短信有效期 s
    'max_send_sms_count_per_ip' => 10, //每ip最大发送短信次数

    //子用户权限
    'AccessKeyID'               => '',
    'AccessKeySecret'           => '',

    //上传配置
    'SAVE_PATH'                 => "uploads/",
    'show_test_waring'       => false, //显示接口测试警告信息
    //'output_way' => 'chrome',
    //'FIRE_SHOW_PAGE_TRACE' => true,
    'CHROME_SHOW_PAGE_TRACE' => true,
    'shopping_cart_count' => 20,
    'PHP_AUTH_USER' => '',
    'PHP_AUTH_PW'   => '',

    //认证存储方式
    'AUTH_ENCRYPT'   => false, //是否加密凭证
    'AUTH_STORE_WAY' => "cookie",
    'COOKIE_PREFIX'  => 'cccc', //cookie前缀，若修改，需要同时修改get-weixin-code.html里写死的前缀
    'COOKIE_PATH'    => '/',
    'COOKIE_EXPIRE'  => '864000',
    'COOKIE_DOMAIN'  => "." . DOMAIN,
    //'配置项'=>'配置值'
    'URL_MODEL'      => 2,
    'LOG_RECORD'         => true, // 开启日志记录
    'LOG_LEVEL'          => 'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误 SQL

    //缓存key
    'CACHE_KEY'          => array(
        "child" => "child_",

    ),
    'crypt_key'          => "", //用户id加密key
    'crypt_key_mergePay' => "", //合并支付，订单号加密key

    'DEFAULT_FILTER'  => '', //过滤函数
    'TAGLIB_PRE_LOAD' => 'html,OT\\TagLib\\Think',
    'URL_MODEL'       => 3,
    'DB_TYPE'         => 'mysql',
    'DB_PORT'         => '3306',
//'DB_PREFIX'=>'other_',

//'URL_CASE_INSENSITIVE' => true,


    'URL_MODEL'             => 2, //默认1;URL模式：0 普通模式 1 PATHINFO 2 REWRITE 3 兼容模式
    'ROUTER_ON'             => true, // 是否开启URL路由
    'DEFAULT_MODULE'        => 'Admin',
    'APP_SUB_DOMAIN_DEPLOY' => 1, // 开启子域名配置
    'APP_SUB_DOMAIN_RULES'  => array(
        'www'     => 'Home',
        'u'       => 'User',
        'm'       => 'Home',
        'api'     => 'Home',
        'cgf'     => 'Doc',
        'jpadmin' => 'Admin',
        'test'    => 'Test',

    ),


    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => URL_PUBLIC,
        '__PH__'     => URL_PUBLIC . '/pc',
        '__PM__'     => URL_PUBLIC . '/m',
        '__PU__'     => URL_PUBLIC . '/u',
        '__SKIN__'   => URL_SKIN, //
        '__UPLOAD__' => '/Uploads', //
        //'__URL__' => NEW_URL,
        '__IMG__'    => URL_IMG,
        '__U__'      => URL_USER,
        '__W__'      => URL_WWW,
        '__F__'      => URL_FAMILY,
        '__M__'      => URL_M,
        '__API__'    => URL_API,
        '__UAPI__'   => URL_USER,
        '__LOCAL__'  => URL_LOCAL,
    ),


    'USER_AUTH_ACTION' => 'add,insert,edit,update,remove,delete,ulist',  //前台需要验证的操作


    'default_pic' => [
        'id_card_front'   => URL_PUBLIC . "/default_id_card_front.jpg?x-oss-process=style/thumb", //身份证正面
        'id_card_reverse' => URL_PUBLIC . "/default_id_card_reverse.jpg?x-oss-process=style/thumb",//身份证反面
    ],

    'DEFAULT_IMG'    => URL_PUBLIC . '/default.jpg?x-oss-process=style/thumb', //默认图片
    'DEFAULT_AVATAR' => URL_PUBLIC . '/Plugin/cropper/img/picture.jpg', //默认图片
    'IMG_SEX_1'      => URL_PUBLIC . '/sex_1.gif',
    'IMG_SEX_0'      => URL_PUBLIC . '/sex_0.gif',

    'PAGE_LISTROWS'    => 10, //每页记录数
    'PAGE_STYLE'       => 0,    //分页样式16
    'VAR_PAGE'         => "p", //url里的分页参数名:p=1

//静态化
//'HTML_CACHE_ON' => true,
    'HTML_CACHE_TIME'  => 7200,
    'HTML_READ_TYPE'   => 0,
    'HTML_FILE_SUFFIX' => '.html',


    'UC_AUTH_TABLE' => 'rrbrr_ucenter.uc_members',

    'highLightKeyword' => true, //高亮关键字

    'SESSION_AUTO_START'  => true,
    'USER_AUTH_ON'        => true,
    'USER_AUTH_TYPE'      => 1,        // 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY'       => 'authId',    // 用户认证SESSION标记
    'ADMIN_AUTH_KEY'      => 'administrator',
    'USER_AUTH_MODEL'     => 'User',    // 默认验证数据表模型
    'AUTH_PWD_ENCODER'    => 'md5',    // 用户认证密码加密方式
    'USER_AUTH_GATEWAY'   => 'http://u.' . DOMAIN . '/Public/login',// 默认认证网关
    'NOT_AUTH_MODULE'     => 'Public',    // 默认无需认证模块
    'REQUIRE_AUTH_MODULE' => 'add,save,insert,edit,import,saveImport',        // 默认需要认证模块
    'NOT_AUTH_ACTION'     => '',        // index,lists,show 默认无需认证操作
    'REQUIRE_AUTH_ACTION' => '',        // 默认需要认证操作
    'GUEST_AUTH_ON'       => false,    // 是否开启游客授权访问
    'GUEST_AUTH_ID'       => 0,        // 游客的用户ID
    'DB_LIKE_FIELDS'      => 'title|remark',
    'RBAC_ROLE_TABLE'     => 'think_role',
    'RBAC_USER_TABLE'     => 'think_role_user',
    'RBAC_ACCESS_TABLE'   => 'think_access',
    'RBAC_NODE_TABLE'     => 'think_node',


);


return array_merge($conf, $custom);
