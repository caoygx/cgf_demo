<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?><!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <meta name="author" content="lsl">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="generator" content="webstorm">
    <!--移动端响应式-->
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
    <!--支持IE的兼容模式-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--让部分国产浏览器默认采用高速模式渲染页面-->
    <meta name="renderer" content="webkit">
 

    <title></title>
 
</head>

<body >
 <div class="w1200">
  <div class="jiaru"> <span class="fr"> </span> </div>
  <div class="quick_logon" style="height:400px; margin-bottom: 60px;">
    <div class="quick_logon_con">
      <div class="system-message">
        <?php if(isset($message)) {?>
        <p class="success"><?php echo($message); ?></p>
        <?php }else{?>
        <!-- <h1>:(</h1> -->
        <p class="error"><?php echo($error); ?></p>
        <?php }?>
        <p class="detail"></p>
        <p class="jump"> 页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b> </p>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>

</body>
</html>