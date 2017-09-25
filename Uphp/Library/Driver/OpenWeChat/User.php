<?php
namespace Uphp\Driver\OpenWeChat;

/**
 * 用户管理
 * Class User
 * @package Uphp\Driver\OpenWeChat
 */
class User extends OpenWeChat
{
    /**
     * 创建标签
     */
    protected function tagsCreate($tagName){
        $api = "https://api.weixin.qq.com/cgi-bin/tags/create?".$this->access_token;
        $info = [
            "tag" => [
                "name" => $tagName,
            ]
        ];
        $r = curl("POST", $api, json_encode($info, JSON_UNESCAPED_UNICODE), true);
        return $r;
    }

    /**
     * 获取已创建的标签
     */
    protected function tagsGet(){
        $api = "https://api.weixin.qq.com/cgi-bin/tags/get?".$this->access_token;
        return curl("GET", $api, null, true);
    }

    /**
     * 编辑标签
     */
    protected function tagsUpdate(){

    }

    /**
     * 删除标签
     */
    protected function tagsDelete($tagId){
        $api = "https://api.weixin.qq.com/cgi-bin/tags/delete?".$this->access_token;
        $info = [
            "tag" => [
                "id" => $tagId,
            ]
        ];
        return curl("POST", $api, $info, true);
    }

    /**
     * 获取标签下用户
     */
    protected function tagsUser(){

    }

    /**
     * 为用户打标签
     */
    protected function userAddTags(){

    }

    /**
     * 为用户取消标签
     */
    protected function userDelTags(){

    }

    /**
     * 获取用户身上的标签列表
     */
    protected function getUserTags(){

    }

    /**
     * 设置用户备注名
     */
    protected function setMark(){

    }

    #   获取用户基本信息
    /**
     * 获取用户基本信息
     */
    protected function getInfo(){

    }

    /**
     * 批量获取用户基本信息
     */
    protected function getInfos(){

    }

    #   获取用户列表

    /**
     * 获取用户列表
     */
    protected function get(){

    }

    #   获取用户地理位置（每次进入公众号则push一个Event、Location）

    #   黑名单管理
    /**
     * 获取黑名单列表
     */
    protected function blackList(){

    }

    /**
     * 拉黑
     */
    protected function setBlack(){

    }

    /**
     * 取消拉黑
     */
    protected function unsetBlack(){

    }
}