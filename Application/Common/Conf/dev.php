<?php
return array(

    'UPLOAD_STRORAGE' => 'file',// oss file   //存储方式，支持aliyun,file本地存储

    'test_proxy' => '192.168.16.16:8888',

    'DB_TYPE'   => 'mysql',
    'DB_HOST'   => '127.0.0.1',
    'DB_PORT'   => '3306',
    'DB_NAME'   => 'cgf_demo',
    'DB_USER'   => 'cgf_demo',
    'DB_PWD'    => 'cgf_demopwd888',
    'DB_PREFIX' => 'cgf_',

    'log_db' => [
        'DB_TYPE'    => 'mysql',     // 数据库类型
        'DB_HOST'    => 'localhost', // 服务器地址
        'DB_NAME'    => 'log',          // 数据库名
        'DB_USER'    => 'cgf_demo',      // 用户名
        'DB_PWD'     => 'cgf_demopwd888',          // 密码
        'DB_PORT'    => '3306',        // 端口
        'DB_PREFIX'  => '',    // 数据库表前缀
        'DB_CHARSET' => 'utf8',      // 数据库编码默认采用utf8
        'DB_PARAMS'  => array(
            \PDO::ATTR_TIMEOUT => 2,
            \PDO::ATTR_CASE    => \PDO::CASE_NATURAL, //字段使用原始的大写
        ),
    ],


    'REDIS_HOST'           => '127.0.0.1',
    'REDIS_PORT'           => 7380,
    'REDIS_PASSWORD'       => '58f6c40c3ab78ea48909885c',
    'DATA_CACHE_TIMEOUT'   => false,

    //'REDIS_HOST'       =>  'r-bp16af1cba4d92e4.redis.rds.aliyuncs.com',
    //'REDIS_PORT'       =>  6379,
    'REDIS_PASSWORD'       => '58f6c40c3ab78ea48909885c',
    'DATA_CACHE_TIMEOUT'   => false,

    //'persistent' => false,


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