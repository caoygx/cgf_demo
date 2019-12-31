<?php
namespace Common;
//use Think;
//include_once ROOT.'/aliyun-vod/aliyun-php-sdk-core/Config.php';
//use vod\Request\V20170321 as vod;

class Aliyunvod  {

    private $client;
    private $regionId;
    function __construct()
    {

        Vendor('aliyun-vod.aliyun-php-sdk-core.Config');
        $access_key_id = 'LTAIBBPahuNaJzfu';
        $access_key_secret = 'EBC4JTdwhtGCWnAHRY5Up6zDufbxuy';
        $regionId = 'cn-shanghai';
        $this->regionId = $regionId;
        $profile = \DefaultProfile::getProfile($regionId, $access_key_id, $access_key_secret);
        $this->client = new \DefaultAcsClient($profile);

    }

    function get_video_playauth($VideoId) {
        $regionId = 'cn-shanghai';
        $access_key_id = 'LTAIBBPahuNaJzfu';
        $access_key_secret = 'EBC4JTdwhtGCWnAHRY5Up6zDufbxuy';
        $profile = \DefaultProfile::getProfile($regionId, $access_key_id, $access_key_secret);
        $client = new \DefaultAcsClient($profile);

        $request = new \vod\Request\V20170321\GetVideoPlayAuthRequest();
        $request->setAcceptFormat('JSON');
        $request->setRegionId($regionId);
        //$VideoId = 'b5a7a26c9b4c4022b07167e08ed5a2ad';
        $request->setVideoId($VideoId);            //视频ID
        $response = [];
        try{
            $response = $client->getAcsResponse($request);
        }catch (\Exception $e){
            var_dump($response);
            var_dump($e->getMessage());
            return false;
        }
        return $response;
    }



    function create_upload_video() {
        $access_key_id = 'LTAIBBPahuNaJzfu';
        $access_key_secret = 'EBC4JTdwhtGCWnAHRY5Up6zDufbxuy';
        $regionId = 'cn-shanghai';
        $profile = \DefaultProfile::getProfile($regionId, $access_key_id, $access_key_secret);
        $client = new \DefaultAcsClient($profile);

        $request = new \vod\Request\V20170321\CreateUploadVideoRequest();
        $request->setAcceptFormat('JSON');
        $request->setRegionId($regionId);
        $request->setTitle("视频标题");
        //视频源文件名称(必须包含扩展名)
        $request->setFileName("文件名称.mov");
        //视频源文件字节数
        $request->setFileSize(0);
        $request->setDescription("视频描述");
        //自定义视频封面URL地址
        $request->setCoverURL("http://cover.sample.com/sample.jpg");
        //上传所在区域IP地址
        $request->setIP("127.0.0.1");
        $request->setTags("标签1,标签2");
        //视频分类ID
        $request->setCateId(0);
        $response = $client->getAcsResponse($request);
        //$this->success($response);
        //var_dump($response);exit;
        return $response;
    }


    function refresh_upload_video() {
        $VideoId = I('VideoId');
        $access_key_id = 'LTAIBBPahuNaJzfu';
        $access_key_secret = 'EBC4JTdwhtGCWnAHRY5Up6zDufbxuy';
        $regionId = 'cn-shanghai';
        $profile = \DefaultProfile::getProfile($regionId, $access_key_id, $access_key_secret);
        $client = new \DefaultAcsClient($profile);

        $request = new \vod\Request\V20170321\RefreshUploadVideoRequest();
        $request->setAcceptFormat('JSON');
        $request->setRegionId($regionId);
        $request->setVideoId($VideoId);
        $response = $client->getAcsResponse($request);
        $this->success($response);
        var_dump($response);exit;
        return $response;
    }

    function success($data){
        $ret = [];
        $ret['code'] = 1;
        $ret['msg'] = 'success';
        $ret['data'] = $data;
        echo json_encode($ret,JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 获取视频时长
     * @param $videoId
     * @return int 单位秒
     */
    function getVideoInfo($videoId){
        //$videoId = '74bc8b8d31dc4b1e9fffb7fd8001cc97';

        $request = new \vod\Request\V20170321\GetVideoInfoRequest();
        $request->setAcceptFormat('JSON');
        $request->setVideoId($videoId);
        $response = $this->client->getAcsResponse($request);
        $info = $response->Video;
        return $info;

        /*
         控制器其实不应该直接调用view模板，应该返回数据，同各view渲染层去渲染需要的格式
        在普通开发中，直接调用模板，没什么问题，但做自动单元测试时就蛋疼了

        一系列赋值
         */
        /*$this->assign('xx','xx');
        $this->assign('xx','xx');
        $this->assign('xx','xx');*/

        //直接返回赋值，由view去决定怎么显示，是展现出html,wap,json或者xml
        //return $data;



    }

    function delete($videoId){

        $request = new vod\DeleteVideoRequest();
        $request->setAcceptFormat('JSON');
        $request->setVideoIds($videoId);
        try{
            $response = $this->client->getAcsResponse($request);
            if($response->RequestId){
                return true;
                echo '成功';
            }
            var_dump($response);
        }catch (\Exception $e){
            if(APP_DEBUG){
                throw $e;
            }else{
                echo $e->getMessage();
            }
            return false;
        }

        /*  $testData = [];
          $testData['lastSql'] = $mVideo->getLastSql();//只返回给自动测试的数据
          $this->success([]);*/

    }

    function clipVideo(array $video){

        $video_id = $video['video_id'];
        $in = $video['try_play_start'];
        $out = $in+$video['try_play_length'];
        $title = $video['title']."_试看";

        $request = new \vod\Request\V20170321\ProduceEditingProjectVideoRequest();
        $request->setAcceptFormat('JSON');
        $request->setRegionId($this->regionId);
        $request->setTitle($title);

        //$VideoTrackClips = [];
        $material=[];
        $material['VideoId'] = $video_id;//"ca14c9d9d800483ab09061ab2990e1fb";
        $material['In'] = $in;//30;
        $material['Out'] = $out;//40;
        //$VideoTrackClips[] = $material;

        $timeline = [
            "VideoTracks"=>[
                [
                    "VideoTrackClips"=>[
                        $material
                    ]
                ]
            ]
        ];

        $timeline = json_encode($timeline);
        //echo $timeline;//exit;

        $request->setTimeline($timeline);
        //$VideoId = 'b5a7a26c9b4c4022b07167e08ed5a2ad';
        $response = [];
        try{
            $response = $this->client->getAcsResponse($request);
            //var_dump($response);
            return $response;
        }catch (\Exception $e){
            echo "video_id".$video_id;
            var_dump($e->getMessage());
            return false;
        }
        return $response;
    }

    function getPlayUrl($VideoId){


        $request = new \vod\Request\V20170321\GetPlayInfoRequest();
        $request->setAcceptFormat('JSON');
        $request->setVideoId($VideoId);
        try {
            $urls = [];
            $response = $this->client->getAcsResponse($request);
            $playList = $response->PlayInfoList->PlayInfo;
            foreach ($playList as $k => $v) {
                $urls[$v->Format][$v->Definition] = $v->PlayURL;

            }
        }catch (\Exception $e){
            var_dump($e->getMessage());
            return false;
        }
        return $urls;

    }


}