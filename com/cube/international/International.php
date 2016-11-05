<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/8/26
 * Time: 下午10:53
 */

namespace com\cube\international;

use com\cube\core\Application;
use com\cube\fs\FS;

/**
 * Class Internation.
 * 全局国际化字段.
 * @package com\cube\international
 */
class International
{
    /**
     * 语言包存储器.
     */
    private static $languages = null;

    /**
     *
     * @param $name
     * @param $key
     * @return mixed
     */
    public static function get($lan, $key)
    {
        if (empty($languages)) {
            $languages = array();
        }

        if (empty($languages[$lan])) {
            $content = FS::read(Application::$www_dir . Application::$CONFIG['international'][$lan]);
            $list = array();
            $stack = explode('\t\n', $content);
            foreach ($stack as $value) {
                $item = explode('=', $value);
                $list[$item[0]] = $item[1];
            }
            self::$languages[$lan] = $list;
        }
        
        return self::$languages[$lan][$key];
    }
}