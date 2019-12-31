function G(e) {
    return document.getElementById(e);

}
function showTip(info) {
    G('tips').innerHTML = info;

}
function sendForm(formId, action, response, target, effect) {
    // Ajax方式提交表单
    if (CheckForm(G(formId), 'ThinkAjaxResult'))
    //表单数据验证
    {
        ThinkAjax.sendForm(formId, action, response);

    }
    //Form.reset(formId);

}
rowIndex = 0;

function prepareIE(height, overflow) {
    bod = document.getElementsByTagName('body')[0];
    bod.style.height = height;
    //bod.style.overflow = overflow;

	htm = document.getElementsByTagName('html')[0];
    htm.style.height = height;
    //htm.style.overflow = overflow; 

}

function hideSelects(visibility) {
    selects = document.getElementsByTagName('select');
    for (i = 0; i < selects.length; i++) {
        selects[i].style.visibility = visibility;

    }

}
//document.write('<div id="overlay" class="none"></div><div id="lightbox" class="none"></div>');
// 显示light窗口
function showPopWin(content, width, height) {
    //  IE 
    prepareIE('100%', 'hidden');
    window.scrollTo(0, 0);
    hideSelects('hidden');
    //隐藏所有的<select>标记
    G('overlay').style.display = 'block';
    var arrayPageSize = getPageSize();
    var arrayPageScroll = getPageScroll();
    G('lightbox').style.display = 'block';
    G('lightbox').style.top = (arrayPageScroll[1] + ((arrayPageSize[3] - 35 - height) / 2) + 'px');
    G('lightbox').style.left = (((arrayPageSize[0] - 25 - width) / 2) + 'px');
    G('lightbox').innerHTML = content;

}

function fleshVerify() {
    //重载验证码
    var timenow = new Date().getTime();
    G('verifyImg').src = APP + '/Public/verify/' + timenow;

}

function allSelect() {
    var colInputs = document.getElementsByTagName("input");
    for (var i = 0; i < colInputs.length; i++)
    {
        colInputs[i].checked = true;

    }

}
function allUnSelect() {
    var colInputs = document.getElementsByTagName("input");
    for (var i = 0; i < colInputs.length; i++)
    {
        colInputs[i].checked = false;

    }

}

function InverSelect() {
    var colInputs = document.getElementsByTagName("input");
    for (var i = 0; i < colInputs.length; i++)
    {
        colInputs[i].checked = !colInputs[i].checked;

    }

}

function WriteTo(id) {
    var type = $F('outputType');
    switch (type)
    {
        case 'EXCEL':
        WriteToExcel(id);
        break;
        case 'WORD':
        WriteToWord(id);
        break;


    }
    return;

}

function build(id) {
    window.location = APP + '/Card/batch/type/' + id;

}
function shortcut() {
    var name = window.prompt("输入该快捷方式的显示名称", "");
    if (name != null)
    {
        var url = location.href;
        ThinkAjax.send(location.protocol + '//' + location.hostname + APP + '/Shortcut/ajaxInsert/', 'ajax=1&name=' + name + '&url=' + url);

    }


}
function delcache() {
    ThinkAjax.send(location.protocol + '//' + location.hostname + APP + '/Common/clearcache/', 'ajax=1');
    window.location.reload();

}
function show() {
    if (document.getElementById('menu').style.display != 'none')
    {
        document.getElementById('menu').style.display = 'none';
        document.getElementById('main').className = 'full';

    } else {
        document.getElementById('menu').style.display = 'inline';
        document.getElementById('main').className = 'main';

    }

}

function CheckAll(strSection)
 {
    var i;
    var colInputs = document.getElementById(strSection).getElementsByTagName("input");
    for (i = 1; i < colInputs.length; i++)
    {
        colInputs[i].checked = colInputs[0].checked;

    }

}
function add(id) {
    if (id)
    {
        location.href = CONTROLLER + "/add/id/" + id;

    } else {
        location.href = CONTROLLER + "/add/";

    }

}
function showHideSearch() {
    if (document.getElementById('searchM').style.display == 'inline')
    {
        document.getElementById('searchM').style.display = 'none';
        document.getElementById('showText').value = '高级';
        document.getElementById('key').style.display = 'inline';

    } else {
        document.getElementById('searchM').style.display = 'inline';
        document.getElementById('showText').value = '隐藏';
        document.getElementById('key').style.display = 'none';


    }

}

function top2(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValues();

    }
    if (!keyValue)
    {
        alert('请选择置顶项！');
        return false;

    }

    location.href = CONTROLLER + "/top/id/" + keyValue;


}
function unTop(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValues();

    }
    if (!keyValue)
    {
        alert('请选择置顶项！');
        return false;

    }
    // alert(keyValue);
    location.href = CONTROLLER + "/unTop/id/" + keyValue;


}
function sort(id) {
    var keyValue;
    keyValue = getSelectCheckboxValues();
    location.href = CONTROLLER + "/sort/sortId/" + keyValue;

}

function high(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValues();

    }
    if (!keyValue)
    {
        alert('请选择高亮项！');
        return false;

    }
    location.href = CONTROLLER + "/high/id/" + keyValue;

}
function recommend(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValues();

    }
    if (!keyValue)
    {
        alert('请选择推荐项！');
        return false;

    }
    location.href = CONTROLLER + "/recommend/id/" + keyValue;

}
function unrecommend(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValues();

    }
    if (!keyValue)
    {
        alert('请选择项目！');
        return false;

    }
    location.href = CONTROLLER + "/unrecommend/id/" + keyValue;

}
function pass(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValues();

    }
    if (!keyValue)
    {
        alert('请选择审核项！');
        return false;

    }

    if (window.confirm('确实审核通过吗？'))
    {
        window.location.href = CONTROLLER + '/checkPass/id/' + keyValue;
        //ThinkAjax.send(CONTROLLER+"/checkPass/","id="+keyValue+'&ajax=1');

    }

}
function passs(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValues();

    }
    if (!keyValue)
    {
        alert('请选择审核项！');
        return false;

    }

    if (window.confirm('确实审核通过吗？'))
    {
        window.location.href = CONTROLLER + '/checkPasss/id/' + keyValue;
        //ThinkAjax.send(CONTROLLER+"/checkPass/","id="+keyValue+'&ajax=1');

    }

}
function sortBy(field, sort) {
    location.href = "?_order=" + field + "&_sort=" + sort;

}
function cache() {
    ThinkAjax.send(CONTROLLER + '/cache', 'ajax=1');

}
function forbid(id) {
    location.href = CONTROLLER + "/forbid/id/" + id;
}
function recycle(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValue();

    }
    if (!keyValue)
    {
        alert('请选择要还原的项目！');
        return false;

    }
    location.href = CONTROLLER + "/recycle/id/" + keyValue;

}
function resume(id) {
    location.href = CONTROLLER + "/resume/id/" + id;

}
function trace(id) {
    location.href = CONTROLLER + "/trace/id/" + id;

}
function output() {
    location.href = CONTROLLER + "/output/";

}
function member(id) {
    location.href = CONTROLLER + "/../Member/edit/id/" + id;

}
function chat(id) {
    location.href = CONTROLLER + "/../Chat/index/girlId/" + id;

}
function login(id) {
    location.href = CONTROLLER + "/../Login/index/type/4/id/" + id;

}
function child(id) {
    location.href = CONTROLLER + "/index/pid/" + id;

}
function action(id) {
    location.href = CONTROLLER + "/action/groupId/" + id;

}

function access(id) {
    location.href = CONTROLLER + "/access/id/" + id;

}
function app(id) {
    location.href = CONTROLLER + "/app/groupId/" + id;

}

function module(id) {
    location.href = CONTROLLER + "/module/groupId/" + id;

}
function addv(id) {
    location.href = CONTROLLER + "/addv/id/" + id;

}

function user(id) {
    location.href = CONTROLLER + "/user/id/" + id;

}

function addVideo(id) {
    window.open("/video/add/course_id/" + id);
}

function selectVideo(id){
    location.href = "/video/select/course_id/" + id;
}
function reeditVideo(id){
    window.open("/video/add/id/" + id+"?reedit=1");
}
function uploadTryPlayVideo(id){
    window.open("/video/uploadTryPlay/id/" + id);
}



function linkVideo(id){
    window.open("/video/link/course_id/" + id);
    //location.href = "/video/select/course_id/" + id;
}


function addComment(id){
     window.open("/comment/add/course_id/" + id);
}


function videoManage(id) {
    window.open( "/video/index/course_id/" + id);
}

function previewCourse(id) {
    window.open(URL_WWW + "/course/show/id/" + id);
}

function previewVideo(id) {
    window.open( "/video/show/id/" + id);
}

function viewComment(course_id){
    if(!course_id) return false;
    window.open(URL_WWW + "/course/" + course_id+'#homework');
}

function addOldUserBalance(id) {
    window.open( "/oldUserBalance/initNewUser?user_id=" + id);
}

function wxpaySendGoods(order_no){
    location.href = "/order/query/paymethod/wxpay/order_no/" + order_no;
}

function alipaySendGoods(order_no){
    location.href = "/order/query/paymethod/alipay/order_no/" + order_no;
}

function setPassword(id){
    //location.href = "/user/setPassword/?id=" + id;
    window.open(  "/user/setPassword/?id=" + id);
}

function log_request_ip_line(ip,id) {
    location.href = CONTROLLER + "/index/?ip=" + ip;

}

function user_view_recharge(openid) {
    location.href = "/recharge/index/?type=0&status=2&openid=" + openid;

}

function user_edit(id) {
    edit(id)
}

function press_send(id) {
    
}



//+---------------------------------------------------
//|	打开模式窗口，返回新窗口的操作值
//+---------------------------------------------------
function PopModalWindow(url, width, height)
 {
    var result = window.showModalDialog(url, "win", "dialogWidth:" + width + "px;dialogHeight:" + height + "px;center:yes;status:no;scroll:no;dialogHide:no;resizable:no;help:no;edge:sunken;");
    return result;

}

function read(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValue();

    }
    if (!keyValue)
    {
        alert('请选择编辑项！');
        return false;

    }
    location.href = CONTROLLER + "/read/id/" + keyValue;

}



function getData(){
	var data = $('#form').serialize();
	if(data){
		data += "&ajax=1";
	}else{
		data = "ajax=1";
	}
	return data;
}


	
function save(id){
	
	var url = CONTROLLER+"/save";
	var data = getData();
	$.post(url,data,function(response){
		alert(response.info);
		window.location = "/index.php?s=/User/Family/index.html";
	})
}

function del(id){
	var keyValue;
	if (id)
	{
		keyValue = id;
	}else {
		keyValue = getSelectCheckboxValues();
	}
	if (!keyValue)
	{
		alert('请选择删除项！');
		return false;
	}
	if (window.confirm('确实要删除选择项吗？'))
	{
		ThinkAjax.send(CONTROLLER+"/delete/","id="+keyValue+'&ajax=1',doDelete);
	}
}

function edit(id){
	var keyValue;
	if (id)
	{
		keyValue = id;
	}else {
		keyValue = getSelectCheckboxValue();
	}
	if (!keyValue)
	{
		alert('请选择编辑项！');
		return false;
	}
	window.open(CONTROLLER + "/edit/id/" + keyValue);
    //location.href = CONTROLLER + "/edit/id/" + keyValue;
	//location.href =  CONTROLLER+"/edit/id/"+keyValue;
}
 



function view(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValue();

    }
    if (!keyValue)
    {
        alert('请选择查看项！');
        return false;

    }
    //location.href = CONTROLLER + "/show/id/" + keyValue;
	domain = "rrbrr.com";
	subdomain = "www.";
	location.href = "http://"+subdomain+domain +CONTROLLER+ "/show/id/" + keyValue;

}

function grades(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValue();

    }
    if (!keyValue)
    {
        alert('请选择编辑项！');
        return false;

    }
    location.href = CONTROLLER + "/grades/id/" + keyValue;

}
function addmoney(id) {
    location.href = CONTROLLER + "/addmoney/id/" + id;

}
var selectRowIndex = Array();
function del(id) {
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
    if (window.confirm('确实要删除选择项吗？'))
    {
        ThinkAjax.send(CONTROLLER + "/delete/", "id=" + keyValue + '&ajax=1', doDelete);

    }

}
function delcontent(id) {
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
    if (window.confirm('确实要删除选择项吗？'))
    {
        ThinkAjax.send(CONTROLLER + "/delcontent/", "id=" + keyValue + '&ajax=1', doDelete);

    }

}
function delsummary(id) {
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
    if (window.confirm('确实要删除选择项吗？'))
    {
        ThinkAjax.send(CONTROLLER + "/delsummary/", "id=" + keyValue + '&ajax=1', doDelete);

    }

}
function delexamples(id) {
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
    if (window.confirm('确实要删除选择项吗？'))
    {
        ThinkAjax.send(CONTROLLER + "/delexamples/", "id=" + keyValue + '&ajax=1', doDelete);

    }

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
function getTableRowIndex(obj) {
    selectRowIndex[0] = obj.parentElement.parentElement.rowIndex;
    /*当前行对象*/

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
function delAttach(id, showId) {
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

    if (window.confirm('确实要删除选择项吗？'))
    {
        G('result').style.display = 'block';
        ThinkAjax.send(CONTROLLER + "/delAttach/", "id=" + keyValue + '&_AJAX_SUBMIT_=1');
        if (showId != undefined)
        {
            G(showId).innerHTML = '';

        }

    }

}

function clearData() {
    if (window.confirm('确实要清空全部数据吗？'))
    {
        location.href = CONTROLLER + "/clear/";

    }

}
function takeback(id) {
    var keyValue;
    if (id)
    {
        keyValue = id;

    } else {
        keyValue = getSelectCheckboxValues();

    }
    if (!keyValue)
    {
        alert('请选择回收项！');
        return false;

    }

    if (window.confirm('确实要回收选择项吗？'))
    {
        location.href = CONTROLLER + "/takeback/id/" + keyValue;

    }

}


function getSelectCheckboxValue() {
    var obj = document.getElementsByName('key');
    var result = '';
    for (var i = 0; i < obj.length; i++)
    {
        if (obj[i].checked == true)
        return obj[i].value;


    }
    return false;

}

function getSelectCheckboxValues() {
    var obj = document.getElementsByName('key');
    var result = '';
    var j = 0;
    for (var i = 0; i < obj.length; i++)
    {
        if (obj[i].checked == true) {
            selectRowIndex[j] = i + 1;
            result += obj[i].value + ",";
            j++;

        }

    }
    return result.substring(0, result.length - 1);

}

function change(e)
 {
    if (!document.all)
    {
        return;

    }
    var e = e || event;
    var oObj = e.srcElement || e.target;
    //if(oObj.tagName.toLowerCase()   ==   "td")   
    // {   
    /*
	  var   oTable   =   oObj.parentNode.parentNode;   
	  for(var   i=1;   i<oTable.rows.length;   i++)   
	  {   
	  oTable.rows[i].className   =   "out";   
	  oTable.rows[i].tag   =   false;   
	  }   */
    var obj = document.getElementById('checkList').getElementsByTagName("input");
    var oTr = oObj.parentNode;
    var row = oObj.parentElement.rowIndex - 1;
    if (oTr.className == 'down')
    {
        oTr.className = 'out';
        obj[row].checked = false;
        oTr.tag = true;

    } else {
        oTr.className = 'down';
        obj[row].checked = true;
        oTr.tag = true;

    }
    //}   

}

function out(e)
 {
    var e = e || event;
    var oObj = e.srcElement || e.target;



    var oTr = oObj.parentNode;
    if (!oTr.tag)
    oTr.className = "out";


}

function over(e)
 {
    var e = e || event;
    var oObj = e.srcElement || e.target;

    var oTr = oObj.parentNode;
    if (!oTr.tag)
    oTr.className = "over";


}


//---------------------------------------------------------------------
// 多选改进方法 by Liu21st at 2005-11-29
// 
//
//-------------------------begin---------------------------------------

function searchItem(item) {
    for (i = 0; i < selectSource.length; i++)
    if (selectSource[i].text.indexOf(item) != -1)
    {
        selectSource[i].selected = true;
        break;
    }

}

function addItem() {
    for (i = 0; i < selectSource.length; i++)
    if (selectSource[i].selected) {
        selectTarget.add(new Option(selectSource[i].text, selectSource[i].value));

    }
    for (i = 0; i < selectTarget.length; i++)
    for (j = 0; j < selectSource.length; j++)
    if (selectSource[j].text == selectTarget[i].text)
    selectSource[j] = null;

}

function delItem() {
    for (i = 0; i < selectTarget.length; i++)
    if (selectTarget[i].selected) {
        selectSource.add(new Option(selectTarget[i].text, selectTarget[i].value));


    }
    for (i = 0; i < selectSource.length; i++)
    for (j = 0; j < selectTarget.length; j++)
    if (selectTarget[j].text == selectSource[i].text) selectTarget[j] = null;

}

function delAllItem() {
    for (i = 0; i < selectTarget.length; i++) {
        selectSource.add(new Option(selectTarget[i].text, selectTarget[i].value));


    }
    selectTarget.length = 0;

}
function addAllItem() {
    for (i = 0; i < selectSource.length; i++) {
        selectTarget.add(new Option(selectSource[i].text, selectSource[i].value));


    }
    selectSource.length = 0;

}

function getReturnValue() {
    for (i = 0; i < selectTarget.length; i++) {
        selectTarget[i].selected = true;

    }

}

function loadBar(fl)
//fl is show/hide flag
 {
    var x,
    y;
    if (self.innerHeight)
    {
        // all except Explorer
        x = self.innerWidth;
        y = self.innerHeight;

    }
    else
    if (document.documentElement && document.documentElement.clientHeight)
    {
        // Explorer 6 Strict Mode
        x = document.documentElement.clientWidth;
        y = document.documentElement.clientHeight;

    }
    else
    if (document.body)
    {
        // other Explorers
        x = document.body.clientWidth;
        y = document.body.clientHeight;

    }

    var el = document.getElementById('loader');
    if (null != el)
    {
        var top = (y / 2) - 50;
        var left = (x / 2) - 150;
        if (left <= 0) left = 10;
        el.style.visibility = (fl == 1) ? 'visible': 'hidden';
        el.style.display = (fl == 1) ? 'block': 'none';
        el.style.left = left + "px"
        el.style.top = top + "px";
        el.style.zIndex = 2;

    }

}

//选中下拉列表值
function selectByValue(element, v) {
    var o = document.getElementById(element).options;
    if (o) {
        for (var i = 0; i < o.length; i++) {
            if (o[i].value == v) {
                o[i].selected = true;

            }

        }

    }

}

//设置文本框值
function setValue(id, v) {
    document.getElementById(id).value = v;

}

function showProvince(name) {
    var i = 0;
    data2 = province_node;
    for (var k in data2) {
        document.getElementById(name).options[i] = new Option(data2[k], data2[k]);
        i++;

    }

}


function showCity(name, province) {
    province = getProvinceKey(province);
    document.getElementById(name).options.length = 0;
    for (var k in city_node) {
        s = k - province;
        if (s > 0 && s < 10000) {
            document.getElementById(name).options.add(new Option(city_node[k]['title'], city_node[k]['title']));

        }

    }

}
function getProvinceKey(province) {
    for (var k in province_node) {
        if (province_node[k] == province)
        return k;

    }

}

function loadProvinceCicy(province, city) {
    showProvince(province);
    document.getElementById(province).onchange = function() {
        showCity(city, this.value);

    }

}

function fileChange(k, obj) {
    var imgid = "img_" + k;
    var formid = "form_" + k;
    document.getElementById(imgid).src = obj.value;
    document.getElementById(formid).submit();

}

/**
  *将两个层的高度保持一致
  */
function equalHight(a, b) {
    ah = G(a).offsetHeight;
    //alert(G(a).offsetHeight);
    bh = G(b).offsetHeight;

    if (ah < bh) {
        G(a).style.height = bh + "px";

    } else {
        G(b).style.height = ah + "px";

    }

}

function g(name) {
    var is = document.getElementsByName(name);
    var ids = new Array();
    var j = 0;
    for (var i = 0; i < is.length; ++i) {
        if (is[i].type == 'checkbox' && is[i].checked) {
            ids[j++] = is[i].value;

        }

    }
    return ids;

}

function getJoinValue() {
    var v = '';
    $(":checkbox:checked").each(function() {
        if (this.value)
        v += this.value + ',';

    });
    //alert(v.substr(0,v.length-1));
    if (v)
    return v.substr(0, v.length - 1);

}



function ajaxGet(url, ids) {
    if (!ids) {
        ids = getJoinValue();

    }
    url = url + ids + "/ajax/1";
    if (ids) {
        $.get(url, 
        function(data) {
            d = eval('(' + data + ')');
            if (typeof(d) == 'object') {
                alert(d.info);

            } else {
                alert(data);

            }

        });

    } else {
        alert('请先选择');

    }

}

function chkall(n) {
    var l = document.getElementsByName(n);
    for (i = 0; i < l.length; i++) {
        l[i].checked = true;

    }

}
function chkallno(n) {
    var l = document.getElementsByName(n);
    for (i = 0; i < l.length; i++) {
        l[i].checked = false;

    }

}

function get(url,param,handler) {
    try {
        $.ajaxSetup({
            error: function (x, e) {
                console.log('没有内容');
                return false;
            }
        });

        $.getJSON(url,param,handler);

    }catch (ex) {
        console.log('异常内容');
    }

}

function post(url,param,handler) {
    try {
        $.ajaxSetup({
            error: function (x, e) {
                console.log('服务器响应错误');
                return false;
            }
        });
        $.post(url,param,handler, "json");
    }catch (ex) {
        //alert(ex.message);
        console.log('异常内容');
    }
}



function post_cross(url,param,handler) {
    try {
        param['ret_format'] = 'json';
        $.ajax({
            type: "POST",
            url: url,
            data:param,
            //dataType: 'json',
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,

            success:handler,
            /*success:function(){
             handler
             alert('成功');
             },*/
            error: function (x, e) {
                console.log('服务器响应错误');
                return false;
            }

        });
    }catch (ex) {
        //alert(ex.message);
        console.log('异常内容');
    }

}


function checkCode(data) {
    console.log(data);
    if(data.code == 0){
        msg(data.msg);
        return false;
    }
    return true;
}

//ThinkAjax.send(CONTROLLER + "/delcontent/", "id=" + keyValue + '&ajax=1', doDelete);
var ThinkAjax = {
	send:function(url,pars,response){
		url = url+"?"+pars;
		data = {};
		$.getJSON(url,data,response);
	},
	other:function(){}
}

function msg(data){
	alert(data);
}

//读写cookie函数
function getCookie(c_name)
{
	if (document.cookie.length > 0)
	{
		c_start = document.cookie.indexOf(c_name + "=")
		if (c_start != -1)
		{
			c_start = c_start + c_name.length + 1;
			c_end   = document.cookie.indexOf(";",c_start);
			if (c_end == -1)
			{
				c_end = document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return null
}
function setCookie(c_name,value,expiredays)
{
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()); //使设置的有效时间正确。增加toGMTString()
}

function previewImg(obj,fieldName) {
    url = getObjectURL(obj.files[0]);
    $("#preview_img_"+fieldName+" img").attr("src",url);
}

//多图预览
function previewMultImg2(obj,fieldName) {
    var count = obj.files.length;
    if(count<1) return;
    for(var i = 0; i< count; i++){
        console.log(obj.files);
        url = getObjectURL(obj.files[i]);
        $("#preview_mult_img_"+fieldName).append("<img  src='"+url+"'>");

    }

}


function toDecimal(x) {
    var f = parseFloat(x);
    if (isNaN(f)) {
        return;
    }
    f = Math.round(x*100)/100;
    return f;
}

function getObjectURL(file) {
    var url = null ;
    // 下面函数执行的效果是一样的，只是需要针对不同的浏览器执行不同的 js 函数而已
    if (window.createObjectURL!=undefined) { // basic
        url = window.createObjectURL(file) ;
    } else if (window.URL!=undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file) ;
    } else if (window.webkitURL!=undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file) ;
    }
    return url ;
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
 var isWinVista= sUserAgent.indexOf("Windows NT 6.0") > -1 || sUserAgent.indexOf("Windows Vista") > -1;
 if (isWinVista) return "Windows Vista";
 var isWin7 = sUserAgent.indexOf("Windows NT 6.1") > -1 || sUserAgent.indexOf("Windows 7") > -1;
 if (isWin7) return "Windows7";
 }
 return "other";
 }

 function isIpad(){
 var ua = navigator.userAgent.toLowerCase();
 var s;
 s = ua.match(/iPad/i);

 if(s=="ipad")
 {
 return true;
 }
 else{
 return false;
 }

 }



//是否是微信浏览
function isWeixin(){

    var ua = navigator.userAgent.toLowerCase();

    if(ua.match(/MicroMessenger/i)=="micromessenger") {

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





function goback() {
    //console.log()
    if(history.length>1){
        history.back(-1);
    }else{
        location.href='/';
    }
    return ;
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


function showBuy() {
    //销毁
    player.dispose();
    $('#J_prismPlayer').empty();
    var course_id=$('#course_id').val();
    var html = '<div class="buy_tip">'+
        '<div class="tip_row1">    试看结束，购买后查看完整课程。<br />       </div>'+
        '<div class="tip_row2">  <a  target="_blank" href="'+URL_USER+'/order/create/course_id/'+course_id+'" class="buy"> 立即购买</a>  </div>'+
        '<div class="refresh"><span>购买后刷新页面即可观看</span> <a href="javascript:location.reload();">已购买，立即刷新</a> </div>'+
        '</div>';
    $('#J_prismPlayer').html(html);
}


function getPlayTime(){
    var tryPlayTime=video_price;
    var currentTime = player.getCurrentTime();

    //区间
    if(typeof(video_price_start)=="undefined"){
        video_price_start=0;
    }
    //if("undefined" != typeof video_price_start) video_price_start=0;
    thresholdValue = 10;
    if( video_price_start) {
        /*alert(currentTime );
        alert(video_price_start);*/
/*console.log(currentTime);
console.log(video_price_start);
console.log(tryPlayTime);*/
        //合法时间区间
        // 1.小于1秒，用于视频缓冲
        // 2.大于等于开始时间
        if(
            currentTime < 6 ||
            (currentTime >=video_price_start-thresholdValue && currentTime < video_price_start+tryPlayTime)
        ){

        }else{
            showBuy();
            clearTimeout(t1);
        }

    }else{
        if(currentTime>tryPlayTime){
            showBuy();
            clearTimeout(t1);
        }
    }


    //console.log(currentTime);
}
function handleReady() {
    var a = player.seek(video_price_start);

    t1 = window.setInterval(getPlayTime,1000);
}

function handlePlay(){

    player.seek(video_price_start);
    t1 = window.setInterval(getPlayTime,1000);
}

function pullDown(controller,pull_element,vue_element){
    var nowPage=1;
    var totalPages=1;
    var nextPage = 1;
    var isLastPage = false;
    var lastRequestPage = 0;
    var vlist = new Vue({
        el: '#'+vue_element,
        data: {
            list: []
        },
        methods: {
            next: function (me) {

                var str=location.href; //取得整个地址栏
                console.log(str);

                var num=str.indexOf("?");
                if(num==-1){
                    str="";
                }
                str=str.substr(num+1);
                console.log(str);
                if(isLastPage){
                    // 锁定
                    me.lock();
                    // 显示无数据
                    me.noData();

                    console.log('最后一页');
                    //$('.dropload-refresh').text('没有了');
                    return;
                }

                if(nextPage == lastRequestPage) { //当前主页页面和上次请求页面相同，重复请求了，直接return
                    return;
                }
                var url="/"+controller+"/?"+str+"&p="+nextPage+"&ret_format=json";
                lastRequestPage = nextPage;
                console.log(nextPage);
                axios.get(url)
                    .then(response => {
                    totalPages = response.data.data.totalPages;
                nowPage = response.data.data.nowPage;
                $('#totalRows').text(response.data.data.totalRows);
                if(nowPage < totalPages) {
                    nextPage = nowPage+1;
                }else{
                    isLastPage = true;
                }
                this.list = this.list.concat(response.data.data.list);


            }
                )
            }
        },
        mounted: function () {
            // this.next();
        },

        filters: {
            course_show: function (value) {
                if (!value) return '';
                return "/course/"+value;
            }
        }



    });


    var dropload = $(pull_element).dropload({
//scrollArea很关键，要不然加载更多不起作用
        scrollArea : window,
        domUp : {
            domClass   : 'dropload-up',
            domRefresh : '<div class="dropload-refresh">↓下拉刷新</div>',
            domUpdate  : '<div class="dropload-update">↑释放更新</div>',
            domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>'
        },
        domDown : {
            domClass   : 'dropload-down',
            domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
            domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
            domNoData  : '<div class="dropload-noData">没有数据了</div>'
        },
        loadUpFn : function(me){
            //下拉刷新需要调用的函数
            //alert("下拉刷新需要调用的函数");
            //重置下拉刷新
            me.resetload();
        },
        loadDownFn : function(me){
            //上拉加载更多需要调用的函数
            //alert("上拉加载更多需要调用的函数");
            vlist.next(me);
            //定时器函数,为了看出上拉加载更多效果
            setTimeout(function(){
                // 每次数据加载完，必须重置
                me.resetload();
            },1000);
        }
    });
}
