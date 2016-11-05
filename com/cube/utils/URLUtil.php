<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/12
 * Time: 下午5:15
 */

namespace com\cube\utils;

/**
 * Class URLUtil.
 * @package com\cube\utils
 */
final class URLUtil
{
    /**
     * 判断当前URL是否为HTTPS.
     * @param $url
     * @return string
     */
    public static function isHTTPS($url)
    {
        $dirname = pathinfo($url)['dirname'];
        return strstr('https://', $dirname);
    }
}