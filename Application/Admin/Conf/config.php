<?php
return array(
    'URL_MODEL'         => 2,
    'AUTH_STORE_WAY'    => "session",
    'LAYOUT_ON'         => true,
    'VAR_SESSION_ID'    => 'session_id',    //修复uploadify插件无法传递session_id的bug

    //如果父配置有相同的一级key会覆盖，二维的key没影响。
    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => '/Public',
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

    'menu' => [
        [
            'title'    => "订单相关",
            'url'      => '',
            'children' => [
                ["title" => '商品管理', "url" => '/admin/goods/'],
                ["title" => '订单管理', "url" => '/admin/order/'],
                ["title" => '快递', "url" => '/admin/express'],

            ]
        ],
        [
            'title'    => "用户",
            'url'      => '',
            'children' => [
                ["title" => '用户管理', "url" => '/admin/user'],
                ["title" => '用户访问记录', "url" => '/admin/logRequest'],

            ]
        ],
        [
            'title'    => "系统",
            'url'      => '',
            'children' => [
                ["title" => '编辑器', "url" => '/admin/index/editor'],
                ["title" => '网页截图', "url" => '/admin/slimer/'],
                ["title" => '清除缓存', "url" => '/admin/system/delRuntimeTemp/'],
                ["title" => '生成公众号url', "url" => '/admin/system/generateWeixinUrl/'],
            ]
        ],
    ]
);
