<?php
namespace Uphp\Driver\OpenWeChat;
/**
 * 客服管理
 * Class CustomService
 * @package Uphp\Driver\OpenWeChat
 */
class CustomService extends OpenWeChat
{
    /**
     * 添加客服账号
     */
    protected function add($info){
        $api = "https://api.weixin.qq.com/customservice/kfaccount/add?".$this->access_token;
        $r = curl("POST", $api, json_encode($info));
        if(json_decode($r, true)['errcode'] == 0){
            return true;
        }else{
            return $r;
        }
    }

    protected function del($info){
        $api = "https://api.weixin.qq.com/customservice/kfaccount/del?".$this->access_token;
        $r = curl("POST", $api, json_encode($info));
        if(json_decode($r, true)['errcode'] == 0){
            return true;
        }else{
            return false;
        }
    }

    protected function update($info){
        $api = "https://api.weixin.qq.com/customservice/kfaccount/update?".$this->access_token;
        $r = curl("POST", $api, json_encode($info));
        if(json_decode($r, true)['errcode'] == 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取所有客服账号
     */
    protected function getList(){
        $api = "https://api.weixin.qq.com/cgi-bin/customservice/getkflist?".$this->access_token;
        return curl("GET", $api);
    }
    /**
     * Todo:上传客服头像
     */
    protected function uploadHeadImg(){
        $api = "http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token=ACCESS_TOKEN&kf_account=KFACCOUNT";
    }

}