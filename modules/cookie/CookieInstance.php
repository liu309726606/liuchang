<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/12
 * Time: 上午11:48
 */

namespace com\cube\core;

use com\cube\core\BaseDynamic;

/**
 * class Cookie.
 * @package com\cube\core
 */
class CookieInstance extends BaseDynamic
{
    public function __construct()
    {
        $this->body = $_COOKIE;
    }

    public function __set($name, $value)
    {
        setcookie($name, $value, null, '/');
    }

    /**
     * 设置cookie.
     * @param $key
     * @param $value
     * @param $time
     * @return mixed
     */
    public function set($key, $value, $time = null)
    {
        setcookie($key, $value, $time, '/');
    }

    /**
     * 删除某一个cookie.
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        setcookie($key, '', time() - 3600, '/');
    }

    /**
     * 清除所有cookie.
     * @return mixed
     */
    public function clear()
    {
        foreach ($this->body as $key => $value) {
            $this->delete($key);
        }
    }
}