<?php
namespace Uphp\Driver\Cache;
/**
 * 缓存接口类
 * Interface Cache
 * @package Uphp\Driver\Cache
 */
interface Cache
{
    /**
     * 根据键获取值
     * 不存在或过期返回NULL
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * 设置键值
     * @param $key
     * @param $value
     * @param $timeout 有效时间，默认无限时
     */
    public function set($key, $value, $timeout);

    /**
     * 删除键
     * @param $key
     */
    public function delete($key);

    /**
     * 清除所有缓存
     */
    public function clear();
}