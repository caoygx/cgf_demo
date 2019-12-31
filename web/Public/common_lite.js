function G(e) {
    return document.getElementById(e);

}
function foreverdel(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValues();

    }
    if (!keyValue)
    {
        alert('请选择删除项！');
        return false;

    }

    if (window.confirm('确实要永久删除选择项吗？'))
    {
        //ThinkAjax.send(CONTROLLER + "/foreverdelete/", "id=" + keyValue + '&ajax=1', doDelete);
        ThinkAjax.send(CONTROLLER + "/foreverdelete/", "id=" + keyValue , doDelete);

    }

}


function doDelete(data, status) {
    console.log(data);
    if (data.code == 1)
    {
        alert('删除成功');
        window.location.reload();
        return;

        //删除表格
        var Table = G('checkList');
        var len = selectRowIndex.length;
        if (len == 0) {
            window.location.reload();

        }
        for (var i = len - 1; i >= 0; i--)
        {
            //删除表格行
            Table.deleteRow(selectRowIndex[i]);

        }
        selectRowIndex = Array();

    }else{
        alert('删除失败');
    }

}


function fleshVerify() {
    //重载验证码
    var timenow = new Date().getTime();
    G('verifyImg').src = APP + '/Public/verify/' + timenow;

}

function allSelect() {
    var colInputs = document.getElementsByTagName("input");
    for (var i = 0; i < colInputs.length; i++) {
        colInputs[i].checked = true;

    }

}
function allUnSelect() {
    var colInputs = document.getElementsByTagName("input");
    for (var i = 0; i < colInputs.length; i++) {
        colInputs[i].checked = false;

    }

}

function InverSelect() {
    var colInputs = document.getElementsByTagName("input");
    for (var i = 0; i < colInputs.length; i++) {
        colInputs[i].checked = !colInputs[i].checked;

    }

}

function WriteTo(id) {
    var type = $F('outputType');
    switch (type) {
        case 'EXCEL':
            WriteToExcel(id);
            break;
        case 'WORD':
            WriteToWord(id);
            break;


    }
    return;

}


function get(url, param, handler) {
    try {
        $.ajaxSetup({
            error: function (x, e) {
                console.log('没有内容');
                return false;
            }
        });

        $.getJSON(url, param, handler);

    } catch (ex) {
        console.log('异常内容');
    }

}

function post(url, param, handler) {
    try {
        $.ajaxSetup({
            error: function (x, e) {
                console.log('服务器响应错误');
                return false;
            }
        });
        $.post(url, param, handler, "json");
    } catch (ex) {
        //alert(ex.message);
        console.log('异常内容');
    }
}


function post_cross(url, param, handler) {
    try {
        param['ret_format'] = 'json';
        $.ajax({
            type: "POST",
            url: url,
            data: param,
            //dataType: 'json',
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,

            success: handler,
            /*success:function(){
             handler
             alert('成功');
             },*/
            error: function (x, e) {
                console.log('服务器响应错误');
                return false;
            }

        });
    } catch (ex) {
        //alert(ex.message);
        console.log('异常内容');
    }

}


function checkCode(data) {
    console.log(data);
    if (data.code == 0) {
        msg(data.msg);
        return false;
    }
    return true;
}

var ThinkAjax = {
    send:function(url,pars,response){
        url = url+"?"+pars;
        data = {};
        $.getJSON(url,data,response);
    },
    other:function(){}
};


function msg(data) {
    alert(data);
}


function previewImg(obj, fieldName) {
    url = getObjectURL(obj.files[0]);
    $("#preview_img_" + fieldName + " img").attr("src", url);
}

//多图预览
function previewMultImg2(obj, fieldName) {
    var count = obj.files.length;
    if (count < 1) return;
    for (var i = 0; i < count; i++) {
        console.log(obj.files);
        url = getObjectURL(obj.files[i]);
        $("#preview_mult_img_" + fieldName).append("<img  src='" + url + "'>");

    }

}

function getObjectURL(file) {
    var url = null;
    // 下面函数执行的效果是一样的，只是需要针对不同的浏览器执行不同的 js 函数而已
    if (window.createObjectURL != undefined) { // basic
        url = window.createObjectURL(file);
    } else if (window.URL != undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file);
    } else if (window.webkitURL != undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file);
    }
    return url;
}


function detectOS() {
    var sUserAgent = navigator.userAgent;
    var isWin = (navigator.platform == "Win32") || (navigator.platform == "Windows");
    var isMac = (navigator.platform == "Mac68K") || (navigator.platform == "MacPPC") || (navigator.platform == "Macintosh") || (navigator.platform == "MacIntel");
    if (isMac) return "MacOS";
    var isUnix = (navigator.platform == "X11") && !isWin && !isMac;
    if (isUnix) return "Unix";
    var isLinux = (String(navigator.platform).indexOf("Linux") > -1);
    if (isLinux) return "Linux";
    if (isWin) {
        var isWin2K = sUserAgent.indexOf("Windows NT 5.0") > -1 || sUserAgent.indexOf("Windows 2000") > -1;
        if (isWin2K) return "Windows2000";
        var isWinXP = sUserAgent.indexOf("Windows NT 5.1") > -1 || sUserAgent.indexOf("Windows XP") > -1;
        if (isWinXP) return "WindowsXP";
        var isWin2003 = sUserAgent.indexOf("Windows NT 5.2") > -1 || sUserAgent.indexOf("Windows 2003") > -1;
        if (isWin2003) return "Windows2003";
        var isWinVista = sUserAgent.indexOf("Windows NT 6.0") > -1 || sUserAgent.indexOf("Windows Vista") > -1;
        if (isWinVista) return "Windows Vista";
        var isWin7 = sUserAgent.indexOf("Windows NT 6.1") > -1 || sUserAgent.indexOf("Windows 7") > -1;
        if (isWin7) return "Windows7";
    }
    return "other";
}

function isIpad() {
    var ua = navigator.userAgent.toLowerCase();
    var s;
    s = ua.match(/iPad/i);

    if (s == "ipad") {
        return true;
    }
    else {
        return false;
    }

}


//是否是微信浏览
function isWeixin() {

    var ua = navigator.userAgent.toLowerCase();

    if (ua.match(/MicroMessenger/i) == "micromessenger") {

        return true;

    } else {

        return false;

    }

}


//是否支持webp
function isWebp() {
    var isSupportWebp = !![].map && document.createElement('canvas').toDataURL('image/webp').indexOf('data:image/webp') == 0;

    return isSupportWebp;
    //console.log(isSupportWebp);   //
}


function goback() {
    //console.log()
    if (history.length > 1) {
        history.back(-1);
    } else {
        location.href = '/';
    }
    return;
    var ref = $("#hd_referrer").val();
    if (ref != "" && ref != "undefined") {
        location.href = ref;
    }
    else {
        location.href = history.back(-1);
    }
}

//wap 返回键
$(function () {
    $("#hd_referrer").val(document.referrer);

    $('#back').click(function () {
        goback();
    });

});


$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};



function showBuy() {
    //销毁
    player.dispose();
    $('#J_prismPlayer').empty();
    var course_id=$('#course_id').val();
    var html = '<div class="buy_tip">'+
        '<div>    试看结束，如果需要继续观看，请购买课程。<br />       </div>'+
        '<div>  <a  target="_blank" href="'+URL_USER+'/order/create/course_id/'+course_id+'" class="buy"> 立即购买</a>  </div>'+
        '<div class="refresh"><span>购买后刷新页面即可观看</span> <a href="javascript:location.reload();">已购买，立即刷新</a> </div>'+
        '</div>';
    $('#J_prismPlayer').html(html);
}

function getPlayTime(){
    var tryPlayTime=video_price;
    var currentTime = player.getCurrentTime();
    if(currentTime>tryPlayTime){
        showBuy();
        clearTimeout(t1);
    }
    //console.log(currentTime);
}
function handleReady() {

    t1 = window.setInterval(getPlayTime,1000);
}

function handlePlay(){
    t1 = window.setInterval(getPlayTime,1000);
}