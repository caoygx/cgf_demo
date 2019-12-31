<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>跳转提示</title>
<!--防止IE进入怪异模式-->
<meta http-equiv=X-UA-Compatible content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="//public.rrbrr.com/pc/css/rest.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="//public.rrbrr.com/pc/css/style.css" />
<link rel="stylesheet" type="text/css" href="//public.rrbrr.com/pc/css/layout.css" />
<script src="//libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="//public.rrbrr.com/pc/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="//public.rrbrr.com/pc/js/base.js"></script>

<style type="text/css">
*{ padding: 0; margin: 0; }
body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
.system-message{ padding: 24px 48px; text-align:center; }
.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
.system-message .jump{ padding-top: 20px}
.system-message .jump a{ color: #333;}
.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
.jump_menu{color: #00B83F; margin-top:10px; font-size: 25px; height: 25px; line-height: 25px;}
.jump_menu a{color:#286090; margin-right:20px;}
</style>

</head>

<body class="paging_all_bg">
<!--头部-->

<!--End header  -->

<div class="w1200">
  <div class="jiaru"> <span class="fr"> </span> </div>
  <div class="quick_logon" style="height:400px; margin-bottom: 60px;">
    <div class="quick_logon_con">
      <div class="system-message">
        <?php if(isset($message)) {?>
        <p class="success" style="color:#4acf66;"><?php echo($message); ?></p>
        <?php }else{?>
        <!-- <h1>:(</h1> -->
        <p class="error" style="color:#f00;"><?php echo($error); ?></p>
        <?php }?>
        <p class="jump_menu" >
          <?= $jumpMenu ?>

          <link href="//public.rrbrr.com/pc/css/rest.css" type="text/css" rel="stylesheet" />

        </p>
        <p class="detail"></p>
        <p class="jump"> 页面自动 <a style="display: inline; color: #f00;" id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b> </p>
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

<!--正文结束--> 

<!--footer-->


<!--footer end-->

</body>
</html>