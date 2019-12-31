<?php
namespace Common;
class JsonCheck{
    static $fun_return = [];
    static $user_id = 1;


// curl 组合参数访问接口
    public static function request_by_curl_bat($api, $host = "",$show_form = true){
        empty($host) && $host = URL_API;
        if(substr($api['url'], 0,4) != "http"){
            $url = $host . $api['url'];
        }else{
            $url = $api['url'];
        }
        if(! isset($api['get'])) {
            $api['get'] = 1;
        }
        if(!is_array($api['param_json'])){
            $api['param_json'] = json_decode($api['param_json'],true);
        }
        $method = $api['get'] ? "GET" : "POST";
        $parms = $api['param_json'];
        $parms['ret_format']='json';
        foreach ($parms as $k => &$v){
            if(strpos($v,'function') !== false){
                $func = explode('|',$v)[1];
                $cAutotest = A('Autotest');
                $value = call_user_func_array(array($cAutotest, $func),[$parms]);//param , array("three", "four")
                $v = $value;
            }

            if(I($k)){
                $v = I($k);
            }
        }
        if(empty($parms['user_id']))    $parms['user_id'] = self::$user_id;

        //echo LF;

        self::$fun_return = [];
        $text = $api['title'].":".$api['url'];
        $url_text =  $text;
        $parms_text = json_encode($parms,JSON_UNESCAPED_UNICODE);
        self::$fun_return['url'] = $url_text;
        self::$fun_return['params'] = $parms_text;
        //echo_color("url: ".$text, "MAGENTA", 0);echo LF;
        //echo_color("params: ".json_encode($parms,JSON_UNESCAPED_UNICODE), "LIGHT_BLUE", 0); echo LF;


        $id = $api['id'];
        $ret = curl_get_content($url, $parms, $api['get']);
        $ret = json_decode($ret,true);
        if(json_last_error() != JSON_ERROR_NONE){

            self::$fun_return['error_msg'][] = '实际返回的json 解析错误';
            return self::$fun_return;
        }

        $showDetails = false;
        if($showDetails){
            echo $api['title'], ":", $api['url'], LF;
            if($ret['code'] != 1){
                $text = "para : ".var_export($parms,1).LF."ret : ".var_export($ret,1);
                echo_color($text, "FAILURE", 1);
                echo LF,LF;
            }else{
                //echo_color("成功".LF,"GREEN");
                $text = "para : ".var_export($parms,1).LF."ret : ".var_export($ret,1);
                echo_color($text, "SUCCESS", 1);
                echo LF,LF;
            }
        }else{

            $text = "";
            if(!empty($ret['http_code'])){
                self::$fun_return['error_msg'][] ="[http_status:{$ret['http_code']} $method] ".$text."    ".$ret['data'];
                return self::$fun_return;
                /*echo_color("[http_status:{$ret['http_code']} $method] ".$text."    ".$ret['data'], "RED");
                echo '-----------------------------------------------url 500 错误-----------------------------------------------------------------';*/
            }else{
                //if($ret['code'] != 1){}
                //echo_color("[http_status:200 $method  id:$id] ".$text, "GREEN");
            }
            // echo LF;
        }


        $return_json = $api['return_json'];
        //var_dump($return_json);exit;
        $return_json = json_decode($return_json,1);
        if(json_last_error() != JSON_ERROR_NONE){
            self::$fun_return['error_msg'][] = '期望返回json格式 解析错误';
            return self::$fun_return;
        }

        $ret_data = $ret;
        if(!empty($return_json) && is_array($return_json) && !empty($ret_data) && is_array($ret_data)){
            self::check_ecursive_cli($return_json, $ret_data);
        }
        return self::$fun_return;
    }


    public static  function check_ecursive_cli($return_json, $ret, $prve_key = ''){
        foreach($return_json as $k => $v) {
            if(is_array($v)) {
                self::check_ecursive_cli($v, $ret[$k], $prve_key . "." . $k);
            } else {
                if(!array_key_exists($k,$ret)  ) {

                    self::$fun_return['error_msg'][] = $prve_key.'.'.$k."--".var_export($ret[$k],1)."--"."   >>>   has error";
                   /* echo_color("    $prve_key.{$k} : ", "BROWN");
                    echo_color( var_export($ret[$k],1), "RED");
                    echo_color("   >>>   has error", "RED");
                    echo LF;*/
                    if($v === "not null") {
                        self::$fun_return['error_msg'][] = "$k 不能为空";
                        //echo "$k 不能为空";
                    }


                }elseif($ret[$k] === ''){
                    if(C('show_test_waring')){
                        $text = "$prve_key.{$k}  is empty string";
                        self::$fun_return['warning_msg'][] = $text;
                        echo_color($text, "BROWN");
                        echo LF;
                    }
                }elseif(is_null($ret[$k])){
                    if(C('show_test_waring')){
                        $text = "$prve_key.{$k}  is null";
                        self::$fun_return['warning_msg'][] = $text;
                        echo_color($text, "BROWN");
                        echo LF;

                    }
                }elseif($ret[$k] === '0'){
                    if(C('show_test_waring')){
                        $text = "$prve_key.{$k}  is 0 ";
                        self::$fun_return['warning_msg'][] = $text;
                        echo_color($text, "BROWN");
                        echo LF;

                    }
                }
            }
        }
    }

}