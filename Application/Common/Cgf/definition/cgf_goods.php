<?php 
 return array (
  'base' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'hidden',
      'size' => 10,
      'zh' => 'ID',
      'rawOption' => NULL,
    ),
    'name' => 
    array (
      'name' => 'name',
      'type' => 'text',
      'size' => 30,
      'zh' => '商品名',
      'rawOption' => NULL,
    ),
    'price' => 
    array (
      'name' => 'price',
      'type' => 'text',
      'size' => 10,
      'zh' => '市场价',
      'rawOption' => NULL,
    ),
    'orgial_price' => 
    array (
      'name' => 'orgial_price',
      'type' => 'text',
      'size' => 10,
      'zh' => '原价',
      'rawOption' => NULL,
    ),
    'pur_price' => 
    array (
      'name' => 'pur_price',
      'type' => 'text',
      'size' => 10,
      'zh' => '成本',
      'rawOption' => NULL,
    ),
    'thumb' => 
    array (
      'name' => 'thumb',
      'type' => 'image',
      'size' => 30,
      'zh' => '缩略图',
      'showPage' => '1110',
      'checkType' => '',
      'options' => '',
      'rawOption' => '',
      'tpl_function' => 'show_img()',
    ),
    'status' => 
    array (
      'name' => 'status',
      'type' => 'select',
      'size' => 10,
      'zh' => '状态',
      'showPage' => '1111',
      'checkType' => '',
      'options' => 
      array (
        0 => '上架',
        1 => '下架',
      ),
      'rawOption' => '0:上架,1:下架',
      'show_text' => 'status_text',
    ),
    'sort' => 
    array (
      'name' => 'sort',
      'type' => 'text',
      'size' => 10,
      'zh' => '商品排序',
      'rawOption' => NULL,
    ),
    'user_id' => 
    array (
      'name' => 'user_id',
      'type' => 'text',
      'size' => 10,
      'zh' => '用户id',
      'rawOption' => NULL,
    ),
    'weight' => 
    array (
      'name' => 'weight',
      'type' => 'text',
      'size' => 10,
      'zh' => '重量',
      'rawOption' => NULL,
    ),
    'type' => 
    array (
      'name' => 'type',
      'type' => 'select',
      'size' => 10,
      'zh' => '类型',
      'showPage' => '1111',
      'checkType' => '',
      'options' => 
      array (
        0 => '普通商品',
        1 => '会员充值',
        2 => '话费充值',
      ),
      'rawOption' => '0:普通商品,1:会员充值,2:话费充值',
      'show_text' => 'type_text',
    ),
    'category_id' => 
    array (
      'name' => 'category_id',
      'type' => 'text',
      'size' => 10,
      'zh' => '商品分类',
      'rawOption' => NULL,
    ),
    'intro' => 
    array (
      'name' => 'intro',
      'type' => 'editor',
      'row' => 10,
      'zh' => '商品介绍',
      'showPage' => '1100',
      'rawOption' => NULL,
    ),
    'create_t' => 
    array (
      'name' => 'create_t',
      'type' => 'text',
      'size' => 10,
      'zh' => '创建时间',
      'showPage' => '0',
      'checkType' => '',
      'options' => '',
      'rawOption' => '',
      'function' => 'date("y-m-d h:i:s",###)',
    ),
    'modify_t' => 
    array (
      'name' => 'modify_t',
      'type' => 'text',
      'size' => 10,
      'zh' => '修改时间',
      'showPage' => '2',
      'checkType' => '',
      'options' => '',
      'rawOption' => '',
      'function' => 'date("y-m-d h:i:s",###)',
    ),
  ),
  'add' => 
  array (
    'id' => 
    array (
    ),
    'name' => 
    array (
    ),
    'price' => 
    array (
    ),
    'orgial_price' => 
    array (
    ),
    'pur_price' => 
    array (
    ),
    'thumb' => 
    array (
    ),
    'status' => 
    array (
    ),
    'sort' => 
    array (
    ),
    'user_id' => 
    array (
    ),
    'weight' => 
    array (
    ),
    'type' => 
    array (
    ),
    'category_id' => 
    array (
    ),
    'intro' => 
    array (
    ),
  ),
  'edit' => 
  array (
    'id' => 
    array (
    ),
    'name' => 
    array (
    ),
    'price' => 
    array (
    ),
    'orgial_price' => 
    array (
    ),
    'pur_price' => 
    array (
    ),
    'thumb' => 
    array (
    ),
    'status' => 
    array (
    ),
    'sort' => 
    array (
    ),
    'user_id' => 
    array (
    ),
    'weight' => 
    array (
    ),
    'type' => 
    array (
    ),
    'category_id' => 
    array (
    ),
    'intro' => 
    array (
    ),
  ),
  'list' => 
  array (
    'id' => 
    array (
    ),
    'name' => 
    array (
    ),
    'price' => 
    array (
    ),
    'orgial_price' => 
    array (
    ),
    'pur_price' => 
    array (
    ),
    'thumb' => 
    array (
    ),
    'status' => 
    array (
    ),
    'sort' => 
    array (
    ),
    'user_id' => 
    array (
    ),
    'weight' => 
    array (
    ),
    'type' => 
    array (
    ),
    'category_id' => 
    array (
    ),
    'modify_t' => 
    array (
    ),
  ),
  'search' => 
  array (
    'id' => 
    array (
    ),
    'name' => 
    array (
    ),
    'price' => 
    array (
    ),
    'orgial_price' => 
    array (
    ),
    'pur_price' => 
    array (
    ),
    'status' => 
    array (
    ),
    'sort' => 
    array (
    ),
    'user_id' => 
    array (
    ),
    'weight' => 
    array (
    ),
    'type' => 
    array (
    ),
    'category_id' => 
    array (
    ),
  ),
  'tableInfo' => 
  array (
    'title' => '商品表',
    'property' => '',
    'action' => 'edit:编辑:id,del:删除:id',
    'sort' => 
    array (
      0 => 'create_time',
      1 => 'desc',
    ),
    'pageButton' => 
    array (
      0 => 'export',
      1 => 'showMenu',
    ),
    'function' => NULL,
    'name' => 'cgf_goods',
  ),
);