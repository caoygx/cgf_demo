<?php
namespace Org\Util;
class Alarm{


	function send($content){
        try{
            //发短信提示课程拥有者
            //$mobile = getMobileOfCourseOwner();
            $mobile = '13162836361';
            $course_id = 111;
            $content = cn_substr_utf8($content,40);
            $template_id = 'SMS_134325395';

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
