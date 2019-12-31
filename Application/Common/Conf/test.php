<?php
return array(

    /* 数据库设置 */
    'DB_TYPE'    => 'mysql',     // 数据库类型
    'DB_HOST'    => '127.0.0.1', // 服务器地址
    'DB_NAME'    => 'test',          // 数据库名
    'DB_USER'    => 'test',      // 用户名
    'DB_PWD'     => 'pwd',          // 密码
    'DB_PORT'    => '3306',        // 端口
    'DB_PREFIX'  => '',    // 数据库表前缀
    'DB_CHARSET' => 'utf8',      // 数据库编码默认采用utf8

    'APP_SUB_DOMAIN_RULES' => array(
        'www'   => 'Home',
        'u'     => 'User',
        'm'     => 'Home',
        'api'   => 'Home',
        'doc'   => 'Doc',
        'admin' => 'Admin',
        'test'  => 'Test',

    ),


    'UPLOAD_STRORAGE' => 'oss',// oss file   //存储方式，支持aliyun,file本地存储

    'test_proxy'           => '192.168.1.211:8888',

    /*		'DB_TYPE'=>'mysql',
            'DB_HOST'=>'localhost',
            'DB_PORT' => '3306',
            'DB_NAME'=>'xuexi',
            'DB_USER'=>'root',
            'DB_PWD'=>'123456',
            'DB_PREFIX'=>'',*/


    //缓存类型
    'SHOW_PAGE_TRACE'      => (strpos(I('server.HTTP_USER_AGENT'), 'GuzzleHttp') === false),
    'FIRE_SHOW_PAGE_TRACE' => true,
    'TRACE_PAGE_TABS'      => array(
        'sql'   => 'SQL',
        'file'  => '文件',
        'error' => '错误',

        //'base'=>'基本',
        //'think'=>'流程',
        //'debug'=>'调试'
    ),
);