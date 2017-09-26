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
        $api = "https://api.weixin.qq.com/cgi-bin/tags/update?".$this->access_token;
        return curl("GET", $api, null, true);
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
     * 获取标签下粉丝列表
     *
     */
    protected function tagsUser($tagId, $openId = null){
        $api = "https://api.weixin.qq.com/cgi-bin/user/tag/get?".$this->access_token;
        $info = [
            "tag" => [
                "id" => $tagId,
                "next_openid" => $openId
            ]
        ];
        return curl("POST", $api, $info, true);
    }

    /**
     * 为用户打标签
     * 最多20个
     * @param $openId Array 数组形式
     */
    protected function userAddTags($openId, $tagId){
        $api = "https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?".$this->access_token;
        $info = [
            "openid_list" => $openId,
            "tagid" => $tagId,
        ];
        return curl("POST", $api, $info, true);
    }

    /**
     * 为用户取消标签
     */
    protected function userDelTags($openId, $tagId){
        $api = "https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?".$this->access_token;
        $info = [
            "openid_list" => $openId,
            "tagid" => $tagId,
        ];
        return curl("POST", $api, $info, true);
    }

    /**
     * 获取用户身上的标签列表
     */
    protected function getUserTags($openId){
        $api = "https://api.weixin.qq.com/cgi-bin/tags/getidlist?".$this->access_token;
        $info = [
            "openid" => $openId,
        ];
        return curl("POST", $api, $info, true);
    }

    /**
     * 设置用户备注名
     */
    protected function setMark($openId, $remark){
        $api = "https://api.weixin.qq.com/cgi-bin/user/info/updateremark?".$this->access_token;
        $info = [
            "openid" => $openId,
            "remark" => $remark
        ];
        return curl("POST", $api, $info, true);
    }

    #   获取用户基本信息
    /**
     * 获取用户基本信息
     */
    protected function getInfo($openId, $lang = "zh_CN"){
        $api = "https://api.weixin.qq.com/cgi-bin/user/info?{$this->access_token}&openid={$openId}&lang={$lang}";
        return curl("GET", $api);
    }

    /**
     * 批量获取用户基本信息
     */
    protected function getInfos($userList){
        $api = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?".$this->access_token;
        $info = [
            "user_list" => $userList
        ];
        return curl("POST", $api, $info, true);
    }

    #   获取用户列表

    /**
     * 获取用户列表
     */
    protected function get($openId = null){
        $api = "https://api.weixin.qq.com/cgi-bin/user/get?{$this->access_token}".isset($openId) ? "&next_openid".$openId : "";
        return curl("GET", $api, null, true);
    }

    #   获取用户地理位置（每次进入公众号则push一个Event、Location）

    #   黑名单管理
    /**
     * 获取黑名单列表
     */
    protected function blackList($openId){
        $api = "https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?".$this->access_token;
        $info = [
            "begin_openid" => $openId
        ];
        return curl("POST", $api, $info, true);
    }

    /**
     * 拉黑
     */
    protected function setBlack($openId){
        $api = "https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?".$this->access_token;
        $info = [
            "openid_list" => $openId
        ];
        return curl("POST", $api, $info, true);
    }

    /**
     * 取消拉黑
     */
    protected function unsetBlack($openId){
        $api = "https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?".$this->access_token;
        $info = [
            "openid_list" => $openId
        ];
        return curl("POST", $api, $info, true);
    }
}