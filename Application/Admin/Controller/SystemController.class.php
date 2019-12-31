<?php
namespace Admin\Controller;
class SystemController extends BaseController
{

    function delRuntimeTemp(){
        //rmdir(RUNTIME_PATH)
        $dirTemp = RUNTIME_PATH."/Temp";
        array_map('unlink', glob("$dirTemp/*"));
        $this->success('清除缓存成功');
        //rmdir($dirTemp);//只能删除非空目录
    }

    /**
     * 用于处理队列
     * 必须定义接受参数，否则接受不到列表分发器传过来的参数
     * @param $content

     */
    function alarm(string $content){
        try{
            //发短信提示课程拥有者

            $mobile = '';
            $course_id = 111;
            $content = cn_substr_utf8($content,40);
            $template_id = 'SMS_134';

            $d = [];
            $d['mobile'] = $mobile;
            $d['content'] = "content:{$content} course_id:{$course_id}";
            $d['ip'] = get_client_ip();
            $sms_id = M('SmsQueue')->add($d);
            $r = send_sms_system($mobile, ['course_id'=>$course_id,'content'=>$content],$template_id,$sms_id);
        }catch (\Exception $e){
            tplog('新评论提示符短信发送失败');
        }
    }


}
