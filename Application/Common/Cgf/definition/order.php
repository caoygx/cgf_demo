<?php
//base为相当于基类
//list,add,edit,search可继承覆盖
return [
    //字段基础信息定义，list,add,edit,search中如果有对应的字段，由对应的字段信息与base合并
    'base' => [

        //订单相关
        'id'          => [
            'zh' => '编号',
        ],
        'create_t'    => [
            'zh' => '订单时间'
        ],
        'openid'      => [
            'zh' => '三方id',
        ],
        'order_id'    => [
            'zh' => '订单号'
        ],
        'goods_id'    => [
            'zh' => '商品ID',
        ],
        'goods_name'  => [
            'zh' => '订单商品名称',
        ],
        'status'      => [
            'zh'        => '订单状态',
            'show_text' => 'status_text',
            'type'      => 'select',
            'options'   => [
                0 => '默认',
                1 => '处理中',
                2 => '交易成功',
                3 => '交易失败',
            ],
        ],


        //商品相关
        'name'        => ['zh' => '商品名'],
        'thumb'       => [
            'zh'   => '商品图',
            'type' => 'img',
            'tpl_function' => 'show_img()',
        ],
        'type'        => [
            'zh'      => '商品类型',
            'show_text' => 'type_text',
            'type'    => 'select',
            'options' => [
                0 => '实物',
                1 => '虚拟卡',
                2 => '手机卡',
            ]],


        //商品分类相关
        'title'       => [
            'zh' => '商品分类',
        ],


        //用户相关
        'realname'    => ['zh' => '姓名'],
        'user_type'   => [
            'zh'        => '用户类型',
            'show_text' => 'user_type_text',
            'type'      => 'select',
            'options'   => [
                0 => '普通会员',
                1 => '铜牌会员',
                2 => '银牌会员',
                3 => '金牌会员',
            ],
        ],
        'status_flag' => [
            'zh'        => '用户状态',
            'show_text' => 'status_flag_text',
            'type'      => 'select',
            'options'   => [
                0 => '禁用',
                1 => '正常'
            ]
        ],
        'ch'          => ['zh' => '渠道'],
        'memberno'    => ['zh' => '会员号'],
        'address'     => ['zh' => '地址'],
        'mobile'      => [
            'zh' => '手机'
        ],

        //快递相关
        'company'     => ['zh' => '快递公司'],
        'express_no'  => ['zh' => '快递单号'],
        'express_id'  => ['zh' => '快递id'],

    ],


    //公用列表
    'list' => [
        'id'          => [],


        'order_id'    => [],
        'goods_id'    => [],
        'goods_name'  => [],
        'name'        => [],
        'type'        => [],

        'openid'      => [],

        'title'       => [],
        'thumb'       => [],
        'status'      => [],
        'user_type'   => [],
        'ch'          => [],
        'memberno'    => [],
        'address'     => [],
        'mobile'      => [],
        'realname'    => [],


        'company'     => [],
        'express_id'  => [],
        'express_no'  => ['zh' => '快递单号'],

        'create_t'    => [],
    ],


    'edit' => [
        'goods_name' => [
            'type'       => 'text',
            'size'       => 10,
            'validation' => 'mobile-unique',
        ],
        'content'        => [
            'type'      => 'editor',
            'size'      => 10,
            'component' => 'fck',//编辑器组件 kindeditor
        ],
        'create_t'       => [
            'type'   => 'datetimePicker',//时间
            'format' => 'y-m-d H:i:s',
        ],
        'draw_state'     => [
            'type'    => 'select',
            'options' => [
                0 => '未中奖',
                1 => '已中奖'
            ],
        ],
        'memberno'       => [
            'type' => 'text',
        ]
    ],

    'add' => [
        'act_goods_name' => [
            'type' => 'text',
        ],
        'create_t'       => [
            'type'   => 'datetimePicker',//时间
            'format' => 'y-m-d H:i:s',
        ],
        /* 'ch' => [
             'type' => 'select',//文件上传
         ],*/
        'draw_state'     => [
            'type'    => 'select',
            'options' => [
                0 => '未中奖',
                1 => '已中奖'
            ],
        ],
        'memberno'       => [
            'type' => 'text',
        ]
    ],

    'search' => [
        //商品名
        'user_type' => [

            'size' => 10,
            'zh'   => '用户类型',
        ],

        'goods_name' => [],
        'ch'         => ['type' => 'text',],
        'status'     => [],
        'memberno'   => [
            'zh'   => '会员号',
            'type' => 'text',
        ],

    ],

    'module' => [
        'admin' => [
            "add"  => ['user_id' => []],
            "edit" => ['user_id' => []],
            "list" => ['user_id' => []],

        ],
        'user'  => [
            "list" => ['user_id' => []]
        ],
        'home'  => [
            "list" => ['user_id' => []]
        ],
    ],

    'tableInfo' =>
        array(
            'title'    => '用户',
            'property' => 'lock',
            'action'   => 'edit:取消:id,view:查看:order_id',
            'name'     => 'pm_user',
        ),
];
