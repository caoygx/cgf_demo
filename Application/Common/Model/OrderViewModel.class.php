<?php

namespace Common\Model;

use  Think\Model\ViewModel;

class OrderViewModel extends ViewModel
{
    public $viewFields = array(
        'Order' => ['_as' => 'o', '_type' => 'LEFT', '*'],



        'User'    => ['memberno', 'ch' => 'user_ch', 'address', 'mobile', 'realname', 'status_flag', '_as' => 'u', '_on' => 'o.openid = u.openid', '_type' => 'LEFT'],

        'Goods' => ['_as' => 'g', '_type' => 'LEFT', '_on' => 'o.goods_id = g.id',
            'name', 'thumb', 'type'],

        'Category' => ['_as' => 'c', '_type' => 'LEFT', '_on' => 'g.category_id = c.id', 'title'],

        'Express' => ['_as' => 'e', '_on' => 'o.order_id = e.order_id', '_type' => 'LEFT', 'id'=>'express_id','express_no','company'],


    );


}


