<?php
namespace Uphp\Driver\OpenWeChat;

/**
 * 自定义菜单
 * Class Menu
 * @package Uphp\Driver\OpenWeChat
 */
class Menu extends OpenWeChat
{
    /**
     * 自定义菜单创建接口 POST
     */
    public function create($value){
        $api = $this->config['url']."menu/create?access_token={$this->access_token}";
        $r = curl("POST", $api, $value);
        return json_decode($r, true);
    }

    /**
     * 获取自定义菜单配置接口 GET
     * 本接口将会提供公众号当前使用的自定义菜单的配置，
     * 如果公众号是通过API调用设置的菜单，则返回菜单的开发配置，
     * 而如果公众号是在公众平台官网通过网站功能发布菜单，则本接口返回运营者设置的菜单配置。
     */
    public function get(){
        $api = $this->config['url']."get_current_selfmenu_info?access_token={$this->access_token}";
        $r = curl("GET", $api);
        return json_decode($r, true);
    }
}