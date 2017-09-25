<?php
namespace Uphp\Driver\OpenWeChat;

/**
 * 素材管理
 * Class Material
 * @package Uphp\Driver\OpenWeChat
 */
class Material extends OpenWeChat
{
    /**
     * 新增临时素材 保存3天后media_id失效
     * @param $info POST/FORM
     * @param $type image/voice/video/thumb
     * @return string
     */
    protected function uploadTemp($info, $type){
        $api = "https://api.weixin.qq.com/cgi-bin/media/upload?{$this->access_token}&type={$type}";
        $r = json_decode(curl("POST", $api, $info), true);
        return $r;
    }

    /**
     * 获取临时素材
     * @param $media_id
     * @return mixed
     */
    protected function getTemp($media_id){
        $api = "https://api.weixin.qq.com/cgi-bin/media/get?{$this->access_token}&media_id={$media_id}";
        $r = curl("GET", $api);
        $json = json_decode($r, true);
        if(is_null($json)){
            #   非Json则正确返回图片
            return $r;
        }else{
            #   Json则错误或返回视频素材 "video_url":DOWN_URL
            return $json;
        }
    }

    /**
     * 新增永久图文素材
     */
    protected function uploadNews(){

    }

    /**
     * 新增永久素材 图文消息素材、图片素材上限为5000，其他类型为1000
     * @param $info POST/FORM
     * @param $type image/voice/video/thumb
     * @return string
     */
    protected function uploadForever($info, $type){
        $api = "https://api.weixin.qq.com/cgi-bin/material/add_material?{$this->access_token}&type={$type}";
        $r = json_decode(curl("POST", $api, $info), true);
        return $r;
    }

    /**
     * 获取永久素材
     * @param $media_id
     * @return mixed
     */
    protected function getForever($media_id){
        $api = "https://api.weixin.qq.com/cgi-bin/material/get_material?{$this->access_token}";
        $info = '{"media_id": "'.$media_id.'"}';
        $r = curl("POST", $api, $info);
        return $r;
    }

    /**
     * 删除永久素材
     * @param $media_id
     * @return mixed
     */
    protected function delForever($media_id){
        $api = "https://api.weixin.qq.com/cgi-bin/material/del_material?{$this->access_token}";
        $info = '{"media_id": "'.$media_id.'"}';
        $r = curl("POST", $api, $info);
        return $r;
    }

    /**
     * 修改永久图文
     * @param $info
     * @return mixed
     */
    protected function updateForever($info){
        $api = "https://api.weixin.qq.com/cgi-bin/material/update_news?{$this->access_token}&type={$type}";
        $r = json_decode(curl("POST", $api, $info), true);
        return $r;
    }

    /**
     * 获取永久素材总数
     */
    protected function getForeverCount(){
        $api = "https://api.weixin.qq.com/cgi-bin/material/get_materialcount?{$this->access_token}";
        return json_decode(curl("GET", $api), true);
    }

    /**
     * 获取素材列表
     */
    protected function getForeverList($info){
        $api = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?{$this->access_token}";
        return json_decode(curl("POST", $api, json_encode($info)), true);
    }
}