<?php

namespace Common\Controller;

trait Course
{

    //链接外部视频
    function link()
    {
        if (IS_GET) {
            $this->toview();
        } else {
            $source_url = I('source_url', '', 'trim');
            $source_url = str_replace(["\r\n", "\r"], ["\n", "\n"], $source_url);
            $urls = explode("\n", $source_url);
            $urls = array_filter($urls, "trim");
            $thirdparty = new \Common\ThirdpartyVideo();
            foreach ($urls as $k => $v) {
                $url = trim($v);
                $info =  $thirdparty->getVideoInfo($url);
                $data = [];
                $data['category_id'] = I('category_id', 7);
                $data['title'] = $info['title'];
                $data['description'] = $info['description'];
                $data['keywords'] = $info['keywords'];
                $data['price'] = 0;
                $data['effective_days'] = 3650;
                $course_id = $this->m->add($data);


                $m = M('video');
                $dataVideo = [];
                $dataVideo['user_id'] = $this->user_id;
                $dataVideo['course_id'] = $course_id;
                $dataVideo['title'] = $info['title'];
                $dataVideo['description'] = $info['description'];
                $dataVideo['url'] = $url;
                if (false !== $m->create($dataVideo)) {
                    $id = $m->add();

                    //保存关联
                    $cvData = [];
                    $cvData['course_id'] = $dataVideo['course_id'];
                    $cvData['video_id'] = $id;
                    M('CourseVideo')->add($cvData);

                }
            }
        }
    }

    function addLinkVideo(){

    }

}



