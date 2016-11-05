<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/27
 * Time: 下午9:19
 */

namespace com\cube\utils;

/**
 * Class SystemUtil.
 * 系统工具.
 * @package com\cube\utils
 */
final class SystemUtil
{
    /**
     * 框架所需PHP最低版本号.
     * @return string
     */
    public static function kernel()
    {
        return '5.6.0';
    }

    /**
     * 检测PHP版本是否足够.
     * @return bool
     */
    public static function check_version()
    {
        $kernel = explode('.', self::kernel());
        $env = explode('.', explode('-', PHP_VERSION)[0]);

        if (intval($env[0]) < intval($kernel[0])) {
            return false;
        } elseif (intval($env[0]) > intval($kernel[0])) {
            return true;
        }
        if (intval($env[1]) < intval($kernel[1])) {
            return false;
        } elseif (intval($env[1]) > intval($kernel[1])) {
            return true;
        }
        if (intval($env[2]) < intval($kernel[2])) {
            return false;
        }
        return true;
    }

    /**
     * 框架所需扩展类库.
     * @return array
     */
    private static function extensions()
    {
        return array(
            'pdo',
            'pdo_mysql',
            'curl'
        );
    }

    /**
     * 检测框架所需扩展是否齐全.
     * @param $plugins
     * @return bool
     */
    public static function check_unknown_extension($extension = null)
    {
        if (empty($extension)) {
            $extension = self::extensions();
        } elseif (!is_array($extension)) {
            $extension = array($extension);
        }
        $env_extensions = get_loaded_extensions();
        foreach ($env_extensions as $key => $ext) {
            $env_extensions[$key] = strtolower($ext);
        }
        foreach ($extension as $ext) {
            if (!in_array($ext, $env_extensions)) {
                return $ext;
            }
        }
        return null;
    }
}