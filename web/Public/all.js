$(function(){$(".change_content .li_box:gt(0)").hide();$(".jiaocheng_tit_box a").click(function(){$(".jiaocheng_tit_box a").removeClass("on");$(this).addClass("on");var values=$(this).index();$(".change_content .li_box").hide();$(".change_content .li_box").eq(values).show();});});$(function(){$(".curriculum_list").hover(function(){$(this).children(".sel_list").toggle();});});function G(e){return document.getElementById(e);}
function showTip(info){G('tips').innerHTML=info;}
function sendForm(formId,action,response,target,effect){if(CheckForm(G(formId),'ThinkAjaxResult'))
{ThinkAjax.sendForm(formId,action,response);}}
rowIndex=0;function prepareIE(height,overflow){bod=document.getElementsByTagName('body')[0];bod.style.height=height;htm=document.getElementsByTagName('html')[0];htm.style.height=height;}
function hideSelects(visibility){selects=document.getElementsByTagName('select');for(i=0;i<selects.length;i++){selects[i].style.visibility=visibility;}}
function showPopWin(content,width,height){prepareIE('100%','hidden');window.scrollTo(0,0);hideSelects('hidden');G('overlay').style.display='block';var arrayPageSize=getPageSize();var arrayPageScroll=getPageScroll();G('lightbox').style.display='block';G('lightbox').style.top=(arrayPageScroll[1]+((arrayPageSize[3]-35-height)/2)+'px');G('lightbox').style.left=(((arrayPageSize[0]-25-width)/2)+'px');G('lightbox').innerHTML=content;}
function fleshVerify(){var timenow=new Date().getTime();G('verifyImg').src=APP+'/Public/verify/'+timenow;}
function allSelect(){var colInputs=document.getElementsByTagName("input");for(var i=0;i<colInputs.length;i++)
{colInputs[i].checked=true;}}
function allUnSelect(){var colInputs=document.getElementsByTagName("input");for(var i=0;i<colInputs.length;i++)
{colInputs[i].checked=false;}}
function InverSelect(){var colInputs=document.getElementsByTagName("input");for(var i=0;i<colInputs.length;i++)
{colInputs[i].checked=!colInputs[i].checked;}}
function WriteTo(id){var type=$F('outputType');switch(type)
{case'EXCEL':WriteToExcel(id);break;case'WORD':WriteToWord(id);break;}
return;}
function build(id){window.location=APP+'/Card/batch/type/'+id;}
function shortcut(){var name=window.prompt("输入该快捷方式的显示名称","");if(name!=null)
{var url=location.href;ThinkAjax.send(location.protocol+'//'+location.hostname+APP+'/Shortcut/ajaxInsert/','ajax=1&name='+name+'&url='+url);}}
function delcache(){ThinkAjax.send(location.protocol+'//'+location.hostname+APP+'/Common/clearcache/','ajax=1');window.location.reload();}
function show(){if(document.getElementById('menu').style.display!='none')
{document.getElementById('menu').style.display='none';document.getElementById('main').className='full';}else{document.getElementById('menu').style.display='inline';document.getElementById('main').className='main';}}
function CheckAll(strSection)
{var i;var colInputs=document.getElementById(strSection).getElementsByTagName("input");for(i=1;i<colInputs.length;i++)
{colInputs[i].checked=colInputs[0].checked;}}
function add(id){if(id)
{location.href=CONTROLLER+"/add/id/"+id;}else{location.href=CONTROLLER+"/add/";}}
function showHideSearch(){if(document.getElementById('searchM').style.display=='inline')
{document.getElementById('searchM').style.display='none';document.getElementById('showText').value='高级';document.getElementById('key').style.display='inline';}else{document.getElementById('searchM').style.display='inline';document.getElementById('showText').value='隐藏';document.getElementById('key').style.display='none';}}
function top2(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择置顶项！');return false;}
location.href=CONTROLLER+"/top/id/"+keyValue;}
function unTop(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择置顶项！');return false;}
location.href=CONTROLLER+"/unTop/id/"+keyValue;}
function sort(id){var keyValue;keyValue=getSelectCheckboxValues();location.href=CONTROLLER+"/sort/sortId/"+keyValue;}
function high(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择高亮项！');return false;}
location.href=CONTROLLER+"/high/id/"+keyValue;}
function recommend(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择推荐项！');return false;}
location.href=CONTROLLER+"/recommend/id/"+keyValue;}
function unrecommend(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择项目！');return false;}
location.href=CONTROLLER+"/unrecommend/id/"+keyValue;}
function pass(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择审核项！');return false;}
if(window.confirm('确实审核通过吗？'))
{window.location.href=CONTROLLER+'/checkPass/id/'+keyValue;}}
function passs(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择审核项！');return false;}
if(window.confirm('确实审核通过吗？'))
{window.location.href=CONTROLLER+'/checkPasss/id/'+keyValue;}}
function sortBy(field,sort){location.href="?_order="+field+"&_sort="+sort;}
function cache(){ThinkAjax.send(CONTROLLER+'/cache','ajax=1');}
function forbid(id){location.href=CONTROLLER+"/forbid/id/"+id;}
function recycle(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValue();}
if(!keyValue)
{alert('请选择要还原的项目！');return false;}
location.href=CONTROLLER+"/recycle/id/"+keyValue;}
function resume(id){location.href=CONTROLLER+"/resume/id/"+id;}
function trace(id){location.href=CONTROLLER+"/trace/id/"+id;}
function output(){location.href=CONTROLLER+"/output/";}
function member(id){location.href=CONTROLLER+"/../Member/edit/id/"+id;}
function chat(id){location.href=CONTROLLER+"/../Chat/index/girlId/"+id;}
function login(id){location.href=CONTROLLER+"/../Login/index/type/4/id/"+id;}
function child(id){location.href=CONTROLLER+"/index/pid/"+id;}
function action(id){location.href=CONTROLLER+"/action/groupId/"+id;}
function access(id){location.href=CONTROLLER+"/access/id/"+id;}
function app(id){location.href=CONTROLLER+"/app/groupId/"+id;}
function module(id){location.href=CONTROLLER+"/module/groupId/"+id;}
function addv(id){location.href=CONTROLLER+"/addv/id/"+id;}
function user(id){location.href=CONTROLLER+"/user/id/"+id;}
function addVideo(id){window.open("/video/add/course_id/"+id);}
function selectVideo(id){location.href="/video/select/course_id/"+id;}
function reeditVideo(id){window.open("/video/add/id/"+id+"?reedit=1");}
function linkVideo(id){window.open("/video/link/course_id/"+id);}
function addComment(id){window.open("/comment/add/course_id/"+id);}
function videoManage(id){window.open("/video/index/course_id/"+id);}
function previewCourse(id){window.open(URL_WWW+"/course/show/id/"+id);}
function previewVideo(id){window.open("/video/show/id/"+id);}
function viewComment(course_id){if(!course_id)return false;window.open(URL_WWW+"/course/"+course_id+'#homework');}
function addOldUserBalance(id){window.open("/oldUserBalance/initNewUser?user_id="+id);}
function PopModalWindow(url,width,height)
{var result=window.showModalDialog(url,"win","dialogWidth:"+width+"px;dialogHeight:"+height+"px;center:yes;status:no;scroll:no;dialogHide:no;resizable:no;help:no;edge:sunken;");return result;}
function read(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValue();}
if(!keyValue)
{alert('请选择编辑项！');return false;}
location.href=CONTROLLER+"/read/id/"+keyValue;}
function getData(){var data=$('#form').serialize();if(data){data+="&ajax=1";}else{data="ajax=1";}
return data;}
function save(id){var url=CONTROLLER+"/save";var data=getData();$.post(url,data,function(response){alert(response.info);window.location="/index.php?s=/User/Family/index.html";})}
function del(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择删除项！');return false;}
if(window.confirm('确实要删除选择项吗？'))
{ThinkAjax.send(CONTROLLER+"/delete/","id="+keyValue+'&ajax=1',doDelete);}}
function edit(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValue();}
if(!keyValue)
{alert('请选择编辑项！');return false;}
window.open(CONTROLLER+"/edit/id/"+keyValue);}
function view(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValue();}
if(!keyValue)
{alert('请选择查看项！');return false;}
domain="rrbrr.com";subdomain="www.";location.href="http://"+subdomain+domain+CONTROLLER+"/show/id/"+keyValue;}
function grades(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValue();}
if(!keyValue)
{alert('请选择编辑项！');return false;}
location.href=CONTROLLER+"/grades/id/"+keyValue;}
function addmoney(id){location.href=CONTROLLER+"/addmoney/id/"+id;}
var selectRowIndex=Array();function del(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择删除项！');return false;}
if(window.confirm('确实要删除选择项吗？'))
{ThinkAjax.send(CONTROLLER+"/delete/","id="+keyValue+'&ajax=1',doDelete);}}
function delcontent(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择删除项！');return false;}
if(window.confirm('确实要删除选择项吗？'))
{ThinkAjax.send(CONTROLLER+"/delcontent/","id="+keyValue+'&ajax=1',doDelete);}}
function delsummary(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择删除项！');return false;}
if(window.confirm('确实要删除选择项吗？'))
{ThinkAjax.send(CONTROLLER+"/delsummary/","id="+keyValue+'&ajax=1',doDelete);}}
function delexamples(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择删除项！');return false;}
if(window.confirm('确实要删除选择项吗？'))
{ThinkAjax.send(CONTROLLER+"/delexamples/","id="+keyValue+'&ajax=1',doDelete);}}
function foreverdel(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择删除项！');return false;}
if(window.confirm('确实要永久删除选择项吗？'))
{ThinkAjax.send(CONTROLLER+"/foreverdelete/","id="+keyValue,doDelete);}}
function getTableRowIndex(obj){selectRowIndex[0]=obj.parentElement.parentElement.rowIndex;}
function doDelete(data,status){console.log(data);if(data.code==1)
{alert('删除成功');window.location.reload();return;var Table=G('checkList');var len=selectRowIndex.length;if(len==0){window.location.reload();}
for(var i=len-1;i>=0;i--)
{Table.deleteRow(selectRowIndex[i]);}
selectRowIndex=Array();}else{alert('删除失败');}}
function delAttach(id,showId){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择删除项！');return false;}
if(window.confirm('确实要删除选择项吗？'))
{G('result').style.display='block';ThinkAjax.send(CONTROLLER+"/delAttach/","id="+keyValue+'&_AJAX_SUBMIT_=1');if(showId!=undefined)
{G(showId).innerHTML='';}}}
function clearData(){if(window.confirm('确实要清空全部数据吗？'))
{location.href=CONTROLLER+"/clear/";}}
function takeback(id){var keyValue;if(id)
{keyValue=id;}else{keyValue=getSelectCheckboxValues();}
if(!keyValue)
{alert('请选择回收项！');return false;}
if(window.confirm('确实要回收选择项吗？'))
{location.href=CONTROLLER+"/takeback/id/"+keyValue;}}
function getSelectCheckboxValue(){var obj=document.getElementsByName('key');var result='';for(var i=0;i<obj.length;i++)
{if(obj[i].checked==true)
return obj[i].value;}
return false;}
function getSelectCheckboxValues(){var obj=document.getElementsByName('key');var result='';var j=0;for(var i=0;i<obj.length;i++)
{if(obj[i].checked==true){selectRowIndex[j]=i+1;result+=obj[i].value+",";j++;}}
return result.substring(0,result.length-1);}
function change(e)
{if(!document.all)
{return;}
var e=e||event;var oObj=e.srcElement||e.target;var obj=document.getElementById('checkList').getElementsByTagName("input");var oTr=oObj.parentNode;var row=oObj.parentElement.rowIndex-1;if(oTr.className=='down')
{oTr.className='out';obj[row].checked=false;oTr.tag=true;}else{oTr.className='down';obj[row].checked=true;oTr.tag=true;}}
function out(e)
{var e=e||event;var oObj=e.srcElement||e.target;var oTr=oObj.parentNode;if(!oTr.tag)
oTr.className="out";}
function over(e)
{var e=e||event;var oObj=e.srcElement||e.target;var oTr=oObj.parentNode;if(!oTr.tag)
oTr.className="over";}
function searchItem(item){for(i=0;i<selectSource.length;i++)
if(selectSource[i].text.indexOf(item)!=-1)
{selectSource[i].selected=true;break;}}
function addItem(){for(i=0;i<selectSource.length;i++)
if(selectSource[i].selected){selectTarget.add(new Option(selectSource[i].text,selectSource[i].value));}
for(i=0;i<selectTarget.length;i++)
for(j=0;j<selectSource.length;j++)
if(selectSource[j].text==selectTarget[i].text)
selectSource[j]=null;}
function delItem(){for(i=0;i<selectTarget.length;i++)
if(selectTarget[i].selected){selectSource.add(new Option(selectTarget[i].text,selectTarget[i].value));}
for(i=0;i<selectSource.length;i++)
for(j=0;j<selectTarget.length;j++)
if(selectTarget[j].text==selectSource[i].text)selectTarget[j]=null;}
function delAllItem(){for(i=0;i<selectTarget.length;i++){selectSource.add(new Option(selectTarget[i].text,selectTarget[i].value));}
selectTarget.length=0;}
function addAllItem(){for(i=0;i<selectSource.length;i++){selectTarget.add(new Option(selectSource[i].text,selectSource[i].value));}
selectSource.length=0;}
function getReturnValue(){for(i=0;i<selectTarget.length;i++){selectTarget[i].selected=true;}}
function loadBar(fl)
{var x,y;if(self.innerHeight)
{x=self.innerWidth;y=self.innerHeight;}
else
if(document.documentElement&&document.documentElement.clientHeight)
{x=document.documentElement.clientWidth;y=document.documentElement.clientHeight;}
else
if(document.body)
{x=document.body.clientWidth;y=document.body.clientHeight;}
var el=document.getElementById('loader');if(null!=el)
{var top=(y/2)-50;var left=(x/2)-150;if(left<=0)left=10;el.style.visibility=(fl==1)?'visible':'hidden';el.style.display=(fl==1)?'block':'none';el.style.left=left+"px"
el.style.top=top+"px";el.style.zIndex=2;}}
function selectByValue(element,v){var o=document.getElementById(element).options;if(o){for(var i=0;i<o.length;i++){if(o[i].value==v){o[i].selected=true;}}}}
function setValue(id,v){document.getElementById(id).value=v;}
function showProvince(name){var i=0;data2=province_node;for(var k in data2){document.getElementById(name).options[i]=new Option(data2[k],data2[k]);i++;}}
function showCity(name,province){province=getProvinceKey(province);document.getElementById(name).options.length=0;for(var k in city_node){s=k-province;if(s>0&&s<10000){document.getElementById(name).options.add(new Option(city_node[k]['title'],city_node[k]['title']));}}}
function getProvinceKey(province){for(var k in province_node){if(province_node[k]==province)
return k;}}
function loadProvinceCicy(province,city){showProvince(province);document.getElementById(province).onchange=function(){showCity(city,this.value);}}
function fileChange(k,obj){var imgid="img_"+k;var formid="form_"+k;document.getElementById(imgid).src=obj.value;document.getElementById(formid).submit();}
function equalHight(a,b){ah=G(a).offsetHeight;bh=G(b).offsetHeight;if(ah<bh){G(a).style.height=bh+"px";}else{G(b).style.height=ah+"px";}}
function g(name){var is=document.getElementsByName(name);var ids=new Array();var j=0;for(var i=0;i<is.length;++i){if(is[i].type=='checkbox'&&is[i].checked){ids[j++]=is[i].value;}}
return ids;}
function getJoinValue(){var v='';$(":checkbox:checked").each(function(){if(this.value)
v+=this.value+',';});if(v)
return v.substr(0,v.length-1);}
function ajaxGet(url,ids){if(!ids){ids=getJoinValue();}
url=url+ids+"/ajax/1";if(ids){$.get(url,function(data){d=eval('('+data+')');if(typeof(d)=='object'){alert(d.info);}else{alert(data);}});}else{alert('请先选择');}}
function chkall(n){var l=document.getElementsByName(n);for(i=0;i<l.length;i++){l[i].checked=true;}}
function chkallno(n){var l=document.getElementsByName(n);for(i=0;i<l.length;i++){l[i].checked=false;}}
function get(url,param,handler){try{$.ajaxSetup({error:function(x,e){console.log('没有内容');return false;}});$.getJSON(url,param,handler);}catch(ex){console.log('异常内容');}}
function post(url,param,handler){try{$.ajaxSetup({error:function(x,e){console.log('服务器响应错误');return false;}});$.post(url,param,handler,"json");}catch(ex){console.log('异常内容');}}
function post_cross(url,param,handler){try{param['ret_format']='json';$.ajax({type:"POST",url:url,data:param,xhrFields:{withCredentials:true},crossDomain:true,success:handler,error:function(x,e){console.log('服务器响应错误');return false;}});}catch(ex){console.log('异常内容');}}
function checkCode(data){console.log(data);if(data.code==0){msg(data.msg);return false;}
return true;}
var ThinkAjax={send:function(url,pars,response){url=url+"?"+pars;data={};$.getJSON(url,data,response);},other:function(){}}
function msg(data){alert(data);}
function getCookie(c_name)
{if(document.cookie.length>0)
{c_start=document.cookie.indexOf(c_name+"=")
if(c_start!=-1)
{c_start=c_start+c_name.length+1;c_end=document.cookie.indexOf(";",c_start);if(c_end==-1)
{c_end=document.cookie.length;}
return unescape(document.cookie.substring(c_start,c_end));}}
return null}
function setCookie(c_name,value,expiredays)
{var exdate=new Date();exdate.setDate(exdate.getDate()+expiredays);document.cookie=c_name+"="+escape(value)+((expiredays==null)?"":";expires="+exdate.toGMTString());}
function previewImg(obj,fieldName){url=getObjectURL(obj.files[0]);$("#preview_img_"+fieldName+" img").attr("src",url);}
function previewMultImg2(obj,fieldName){var count=obj.files.length;if(count<1)return;for(var i=0;i<count;i++){console.log(obj.files);url=getObjectURL(obj.files[i]);$("#preview_mult_img_"+fieldName).append("<img  src='"+url+"'>");}}
function toDecimal(x){var f=parseFloat(x);if(isNaN(f)){return;}
f=Math.round(x*100)/100;return f;}
function getObjectURL(file){var url=null;if(window.createObjectURL!=undefined){url=window.createObjectURL(file);}else if(window.URL!=undefined){url=window.URL.createObjectURL(file);}else if(window.webkitURL!=undefined){url=window.webkitURL.createObjectURL(file);}
return url;}
function detectOS(){var sUserAgent=navigator.userAgent;var isWin=(navigator.platform=="Win32")||(navigator.platform=="Windows");var isMac=(navigator.platform=="Mac68K")||(navigator.platform=="MacPPC")||(navigator.platform=="Macintosh")||(navigator.platform=="MacIntel");if(isMac)return"MacOS";var isUnix=(navigator.platform=="X11")&&!isWin&&!isMac;if(isUnix)return"Unix";var isLinux=(String(navigator.platform).indexOf("Linux")>-1);if(isLinux)return"Linux";if(isWin){var isWin2K=sUserAgent.indexOf("Windows NT 5.0")>-1||sUserAgent.indexOf("Windows 2000")>-1;if(isWin2K)return"Windows2000";var isWinXP=sUserAgent.indexOf("Windows NT 5.1")>-1||sUserAgent.indexOf("Windows XP")>-1;if(isWinXP)return"WindowsXP";var isWin2003=sUserAgent.indexOf("Windows NT 5.2")>-1||sUserAgent.indexOf("Windows 2003")>-1;if(isWin2003)return"Windows2003";var isWinVista=sUserAgent.indexOf("Windows NT 6.0")>-1||sUserAgent.indexOf("Windows Vista")>-1;if(isWinVista)return"Windows Vista";var isWin7=sUserAgent.indexOf("Windows NT 6.1")>-1||sUserAgent.indexOf("Windows 7")>-1;if(isWin7)return"Windows7";}
return"other";}
function isIpad(){var ua=navigator.userAgent.toLowerCase();var s;s=ua.match(/iPad/i);if(s=="ipad")
{return true;}
else{return false;}}
function isWeixin(){var ua=navigator.userAgent.toLowerCase();if(ua.match(/MicroMessenger/i)=="micromessenger"){return true;}else{return false;}}
function isWebp(){var isSupportWebp=!![].map&&document.createElement('canvas').toDataURL('image/webp').indexOf('data:image/webp')==0;return isSupportWebp;}
$.fn.serializeObject=function()
{var o={};var a=this.serializeArray();$.each(a,function(){if(o[this.name]!==undefined){if(!o[this.name].push){o[this.name]=[o[this.name]];}
o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};function goback(){if(history.length>1){history.back(-1);}else{location.href='/';}
return;var ref=$("#hd_referrer").val();if(ref!=""&&ref!="undefined"){location.href=ref;}
else{location.href=history.back(-1);}}
$(function(){$("#hd_referrer").val(document.referrer);$('#back').click(function(){goback();});});function showBuy(){player.dispose();$('#J_prismPlayer').empty();var course_id=$('#course_id').val();var html='<div class="buy_tip">'+'<div>    试看结束，如果需要继续观看，请购买课程。<br />       </div>'+'<div>  <a  target="_blank" href="'+URL_USER+'/order/create/course_id/'+course_id+'" class="buy"> 立即购买</a>  </div>'+'<div class="refresh"><span>购买后刷新页面即可观看</span> <a href="javascript:location.reload();">已购买，立即刷新</a> </div>'+'</div>';$('#J_prismPlayer').html(html);}
function getPlayTime(){var tryPlayTime=video_price;var currentTime=player.getCurrentTime();if(currentTime>tryPlayTime){showBuy();clearTimeout(t1);}}
function handleReady(){t1=window.setInterval(getPlayTime,1000);}