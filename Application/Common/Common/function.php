<?php

function course_user_id($value,$key,$v){
    $user_id = $v['user_id'];
    if(MODULE_NAME!='Admin'){
        return $user_id;
    }
    $url = "/user?id=$user_id";
    $url = "<a href='{$url}' target='_blank' >$user_id</a>";
    return $url;
}

function order_course_title($title,$key,$v){
    //var_dump($title,$v,$c);
    $title = $v['course_title'];
    if(MODULE_NAME!='Admin'){
        return $title;
    }
    $url = "http://www.rrbrr.com/course/{$v['course_id']}";
    $url = "<a href='{$url}' target='_blank' title='{$title}'>$title</a>";
    return $url;
}

function refer_refer_url($url,$key,$v){
    $url = $v['url'];
    //$a = "http://wap.sogou.com/waprdt?query=%D1%A7%CF%B0%C3%C0%BC%D7&clickid=1034a47bd2cda5684309c0ee6a9db69a";
    $old_url = $url;
    $url = urldecode($url);
    $encode = mb_detect_encoding($url, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
    if(strtolower($encode) != 'utf-8'){
        $url = mb_convert_encoding($url, "UTF-8",$encode);
    }
    $title = substr($url,0,75);
    $url = "<a href='{$old_url}' target='_blank' title='{$title}'>$title</a>";
    return $url;


    //iconv("UTF-8,"GBK"",urldecode("%CB%D1%BA%FC%CD%C5%B9%BA%B5%BC%BA%BD"));
}

function refer_ip($value,$key,$v){
    $value = $v['ip'];
    $url = "/logRequest?ip={$value}&_order=id&_sort=asc";
    $url = "<a href='{$url}' target='_blank' title='查看用户浏览记录' >$value</a>";
    return $url;

}

function rand_avatar(){
    $index = mt_rand(1,1370);
    return "avatar/system/{$index}.gif";
}

/**
 * 增加队列消息 各controller只有删除自己的队列
 * @param string $module
 * @param string $controller
 * @param string $action
 * @param array $parameter
 */
function addQueue(string $module,string $controller,string $action,array $parameter){
    //加入访问历史
    $qMsg = [];
    $qMsg['module'] = $module;
    $qMsg['controller'] = $controller;
    $qMsg['action'] = $action;
    $qMsg['parameter'] = $parameter;
    $qMsg = json_encode($qMsg);
    $data["message"] = $qMsg;
    D("Queue")->add($data);
}

/**
 * To send alarm when program error
 * @param $content
 */
function alarm($content){
    $qHistoryMsgParameter = [
        "content" => $content,
    ];
    addQueue("Admin","System","alarm",$qHistoryMsgParameter);
}

function findTestConfByUrl($url){
	$testConf = C("test");
	$ret = array();
	foreach($testConf as $k => $v) {
		if($v['url'] == $url) {
			$ret[] = $v;
		}
	}
	return $ret;
	// var_dump($testConf);
}

// curl 访问接口
function request_by_curl($api, $host = "",$show_form = true){
	empty($host) && $host = URL_API;
	echo $api['title'], ":", $api['url'], LF;
	if(substr($api['url'], 0,4) != "http"){
		$url = $host . $api['url'];
	}else{
		$url = $api['url'];
	}
	
	if(!is_array($api['data'])){
		$api['data'] = json_decode($api['param_json'],1);
	}
	$method = $api['method'];
	if($show_form){
	echo '<form id="form1" name="form1" method="' . $method . '" enctype="multipart/form-data" action="' . $url . '" target="_blank">';
	echo "<table>";
	foreach($api['data'] as $k => $v) {
		if(is_array($v)) {
			if($v['type'] == "file")
				echo "<tr><td>$k : </td><td><input multiple type='file' name = '$k' value='{$v['value']}'></td> </tr>";
		} else {
			echo "<tr><td>$k : </td><td><input type='text' name = '$k' value='$v'></td> </tr>";
		}
	}
        echo "<tr><td> </td><td><input type='hidden' name = 'ret_format' value='json'></td> </tr>";
	echo "</table>";
	echo '<input type="submit" name="button"   value="提交" id="send" /><br /></form>';
	$errors = array();
        $api['data']['ret_format']='json';
	$ret = curl_get_content($url, $api['data'], $method);
	echo <<<HTML
	
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<div>
<a onclick="show(this)" style="cursor:pointer; color:blue;" >显示隐藏返回结果</a>
<div style="display:none; color:#c96;">$ret</div>
</div>
<script>
function show(self){
	$(self).parent().children("div").toggle();
	
}
</script>
HTML;
	
	}
	$ret = json_decode($ret, true);
	// var_dump($ret);exit('xx');
	if(! empty($api['return_json'])) {
		$return_json = $api['return_json'];
		// var_dump($return_json);
		if(empty($ret)) {
			echo '<span style="color:#f00">无数据</span>', LF;
		}
		if(! is_array($return_json)) {
			$return_json = json_decode($return_json, true);
		}

		if(empty($return_json)) {
			echo "返回格式解析结果为空" . LF;
			return;
		}
		// var_dump($return_json);
		check_ecursive($return_json, $ret);
		// array_walk_recursive($return_json,"check");
		/*
		 * foreach ($return_json as $k => $v){ if(empty($ret[$k])){ $errors[$k] = "is null"; } }
		 */
	} else {
		echo "返回格式不能为空 <hr />" . LF;
		return $ret;
	}
	echo "测试完毕 <hr /><br /><br />";
	return $ret;
}




// curl 组合参数访问接口
function request_by_curl_parameter_combination($api, $host = "",$show_form = true){
	empty($host) && $host = URL_API;
	echo $api['title'], ":", $api['url'], LF;
	if(substr($api['url'], 0,4) != "http"){
		$url = $host . $api['url'];
	}else{
		$url = $api['url'];
	}
	if(! isset($api['get'])) {
		$api['get'] = 1;
	}
	if(!is_array($api['data'])){
		$api['data'] = json_decode($api['data'],true);
	}
	
	$method = $api['get'] ? "get" : "post";
	
	$parameter = $api['data'];
	$arr = array_keys($api['data']);
	$n = count($arr);
	$allCombination = array();
	for($i = 1; $i <= $n; $i ++) {
		$t = getCombinationToString($arr, $i);
		$allCombination = array_merge($allCombination, $t);
	}
	
	
	//ob_end_flush();
	foreach ($allCombination as $k => $v ){
		$parms = explode(',', $v);
		$newParms = array();
		foreach ($parms as $k => $v){
			$newParms[$v] = $parameter[$v];
		}
		$parms = $newParms;
		$ret = curl_get_content($url, $parms, $api['get']);
		 $ret = json_decode($ret,true);
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
		
		/* if($k > 10){
			exit('x');
		} */	
	}
	$ret = json_decode($ret, true);
	// var_dump($ret);exit('xx');
	if(! empty($api['return_json'])) {
		$return_json = $api['return_json'];
		// var_dump($return_json);
		if(empty($ret)) {
			echo '<span style="color:#f00">无数据</span>', LF;
		}
		if(! is_array($return_json)) {
			$return_json = json_decode($return_json, true);
		}

		if(empty($return_json)) {
			echo "返回格式解析结果为空" . LF;
			return;
		}
		// var_dump($return_json);
		check_ecursive($return_json, $ret);
		// array_walk_recursive($return_json,"check");
		/*
		 * foreach ($return_json as $k => $v){ if(empty($ret[$k])){ $errors[$k] = "is null"; } }
		*/
	} else {
		echo "返回格式不能为空 <hr />" . LF;
		return $ret;
	}
	echo "测试完毕 <hr /><br /><br />";
	return $ret;
}



global $fun_return;
$fun_return =[];

// curl 组合参数访问接口
function request_by_curl_bat($api, $host = "",$show_form = true){
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
    //echo LF;

    global $fun_return;
    $fun_return = [];
    $text = $api['title'].":".$api['url'];
    $url_text =  $text;
    $parms_text = json_encode($parms,JSON_UNESCAPED_UNICODE);
    $fun_return['url'] = $url_text;
    $fun_return['params'] = $parms_text;
    //echo_color("url: ".$text, "MAGENTA", 0);echo LF;
    //echo_color("params: ".json_encode($parms,JSON_UNESCAPED_UNICODE), "LIGHT_BLUE", 0); echo LF;



	$id = $api['id'];
	$ret = curl_get_content($url, $parms, $api['get']);
	$ret = json_decode($ret,true);
    if(json_last_error() != JSON_ERROR_NONE){

        $fun_return['error_msg'][] = '实际返回的json 解析错误';
        return $fun_return;
       /* echo $url_text;
        echo $parms_text;

        $text = '';
        echo_color($text, "FAILURE", 1);
        echo LF,LF;
        echo '---------------------------------------------------返回值解析错误-------------------------------------------------------------';
        return false;*/
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
            $fun_return['error_msg'][] ="[http_status:{$ret['http_code']} $method] ".$text."    ".$ret['data'];
            return $fun_return;
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
        $fun_return['error_msg'][] = '期望返回json格式 解析错误';
        return $fun_return;
    }

	/*switch (json_last_error()) {
		case JSON_ERROR_NONE:
			//echo '没有错误发生';
			break;
		case JSON_ERROR_DEPTH:
			echo '    return_json 到达了最大堆栈深度'.LF;
			break;
		case JSON_ERROR_STATE_MISMATCH:
			echo '    return_json 无效或异常的 JSON'.LF;
			break;
		case JSON_ERROR_CTRL_CHAR:
			echo '    return_json 控制字符错误，可能是编码不对'.LF;
			break;
		case JSON_ERROR_SYNTAX:
			echo '    return_json 语法错误'.LF;
			break;
		case JSON_ERROR_UTF8:
			echo '    return_json 异常的 UTF-8 字符，也许是因为不正确的编码。'.LF;
			break;
		default:
			echo '    return_json 未知错误'.LF;
			break;
	}*/
	$ret_data = $ret;
	if(!empty($return_json) && is_array($return_json) && !empty($ret_data) && is_array($ret_data)){
		check_ecursive_cli($return_json, $ret_data);
	}


    //echo LF;echo LF;
	return $ret;
}

function analysis_result($ret){
	$ret = '{"code":1}';
	
	$ret = json_decode($ret, true);
	 
	$return_json = '{
								  "count": 333,
								  "items": [
								    {
								      "id": "2143",

								      "name": "维多利亚"
								      
								    }
								  ]
								}';
	$return_json = json_decode($return_json,true);
	 check_ecursive_cli($return_json, $ret);
	
}


function check($item, $key){
	echo "$key holds $item\n";
}

function check_ecursive($return_json, $ret, $prve_key = ''){
	global $errors;
	
	foreach($return_json as $k => $v) {
		if(is_array($v)) {
			// var_dump($v);
			/*
			 * if(empty($prve_key)){ $prve_key = $k; }else{ $prve_key = $prve_key.".".$k; }
			 */
			// $prve_key = $prve_key.".".$k;
			check_ecursive($v, $ret[$k], $prve_key . "." . $k);
		} else {
			
			// $prve_key = str_replace($k, '', $prve_key);
			/*
			 * var_dump($ret); echo "<hr />";
			 */
			if(empty($ret[$k])) {
				echo '<span style="color:#f00">';
				echo "$prve_key.{$k} : ";
				var_dump($ret[$k]);
				echo "</span>";
				if($v === "not null") {
					// echo $v;
					echo "$k 不能为空";
				}
				echo LF;
			}
			/*
			 * if(!$v){ $errors[$k] = $ret[$k]; }
			 */
		}
		// var_dump($ret[$v]);
	}
	// $prve_key = substr(strrchr($prve_key, '.'), 1);
	/*
	 * var_dump($errors); foreach ($errors as $k => $v){ echo '<span style="color:#f00">',$k,":",$v,"</span>"; echo LF; }
	 */
}

function check_ecursive_cli($return_json, $ret, $prve_key = ''){
    global $fun_return;
    //global $checkResponseErrors,$checkResponseWarning;
    foreach($return_json as $k => $v) {
        if(is_array($v)) {
            check_ecursive_cli($v, $ret[$k], $prve_key . "." . $k);
        } else {
            if(!array_key_exists($k,$ret)  ) {

                $fun_return['error_msg'][] = $prve_key.$k."--".var_export($ret[$k],1)."--"."   >>>   has error";
                echo_color("    $prve_key.{$k} : ", "BROWN");
                echo_color( var_export($ret[$k],1), "RED");
                echo_color("   >>>   has error", "RED");
                echo LF;
                if($v === "not null") {
                    $fun_return['error_msg'][] = "$k 不能为空";
                    //echo "$k 不能为空";
                }


            }elseif(empty($ret[$k])){
                if(C('show_test_waring')){
                    $fun_return['warning_msg'][] = $prve_key.$k;
                    echo "waring \n";
                    echo_color("    $prve_key.{$k} : ", "BROWN");/**/
                }

            }
        }
    }
}

function encrypt_b($uid){
	$key = 'zb8964116sjts3dhe156ydsx';
	$iv = '1d3w6g8x';
	$pad = mcrypt_get_block_size("tripledes", "cbc") - (strlen($uid) % mcrypt_get_block_size("tripledes", "cbc"));
	$padded = $uid . str_repeat(chr($pad), $pad);
	$uid = @base64_encode(mcrypt_encrypt("tripledes", $key, $padded, "cbc", $iv));
	// $id = str_replace("+",chr(32),$uid);
	$id = str_replace(chr(32), "+", $uid);
	return $id;
}


/**
 * SOCKET扩展函数
 * 
 * @copyright (c) 2013
 * @author Qiufeng <fengdingbo@gmail.com>
 * @link http://www.fengdingbo.com
 * @version 1.0
 *         
 */

/**
 * Post Request
 *
 * @param string $url        	
 * @param array $data        	
 * @param string $referer        	
 * @return array
 *
 */
function socket_post($url, $data, $referer = ''){
	if(! is_array($data)) {
		return;
	}
	
	$data = http_build_query($data);
	$url = parse_url($url);
	
	if(! isset($url['scheme']) || $url['scheme'] != 'http') {
		die('Error: Only HTTP request are supported !');
	}
	
	$host = $url['host'];
	$path = isset($url['path']) ? $url['path'] . '?' . $url['query'] : '/';
	
	// open a socket connection on port 80 - timeout: 30 sec
	$fp = fsockopen($host, 80, $errno, $errstr, 30);
	
	if($fp) {
		// send the request headers:
		$length = strlen($data);
		$POST = <<<HEADER
POST {$path} HTTP/1.1
Host: {$host}
Accept: text/plain, text/html
Accept-Language: zh-CN,zh;q=0.8
Content-Type: application/x-www-form-urlencodem
Cookie: token=value; pub_cookietime=2592000; pub_sauth1=value; pub_sauth2=value
User-Agent: DaoxilaApp/2.0.0 (iPhone; iOS 8.1.2; Scale/2.00)
Content-Length: {$length}
Pragma: no-cache
Cache-Control: no-cache
Connection: close
Cookie: baJf_2132_forum_lastvisit=D_36_1423124866D_2_1423125031; baJf_2132_lastact=1423125486%09index.php%09register; baJf_2132_lastvisit=1423112308; baJf_2132_saltkey=g8d1xdd2; baJf_2132_sid=lscGh3; baJf_2132_st_p=0%7C1423115953%7C65172f6cb84ba1c9fba80eebe871fa65; baJf_2132_st_t=0%7C1423125031%7Cd1ca3eca1f07f48c87c3be3d7b29e257; baJf_2132_viewid=tid_6475; baJf_2132_visitedfid=2D36

{$data}
HEADER;
		// echo $POST;exit('x11111');
		fwrite($fp, $POST);
		$result = '';
		while(! feof($fp)) {
			// receive the results of the request
			$result .= fread($fp, 512);
		}
	} else {
		return array(
				'status' => 'error',
				'error' => "$errstr ($errno)" 
		);
	}
	
	// close the socket connection:
	fclose($fp);
	
	// split the result header from the content
	$result = explode("\r\n\r\n", $result, 2);
	
	// var_dump($host);
	
	// var_dump($path);
	// var_dump($result);exit('x');
	// return as structured array:
	return array(
			'status' => 'ok',
			'header' => isset($result[0]) ? $result[0] : '',
			'content' => isset($result[1]) ? $result[1] : '' 
	);
}

/*
 * print_r(socket_post('http://bbs.daoxila.com/api/dxlapp/index.php?module=register&version=4&is_app=1', array( "password" => '000000', 'password2' => '000000', 'userid' => 'WWsaW3WARvg', 'username' => 'Aaaaaa' )));
 */
function post_request($url, $data, $referer = ''){
	$data = http_build_query($data);
	$url = parse_url($url);
	if($url['scheme'] != 'http') {
		die('Error: Only HTTP request are supported !');
	}
	$host = $url['host'];
	$path = $url['path'];
	$fp = fsockopen($host, 80, $errno, $errstr, 30);
	if($fp) {
		$length = strlen($data);
		$POST = <<<HEADER
POST /api/dxlapp/index.php?module=register&version=4&is_app=1 HTTP/1.1
Host: $host
Accept: text/plain, text/html
Accept-Language: zh-CN,zh;q=0.8
Content-Type: application/x-www-form-urlencodem
Cookie: token=value; pub_cookietime=2592000; pub_sauth1=value; pub_sauth2=value
User-Agent: DaoxilaApp/2.0.0 (iPhone; iOS 8.1.2; Scale/2.00)
Content-Length: {$length}
Pragma: no-cache
Cache-Control: no-cache
Connection: close
Cookie: baJf_2132_forum_lastvisit=D_36_1423124866D_2_1423125031; baJf_2132_lastact=1423125486%09index.php%09register; baJf_2132_lastvisit=1423112308; baJf_2132_saltkey=g8d1xdd2; baJf_2132_sid=lscGh3; baJf_2132_st_p=0%7C1423115953%7C65172f6cb84ba1c9fba80eebe871fa65; baJf_2132_st_t=0%7C1423125031%7Cd1ca3eca1f07f48c87c3be3d7b29e257; baJf_2132_viewid=tid_6475; baJf_2132_visitedfid=2D36

$data
HEADER;
		/*
		 * POST {$path} HTTP/1.1 Host: {$host} Cookie: baJf_2132_forum_lastvisit=D_36_1423124866D_2_1423125031; baJf_2132_lastact=1423125486%09index.php%09register; baJf_2132_lastvisit=1423112308; baJf_2132_saltkey=g8d1xdd2; baJf_2132_sid=lscGh3; baJf_2132_st_p=0%7C1423115953%7C65172f6cb84ba1c9fba80eebe871fa65; baJf_2132_st_t=0%7C1423125031%7Cd1ca3eca1f07f48c87c3be3d7b29e257; baJf_2132_viewid=tid_6475; baJf_2132_visitedfid=2D36
		 */
			/*fputs($fp, "POST /api/dxlapp/index.php?module=register&version=4&is_app=1 HTTP/1.1\r\n");
			fputs($fp, "Host: $host\r\n");
			 if ($referer != '')
				fputs($fp, "Referer: $referer\r\n"); 
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ". strlen($data) ."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $data);*/
			fputs($fp, $POST);
		$result = '';
		while(! feof($fp)) {
			$result .= fgets($fp, 128);
		}
	} else {
		return array(
				'status' => 'err',
				'error' => "$errstr ($errno)" 
		);
	}
	
	// close the socket connection:
	fclose($fp);
	
	// split the result header from the content
	$result = explode("\r\n\r\n", $result, 2);
	
	$header = isset($result[0]) ? $result[0] : '';
	$content = isset($result[1]) ? $result[1] : '';
	
	// return as structured array:
	return array(
			'status' => 'ok',
			'header' => $header,
			'content' => $content 
	);
}
function _dfsockopen($url, $post = '', $cookie = '', $option = array()){
	extract($option, EXTR_SKIP);
	! isset($limit) && $limit = 0;
	! isset($bysocket) && $bysocket = FALSE;
	! isset($ip) && $ip = '';
	! isset($timeout) && $timeout = 15;
	! isset($block) && $block = TRUE;
	! isset($encodetype) && $encodetype = 'URLENCODE----';
	! isset($allowcurl) && $allowcurl = false;
	! isset($position) && $position = false;
	! isset($files) && $files = array();
	
	$return = '';
	$matches = parse_url($url);
	$scheme = $matches['scheme'];
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'] . ($matches['query'] ? '?' . $matches['query'] : '') : '/';
	$port = ! empty($matches['port']) ? $matches['port'] : ($scheme == 'http' ? '80' : '');
	$boundary = $encodetype == 'URLENCODE' ? '' : random(40);
	
	if($post) {
		if(! is_array($post)) {
			parse_str($post, $post);
		}
		_format_postkey($post, $postnew);
		$post = $postnew;
	}
	if(function_exists('curl_init') && function_exists('curl_exec') && $allowcurl) {
		$ch = curl_init();
		$httpheader = array();
		if($ip) {
			$httpheader[] = "Host: " . $host;
		}
		if($httpheader) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
		}
		curl_setopt($ch, CURLOPT_URL, $scheme . '://' . ($ip ? $ip : $host) . ($port ? ':' . $port : '') . $path);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		if($post) {
			curl_setopt($ch, CURLOPT_POST, 1);
			if($encodetype == 'URLENCODE') {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			} else {
				foreach($post as $k => $v) {
					if(isset($files[$k])) {
						$post[$k] = '@' . $files[$k];
					}
				}
				foreach($files as $k => $file) {
					if(! isset($post[$k]) && file_exists($file)) {
						$post[$k] = '@' . $file;
					}
				}
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			}
		}
		if($cookie) {
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		$data = curl_exec($ch);
		$status = curl_getinfo($ch);
		$errno = curl_errno($ch);
		curl_close($ch);
		if($errno || $status['http_code'] != 200) {
			return;
		} else {
			$GLOBALS['filesockheader'] = substr($data, 0, $status['header_size']);
			$data = substr($data, $status['header_size']);
			return ! $limit ? $data : substr($data, 0, $limit);
		}
	}
	if($post) {
		if($encodetype == 'URLENCODE') {
			$data = http_build_query($post);
		} else {
			$data = '';
			foreach($post as $k => $v) {
				$data .= "--$boundary\r\n";
				$data .= 'Content-Disposition: form-data; name="' . $k . '"' . (isset($files[$k]) ? '; filename="' . basename($files[$k]) . '"; Content-Type: application/octet-stream' : '') . "\r\n\r\n";
				$data .= $v . "\r\n";
			}
			foreach($files as $k => $file) {
				if(! isset($post[$k]) && file_exists($file)) {
					if($fp = @fopen($file, 'r')) {
						$v = fread($fp, filesize($file));
						fclose($fp);
						$data .= "--$boundary\r\n";
						$data .= 'Content-Disposition: form-data; name="' . $k . '"; filename="' . basename($file) . '"; Content-Type: application/octet-stream' . "\r\n\r\n";
						$data .= $v . "\r\n";
					}
				}
			}
			$data .= "--$boundary\r\n";
		}
		$out = "POST $path HTTP/1.0\r\n";
		$header = "Accept: */*\r\n";
		$header .= "Accept-Language: zh-cn\r\n";
		$header .= $encodetype == 'URLENCODE' ? "Content-Type: application/x-www-form-urlencoded\r\n" : "Content-Type: multipart/form-data; boundary=$boundary\r\n";
		$header .= 'Content-Length: ' . strlen($data) . "\r\n";
		$header .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$header .= "Host: $host:$port\r\n";
		$header .= "Connection: Close\r\n";
		$header .= "Cache-Control: no-cache\r\n";
		$header .= "Cookie: $cookie\r\n\r\n";
		$out .= $header;
		$out .= $data;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$header = "Accept: */*\r\n";
		$header .= "Accept-Language: zh-cn\r\n";
		$header .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$header .= "Host: $host:$port\r\n";
		$header .= "Connection: Close\r\n";
		$header .= "Cookie: $cookie\r\n\r\n";
		$out .= $header;
	}
	echo $out;
	$fpflag = 0;
	if(! $fp = fsocketopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout)) {
		$context = array(
				'http' => array(
						'method' => $post ? 'POST' : 'GET',
						'header' => $header,
						'content' => $post,
						'timeout' => $timeout 
				) 
		);
		$context = stream_context_create($context);
		$fp = @fopen($scheme . '://' . ($ip ? $ip : $host) . ':' . $port . $path, 'b', false, $context);
		$fpflag = 1;
	}
	
	if(! $fp) {
		return '';
	} else {
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
		if(! $status['timed_out']) {
			while(! feof($fp) && ! $fpflag) {
				$header = @fgets($fp);
				$headers .= $header;
				if($header && ($header == "\r\n" || $header == "\n")) {
					break;
				}
			}
			$GLOBALS['filesockheader'] = $headers;
			
			if($position) {
				for($i = 0; $i < $position; $i ++) {
					$char = fgetc($fp);
					if($char == "\n" && $oldchar != "\r") {
						$i ++;
					}
					$oldchar = $char;
				}
			}
			
			if($limit) {
				$return = stream_get_contents($fp, $limit);
			} else {
				$return = stream_get_contents($fp);
			}
		}
		@fclose($fp);
		return $return;
	}
}
function _format_postkey($post, &$result, $key = ''){
	foreach($post as $k => $v) {
		$_k = $key ? $key . '[' . $k . ']' : $k;
		if(is_array($v)) {
			_format_postkey($v, $result, $_k);
		} else {
			$result[$_k] = $v;
		}
	}
}
function fsocketopen($hostname, $port = 80, &$errno, &$errstr, $timeout = 15){
	$fp = '';
	if(function_exists('fsockopen')) {
		$fp = @fsockopen($hostname, $port, $errno, $errstr, $timeout);
	} elseif(function_exists('pfsockopen')) {
		$fp = @pfsockopen($hostname, $port, $errno, $errstr, $timeout);
	} elseif(function_exists('stream_socket_client')) {
		$fp = @stream_socket_client($hostname . ':' . $port, $errno, $errstr, $timeout);
	}
	return $fp;
}
function random($length, $numeric = 0){
	$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
	if($numeric) {
		$hash = '';
	} else {
		$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
		$length --;
	}
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i ++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}
function socket_test($api){
	echo $api['title'], ":", $api['url'], LF;
	$url = $host . $api['url'];
	if(! isset($api['get'])) {
		$api['get'] = 1;
	}
	
	$method = $api['get'] ? "get" : "post";
	/*
	 * foreach ($api['data'] as $k => $v){ <tr><td>$k : </td><td><input type='text' name = '$k' value='$v'></td> </tr> }
	 */
	
/* echo <<<HTML 
	<form id="form1" name="form1" method="$method" action="$url" target="_blank">;
	<table>
	
	</table>
	<input type="submit" name="button"   value="提交" id="send" /><br /></form>
HTML;
 */	
	$errors = array();
	$filename = str_replace('/', '_', $api['url']);
	$filename = substr($filename, 1);
	
	$result = socket_file($filename);
	
	$ret = $result;
	// var_dump($ret);exit;
	echo <<<HTML

<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<div>
<a onclick="show(this)" style="cursor:pointer; color:blue;" >显示隐藏返回结果</a>
<div style="display:none; color:#c96;">$ret</div>
</div>
<script>
function show(self){
	$(self).parent().children("div").toggle();

}
</script>
HTML;
	
	$ret = json_decode($ret, true);
	// var_dump($ret);exit('xx');
	if(! empty($api['return_json'])) {
		$return_json = $api['return_json'];
		// var_dump($return_json);
		if(empty($ret)) {
			echo '<span style="color:#f00">无数据</span>', LF;
		}
		if(! is_array($return_json)) {
			$return_json = json_decode($return_json, 1);
		}
		if(empty($return_json)) {
			echo "返回格式解析结果为空" . LF;
			return;
		}
		// var_dump($return_json);
		check_ecursive($return_json, $ret);
		// array_walk_recursive($return_json,"check");
		/*
		 * foreach ($return_json as $k => $v){ if(empty($ret[$k])){ $errors[$k] = "is null"; } }
		 */
	} else {
		echo "返回格式不能为空 <hr />" . LF;
		return;
	}
	echo "测试完毕 <hr /><br /><br />";
	return $ret;
}
function socket_file($filename){
	$host = "api.daoxila.com";
	$ip = "";
	$port = 80;
	$timeout = 30;
	$block = 0;
	$limit = 0;
	
	$path = "/var/www/daoxila/socket/app/$filename.txt";
	if(! file_exists($path)) {
		exit('文件不存在');
	}
	$request = file_get_contents($path);
	$request = str_replace("https://$host", "", $request);
	$arr = explode("\r\n\r\n", $request);
	if(! empty($arr[1])) {
		$fh = fopen($path, "rb");
		$first_line = fgets($fh);
		$first_line = explode(' ', $first_line);
		$method = $first_line[0];
		$url = $first_line[1];
		
		echo <<<HTML
		<form id="form1" name="form1" method="$method" action="$url" target="_blank">
				<table>
HTML;
		$data = explode('&', $arr[1]);
		foreach($data as $k => $v) {
			$a = explode('=', $v);
			$name = $a[0];
			$value = $a[1];
			echo <<<HTML
<tr><td>$name : </td><td><input type='text' name = '$name' value='$value'></td> </tr>
HTML;
		}
		
		echo <<<HTML
		</table>
		<input type="submit" name="button"   value="提交" id="send" /><br /></form>
HTML;
		
		// var_dump($data);exit;
	}
	$fpflag = 0;
	if(! $fp = fsocketopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout)) {
		$context = array(
				'http' => array(
						'method' => $post ? 'POST' : 'GET',
						'header' => $header,
						'content' => $post,
						'timeout' => $timeout 
				) 
		);
		$context = stream_context_create($context);
		$fp = @fopen($scheme . '://' . ($ip ? $ip : $host) . ':' . $port . $path, 'b', false, $context);
		$fpflag = 1;
	}
	
	if(! $fp) {
		return '';
	}
	stream_set_blocking($fp, 0);
	// stream_set_timeout($fp, $timeout);
	@fwrite($fp, $request);
	$st = gettimeofday(1);
	while(true) {
		
		$line = fgets($fp);
		// echo $line;
		if($line == "\r\n") {
			break;
		}
	}
	
	// echo gettimeofday(1) - $st;
	
	// $status = stream_get_meta_data($fp);
	// if(!$status['timed_out']) {
	/*
	 * while(! feof($fp)) { $header = @fgets($fp); $headers .= $header; if($header && ($header == "\r\n" || $header == "\n")) { break; } }
	 */
	// var_dump($header);
	// $limit = 2;
	if($limit) {
		$return = stream_get_contents($fp, $limit);
	} else {
		$return = stream_get_contents($fp);
	}
	// }
	@fclose($fp);
	// var_dump($return);exit;
	// $return = unchunk($return);
	return $return;
}

/**
 * 去除chunk
 * 
 * @param unknown $result        	
 * @return mixed
 */
function unchunk($result){
	return preg_replace_callback('/(?:(?:\r\n|\n)|^)([0-9A-F]+)(?:\r\n|\n){1,2}(.*?)' . '((?:\r\n|\n)(?:[0-9A-F]+(?:\r\n|\n))|$)/si', create_function('$matches', 'return hexdec($matches[1]) == strlen($matches[2]) ? $matches[2] : $matches[0];'), $result);
}

/**
 * 去除chunk
 * 
 * @param string $str        	
 * @return boolean string
 */
function unchunkHttpResponse($str = null){
	if(! is_string($str) or strlen($str) < 1) {
		return false;
	}
	$eol = "\r\n";
	$add = strlen($eol);
	$tmp = $str;
	$str = '';
	do {
		$tmp = ltrim($tmp);
		$pos = strpos($tmp, $eol);
		if($pos === false) {
			return false;
		}
		$len = hexdec(substr($tmp, 0, $pos));
		if(! is_numeric($len) or $len < 0) {
			return false;
		}
		$str .= substr($tmp, ($pos + $add), $len);
		$tmp = substr($tmp, ($len + $pos + $add));
		$check = trim($tmp);
	} while(! empty($check));
	unset($tmp);
	return $str;
}


function getCombinationToString($arr, $m){
	$result = array();
	if($m == 1) {
		return $arr;
	}

	if($m == count($arr)) {
		$result[] = implode(',', $arr);
		return $result;
	}

	$temp_firstelement = $arr[0];
	unset($arr[0]);
	$arr = array_values($arr);
	$temp_list1 = getCombinationToString($arr, ($m - 1));

	foreach($temp_list1 as $s) {
		$s = $temp_firstelement . ',' . $s;
		$result[] = $s;
	}
	unset($temp_list1);

	$temp_list2 = getCombinationToString($arr, $m);
	foreach($temp_list2 as $s) {
		$result[] = $s;
	}
	unset($temp_list2);

	return $result;
}




//php命令行下加颜色
function echo_color($text, $color="NORMAL",$is_backgroud = 0, $back=0){
	$_colors = array(
			'LIGHT_RED'      => "[1;31m",
			'LIGHT_GREEN'     => "[1;32m",
			'YELLOW'     => "[1;33m",
			'LIGHT_BLUE'     => "[1;34m",
			'MAGENTA'     => "[1;35m",
			'LIGHT_CYAN'     => "[1;36m",
			'WHITE'     => "[1;37m",
			'NORMAL'     => "[0m",
			'BLACK'     => "[0;30m",
			'RED'         => "[0;31m",
			'GREEN'     => "[0;32m",
			'BROWN'     => "[0;33m",
			'BLUE'         => "[0;34m",
			'CYAN'         => "[0;36m",
			'BOLD'         => "[1m",
			'UNDERSCORE'     => "[4m",
			'REVERSE'     => "[7m",
	
	);
	
	if($is_backgroud){
		$_colors = array(
				"SUCCESS" => "[42m", //Green background
				"FAILURE" => "[41m", //Red background
				"WARNING" => "[43m", //Yellow background
				"NOTE"    => "[44m", //Blue background
		);
	}
	
	
	
	//echo chr(27) . "[0;31m" . "$text" . chr(27) . "[0m";exit;
	$out = $_colors["$color"];
	if($out == ""){ $out = "[0m"; }
	if($back){
		return chr(27).$out.$text.chr(27)."[0m";
	}else{
		echo chr(27).$out.$text.chr(27)."[0m";
		//echo chr(27)."$out$text".chr(27).chr(27)."[0m".chr(27); 
	}//fi
}


//echo colorize("Your command was successfully executed...", "SUCCESS");
function colorize($text, $status) {
	$out = "";
	switch($status) {
		case "SUCCESS":
			$out = "[42m"; //Green background
			break;
		case "FAILURE":
			$out = "[41m"; //Red background
			break;
		case "WARNING":
			$out = "[43m"; //Yellow background
			break;
		case "NOTE":
			$out = "[44m"; //Blue background
			break;
		default:
			throw new Exception("Invalid status: " . $status);
	}
	return chr(27) . "$out" . "$text" . chr(27) . "[0m";
}





//数组转为分隔符连接的字符串，像个珍珠手链一样
function arrayToPearlBracelet($arr, $separator=','){
    return implode($separator,$arr);
}

function t1($v,$v2){
    return $v.'----'.$v2;
}

function get_video($id){
   $m = M('video');
   return $m->find($id);
}

function course_show($id){
    return "/course/{$id}";
}

function video_show($id,$course_id=''){

    //由于阿里云播放不支持https,只能强制走http
    if($course_id){
        return 'http://www.' . DOMAIN."/video/{$course_id}/{$id}";
    }
    return 'http://www.' . DOMAIN."/video/{$id}";
}

function get_select_by_category(){
    $parent = M('Category')->field('id,title')->where(['pid'=>0])->select();
    $ret = [];
    foreach ($parent as $k=>$v){
        $ret[] = $v;
        $r = M('Category')->field('id,title')->where(['pid'=>$v['id']])->select();
        if(empty($r)) continue;
        foreach ($r as $k2=>$v2){
            $v2['title'] = "&nbsp;&nbsp;".$v2['title'] ;
            $ret[] = $v2;
        }
    }

    return $ret;
    //$r = M('Category')->field('id,title')->select();
    //return $r;

}

function get_title_by_course_id(){

}

function get_select_by_course(){
    $r = M('Course')->field('id,title')->select();
    return $r;

}


function remove_xss($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=@avascript:alert('XSS')>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

      // @ @ search for the hex values
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // @ @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[xX]0{0,8}([9ab]);)';
               $pattern .= '|';
               $pattern .= '|(&#0{0,8}([9|10|13]);)';
               $pattern .= ')*';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }
   return $val;
}


function post_raw($raw='',$host=''){

    empty($host) &&  $host = "www.rrbrr.com";

        $fp = fsockopen($host, 80, $errno, $errstr, 30);

        if(!fp){
            return array(
                'status' => 'error',
                'error' => "$errstr ($errno)"
            );
        }
            //$length = strlen($data);
            $POST = <<<HEADER
POST /weixin?signature=7cfe846a80be635ec73bf93ca501b796bcddd815&timestamp=1510814425&nonce=683833149&openid=oEqKj1UKMHiZBcmtaaZC7cImSdM0 HTTP/1.1
Content-Type: text/xml
Content-Length: 282
Pragma: no-cache
Host: www.rrbrr.com
Accept: */*
User-Agent: Mozilla/4.0

<xml><ToUserName><![CDATA[gh_4288ddbc04d9]]></ToUserName>
<FromUserName><![CDATA[oEqKj1UKMHiZBcmtaaZC7cImSdM0]]></FromUserName>
<CreateTime>1510814425</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[我]]></Content>
<MsgId>6488898546170862620</MsgId>
</xml>

HEADER;
            // echo $POST;exit('x11111');
            fwrite($fp, $POST);
            $result = '';
            while(! feof($fp)) {
                // receive the results of the request
                $result .= fread($fp, 512);
            }

        // close the socket connection:
        fclose($fp);

        // split the result header from the content
        $result = explode("\r\n\r\n", $result, 2);

        // var_dump($path);
         var_dump($result);exit('x');
        // return as structured array:
        return array(
            'status' => 'ok',
            'header' => isset($result[0]) ? $result[0] : '',
            'content' => isset($result[1]) ? $result[1] : ''
        );
}


//导入操作
function impUser(){

    if (!empty($_FILES)) {


        import('Org.Net.UploadFile');

        $config=array(
            'allowExts'=>array('xlsx','xls'),
            'savePath'=>'./Uploads/',
//                'saveRule'=>'time',
        );
        $upload = new \UploadFile($config);

        if (!$upload->upload()) {
            $this->error($upload->getErrorMsg());
        } else {
            $info = $upload->getUploadFileInfo();

        }

        vendor("PHPExcel.PHPExcel");

        $file_name=$info[0]['savepath'].$info[0]['savename'];
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数

        for($i=2;$i<=$highestRow;$i++)
        {
            $data['username'] = $data['mobile'] = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
            $data['nickname'] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
            $data['status'] =1;
            $data['group'] =1;
            $data['addtime']= $data['updatetime'] = time();
            M('Member')->add($data);
        }
        $this->success('导入成功！');
    }else
    {
        $this->error("请选择上传的文件");
    }

}

//导出操作
function exportExcel($expTitle,$expCellName,$expTableData){
    $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
    $fileName = $expTitle.date('_Ymd_His');//or $xlsTitle 文件名称可根据自己情况设定
    $cellNum = count($expCellName);
    $dataNum = count($expTableData);
    vendor('PHPExcel.Classes.PHPExcel');
    $objPHPExcel = new \PHPExcel();
    $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

    //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
    //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));//第一行标题
    //for($i=0;$i<$cellNum;$i++){
    $j = 0;
    foreach ($expCellName as $columnName=>$columnZh){
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$j].'1', $columnZh);
        $j++;
    }

    // Miscellaneous glyphs, UTF-8
    for($i=0;$i<$dataNum;$i++){
        //for($j=0;$j<$cellNum;$j++){
        $j = 0;
        foreach ($expCellName as $columnName=>$columnZh){
            //var_dump($expTableData);
            if(is_numeric($expTableData[$i][$columnName]) &&  strlen($expTableData[$i][$columnName])>8){
                $objPHPExcel->getActiveSheet(0)->setCellValueExplicit($cellName[$j].($i+2), $expTableData[$i][$columnName],\PHPExcel_Cell_DataType::TYPE_STRING);
            }else{
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$columnName]);
            }
            $j++;
        }
    }

    header('pragma:public');
    header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
    header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}

function testExcel(){
    //创建对象
    $excel = new \PHPExcel();
    $excel->getActiveSheet()->setTitle('投诉列表');

    // 设置单元格高度
    // 所有单元格默认高度
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);
    // 第一行的默认高度
    $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
    // 垂直居中
    $excel->getActiveSheet()->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
    // 设置水平居中
    $excel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    //Excel表格式
    $letter = array('A','B','C','D','E','F','F','G','H','I','J','K','L');
    //表头数组
    $tableheader = array('序号','车牌号','车牌颜色','投诉说明','投诉地点','投诉人','投诉时间','投诉人手机号','投诉人微信号','微信昵称','状态','进展','奖励');
    $tablestyle = array(
        array('width'=>'5'),
        array('width'=>'15'),
        array('width'=>'10'),
        array('width'=>'40'),
        array('width'=>'30'),
        array('width'=>'10'),
        array('width'=>'15'),
        array('width'=>'15'),
        array('width'=>'15'),
        array('width'=>'15'),
        array('width'=>'10'),
        array('width'=>'10'),
        array('width'=>'10'),
    );

    // 如果选择视频下载
    if($is_download_mv){
        $letter[] = 'M';
        $tableheader[] = '视频地址（相对路径）';
        $tablestyle[] = array('width'=>'30');
    }
    // id , plate_num，color，msg，place，name，time,phone，weixin，wx_name，status，process
    //填充表头信息
    for($i = 0;$i < count($tableheader);$i++) {
        $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        $excel->getActiveSheet()->getColumnDimension($letter[$i])->setWidth($tablestyle[$i]['width']);
    }
    //填充表格信息
    for ($i = 2;$i <= count($complain_info) + 1;$i++) {
        $data = $complain_info[$i - 2];
        if($is_download_mv){
            $this->mv_arr[] = $data['vedio'];
            $tmp = explode('/',$data['vedio']);
            $tmpurl = array_pop($tmp);
            $excel->getActiveSheet()->setCellValue("$letter[13]$i","{$tmpurl}");
        }
        $excel->getActiveSheet()->setCellValue("$letter[0]$i","{$data['id']}");
        $excel->getActiveSheet()->setCellValue("$letter[1]$i","{$data['plate_num']}");
        $excel->getActiveSheet()->setCellValue("$letter[2]$i","{$data['color_str']}");
        $excel->getActiveSheet()->setCellValue("$letter[3]$i","{$data['msg']}");
        $excel->getActiveSheet()->setCellValue("$letter[4]$i","{$data['place']}");
        $excel->getActiveSheet()->setCellValue("$letter[5]$i","{$data['name']}");
        $excel->getActiveSheet()->setCellValue("$letter[6]$i","{$data['time']}");
        $excel->getActiveSheet()->setCellValue("$letter[7]$i","{$data['phone']}");
        $excel->getActiveSheet()->setCellValue("$letter[8]$i","{$data['weixin']}");
        $excel->getActiveSheet()->setCellValue("$letter[9]$i","{$data['wx_name']}");
        $excel->getActiveSheet()->setCellValue("$letter[10]$i","{$data['status_str']}");
        $excel->getActiveSheet()->setCellValue("$letter[11]$i","{$data['process_str']}");
        $excel->getActiveSheet()->setCellValue("$letter[12]$i","{$data['gift_send_str']}");
    }

    //创建Excel输入对象
    $write = new \PHPExcel_Writer_Excel5($excel);
    $filename = './report_list_'.date("Y-m-d-H.i.s").'.xls';
    $write->save($filename);

    // 进行下一步文件压缩
    if($is_download_mv){
        $this->mv_arr[] = $filename;
        $this->filezip();
    }else{
        $result['code'] =200;
        $result['filename'] =$filename;
        $this->ajaxReturn($result);
        return true;
    }
}

function ch_options($a){
    $arr = ['Avivo02'=>'Avivo02','AHlpm_oppo'=>'AHlpm_oppo','Ahlpm_huawei'=>'Ahlpm_huawei'];
    return $arr;
    $m = M('ch_data_new');
    $r = $m->field('ch')->where([])->group('ch')->select();
    $ch = array_column($r,'ch');
    $ch = array_values($ch);
    $ch = array_combine($ch,$ch);
    return $ch;

    $arr = array (
        '3601' => '3601',
        'A0001' => 'A0001',
        'A0007' => 'A0007',
        'A3601' => 'A3601',
        'Abaidu1' => 'Abaidu1',
        'Abaidu_hlpm' => 'Abaidu_hlpm',
        'Abaidu_jspm' => 'Abaidu_jspm',
        'Abaidu_xyjp' => 'Abaidu_xyjp',
        'ABose01' => 'ABose01',
        'Aduanxin0001' => 'Aduanxin0001',
        'Afenxiang1' => 'Afenxiang1',
        'Afreemeos1' => 'Afreemeos1',
        'Afreeos_jspm' => 'Afreeos_jspm',
        'AHlpm1' => 'AHlpm1',
        'AHlpm_360' => 'AHlpm_360',
        'AHlpm_Fenxiang' => 'AHlpm_Fenxiang',
        'AHlpm_oppo' => 'AHlpm_oppo',
        'Ahlpm_tengxun' => 'Ahlpm_tengxun',
        'AHlpm_vivo' => 'AHlpm_vivo',
        'AHlpm_xiaomi' => 'AHlpm_xiaomi',
        'AHlpm_Zmarket' => 'AHlpm_Zmarket',
        'Ahuawei' => 'Ahuawei',
        'Ahuawei1' => 'Ahuawei1',
        'Ahuawei_jspm' => 'Ahuawei_jspm',
        'Ahuawei_xyjp' => 'Ahuawei_xyjp',
        'Ajspm_tengxun' => 'Ajspm_tengxun',
        'Ajspm_vivo' => 'Ajspm_vivo',
        'Ameizu' => 'Ameizu',
        'Aoppo01' => 'Aoppo01',
        'Aoppo1' => 'Aoppo1',
        'ASdjp1' => 'ASdjp1',
        'Asmartisan' => 'Asmartisan',
        'Asougou' => 'Asougou',
        'ASougou1' => 'ASougou1',
        'ATengxun01' => 'ATengxun01',
        'Atengxun1' => 'Atengxun1',
        'ATengxunbr01' => 'ATengxunbr01',
        'ATengxunkp01' => 'ATengxunkp01',
        'ATengxunys01' => 'ATengxunys01',
        'Atuizi_hlpm' => 'Atuizi_hlpm',
        'Atuizi_jspm' => 'Atuizi_jspm',
        'auctionSDK' => 'auctionSDK',
        'Auc_jspm' => 'Auc_jspm',
        'Avivo1' => 'Avivo1',
        'Axiaomi1' => 'Axiaomi1',
        'AXyjp1' => 'AXyjp1',
        'AXyjp_360' => 'AXyjp_360',
        'AXyjp_Bose' => 'AXyjp_Bose',
        'AXyjp_Dsztc' => 'AXyjp_Dsztc',
        'AXyjp_Fenxiang' => 'AXyjp_Fenxiang',
        'AXyjp_FosPush' => 'AXyjp_FosPush',
        'AXyjp_Ly1' => 'AXyjp_Ly1',
        'AXyjp_Zh' => 'AXyjp_Zh',
        'AXyjp_Zmarket' => 'AXyjp_Zmarket',
        'AXyjp_Zycp' => 'AXyjp_Zycp',
        'Azmarket1' => 'Azmarket1',
        'AZmarket_hlpm' => 'AZmarket_hlpm',
        'AZmarket_jspm' => 'AZmarket_jspm',
        'AZmarket_xyjp' => 'AZmarket_xyjp',
        'baidu1' => 'baidu1',
        'data' => 'data',
        'default' => 'default',
        'DSPMengju1' => 'DSPMengju1',
        'duanxinrk' => 'duanxinrk',
        'dxzhaohui' => 'dxzhaohui',
        'dy9uys' => 'dy9uys',
        'dyzq' => 'dyzq',
        'fenxiang' => 'fenxiang',
        'Freemeos11' => 'Freemeos11',
        'freeos01' => 'freeos01',
        'h501' => 'h501',
        'h5fyp' => 'h5fyp',
        'h5jianqian' => 'h5jianqian',
        'Ios1' => 'Ios1',
        'Ios2' => 'Ios2',
        'Ios3' => 'Ios3',
        'iOSAuction' => 'iOSAuction',
        'IosJsjx' => 'IosJsjx',
        'IosQmzk' => 'IosQmzk',
        'IosSdpp' => 'IosSdpp',
        'IosXyjp' => 'IosXyjp',
        'Iosxypm' => 'Iosxypm',
        'kuchuan11' => 'kuchuan11',
        'OPPO11' => 'OPPO11',
        'PTiebaRuanguang1' => 'PTiebaRuanguang1',
        'qd0001' => 'qd0001',
        'sasa' => 'sasa',
        'SDQutoutiao1' => 'SDQutoutiao1',
        'SDQutoutiaodt1' => 'SDQutoutiaodt1',
        'SDQutoutiaodt2' => 'SDQutoutiaodt2',
        'SDTuia1' => 'SDTuia1',
        'SDXiaomi1' => 'SDXiaomi1',
        'SDYidianzixun1' => 'SDYidianzixun1',
        'sms01' => 'sms01',
        'snmi' => 'snmi',
        'test' => 'test',
        'testqd' => 'testqd',
        'uziAction' => 'uziAction',
        'uziauction' => 'uziauction',
        'vivo1' => 'vivo1',
        'wap' => 'wap',
        'xiaomi11' => 'xiaomi11',
        'yingyongbao1' => 'yingyongbao1',
        'yyhl4' => 'yyhl4',
        'yyhl5' => 'yyhl5',
        'yyhl6' => 'yyhl6',
        'yyhl7' => 'yyhl7',
        'zhanqun1' => 'zhanqun1',
        'zmarket11' => 'zmarket11',
        'zmarket12' => 'zmarket12',
        'zmtq' => 'zmtq',
        'zpush11' => 'zpush11',
        'zuimeitq' => 'zuimeitq',
    );
    return $arr;
}