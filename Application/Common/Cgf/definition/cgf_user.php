<?php 
 return array (
  'base' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'hidden',
      'size' => 10,
      'zh' => 'id',
      'showPage' => '1111',
      'rawOption' => NULL,
    ),
    'openid' => 
    array (
      'name' => 'openid',
      'type' => 'text',
      'size' => 30,
      'zh' => 'openid',
      'showPage' => '3',
      'rawOption' => NULL,
    ),
    'password' => 
    array (
      'name' => 'password',
      'type' => 'text',
      'size' => 30,
      'zh' => '',
      'showPage' => '0',
      'rawOption' => NULL,
    ),
    'nickname' => 
    array (
      'name' => 'nickname',
      'type' => 'text',
      'size' => 30,
      'zh' => '昵称',
      'rawOption' => NULL,
    ),
    'gender' => 
    array (
      'name' => 'gender',
      'type' => 'text',
      'size' => 10,
      'zh' => '',
      'showPage' => '0',
      'rawOption' => NULL,
    ),
    'birthday' => 
    array (
      'name' => 'birthday',
      'type' => 'datePicker',
      'size' => 10,
      'zh' => '生日',
      'showPage' => '0',
      'rawOption' => NULL,
    ),
    'mobile' => 
    array (
      'name' => 'mobile',
      'type' => 'text',
      'size' => 30,
      'zh' => '手机',
      'showPage' => '3',
      'rawOption' => NULL,
    ),
    'avatar' => 
    array (
      'name' => 'avatar',
      'type' => 'img',
      'size' => 30,
      'zh' => '图像',
      'showPage' => '0010',
      'checkType' => '',
      'options' => '',
      'rawOption' => '',
      'tpl_function' => 'show_img()',
    ),
    'ch' => 
    array (
      'name' => 'ch',
      'type' => 'text',
      'size' => 30,
      'zh' => '用户渠道',
      'showPage' => '0010',
      'rawOption' => NULL,
    ),
    'deviceid' => 
    array (
      'name' => 'deviceid',
      'type' => 'text',
      'size' => 30,
      'zh' => '设备id',
      'showPage' => '0011',
      'rawOption' => NULL,
    ),
    'address' => 
    array (
      'name' => 'address',
      'type' => 'textarea',
      'row' => 10,
      'zh' => '地址',
      'showPage' => '0010',
      'rawOption' => NULL,
    ),
    'realname' => 
    array (
      'name' => 'realname',
      'type' => 'text',
      'size' => 30,
      'zh' => '姓名',
      'rawOption' => NULL,
    ),
    'balance' => 
    array (
      'name' => 'balance',
      'type' => 'text',
      'size' => 10,
      'zh' => '余额',
      'showPage' => '1110',
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
    'login_time' => 
    array (
      'name' => 'login_time',
      'type' => 'text',
      'size' => 10,
      'zh' => '登录时间',
      'showPage' => '0',
      'checkType' => '',
      'options' => '',
      'rawOption' => '',
      'function' => 'date("y-m-d h:i:s",###)',
    ),
    'platform' => 
    array (
      'name' => 'platform',
      'type' => 'select',
      'size' => 10,
      'zh' => '平台',
      'showPage' => '0011',
      'checkType' => '',
      'options' => 
      array (
        1 => 'android',
        2 => 'iOS',
      ),
      'rawOption' => '1:android,2:iOS',
      'show_text' => 'platform_text',
    ),
    'ip' => 
    array (
      'name' => 'ip',
      'type' => 'text',
      'size' => 30,
      'zh' => 'ip',
      'showPage' => '0011',
      'rawOption' => NULL,
    ),
    'area' => 
    array (
      'name' => 'area',
      'type' => 'text',
      'size' => 30,
      'zh' => '区域',
      'showPage' => '2',
      'rawOption' => NULL,
    ),
    'memberno' => 
    array (
      'name' => 'memberno',
      'type' => 'text',
      'size' => 30,
      'zh' => '会员编号',
      'showPage' => '0011',
      'rawOption' => NULL,
    ),
    'status_flag' => 
    array (
      'name' => 'status_flag',
      'type' => 'text',
      'size' => 10,
      'zh' => '用户状态',
      'showPage' => '0010',
      'checkType' => '',
      'options' => 
      array (
        0 => '禁用',
        1 => '正常',
      ),
      'rawOption' => '0:禁用,1:正常',
      'show_text' => 'status_flag_text',
    ),
    'update_time' => 
    array (
      'name' => 'update_time',
      'type' => 'time',
      'zh' => '更新时间',
      'showPage' => '0',
      'rawOption' => NULL,
    ),
  ),
  'add' => 
  array (
    'id' => 
    array (
    ),
    'nickname' => 
    array (
    ),
    'realname' => 
    array (
    ),
    'balance' => 
    array (
    ),
  ),
  'edit' => 
  array (
    'id' => 
    array (
    ),
    'nickname' => 
    array (
    ),
    'realname' => 
    array (
    ),
    'balance' => 
    array (
    ),
  ),
  'list' => 
  array (
    'id' => 
    array (
    ),
    'openid' => 
    array (
    ),
    'nickname' => 
    array (
    ),
    'mobile' => 
    array (
    ),
    'avatar' => 
    array (
    ),
    'ch' => 
    array (
    ),
    'deviceid' => 
    array (
    ),
    'address' => 
    array (
    ),
    'realname' => 
    array (
    ),
    'balance' => 
    array (
    ),
    'modify_t' => 
    array (
    ),
    'platform' => 
    array (
    ),
    'ip' => 
    array (
    ),
    'area' => 
    array (
    ),
    'memberno' => 
    array (
    ),
    'status_flag' => 
    array (
    ),
  ),
  'search' => 
  array (
    'id' => 
    array (
    ),
    'openid' => 
    array (
    ),
    'nickname' => 
    array (
    ),
    'mobile' => 
    array (
    ),
    'deviceid' => 
    array (
    ),
    'realname' => 
    array (
    ),
    'platform' => 
    array (
    ),
    'ip' => 
    array (
    ),
    'memberno' => 
    array (
    ),
  ),
  'tableInfo' => 
  array (
    'title' => '用户',
    'property' => '',
    'action' => 'edit:编辑:id,view_recharge:查看充值记录:openid',
    'pageButton' => 
    array (
    ),
    'name' => 'cgf_user',
  ),
);