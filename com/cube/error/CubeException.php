<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/27
 * Time: 下午9:14
 */

namespace com\cube\error;

/**
 * Class CubeError.
 * @package com\cube\error
 */
class CubeException extends \Exception
{
    /**
     * PHP 版本过低.
     * @var int
     */
    public static $VERSION_ERROR = 10000;
    
    /**
     * 缺少扩展.
     * @var int
     */
    public static $EXT_ERROR = 10001;

    /**
     * 国际化错误.
     * @var int
     */
    public static $INTERNATION_ERROR = 10002;

    /**
     * 未知错误
     * @var int
     */
    public static $UNKNOW_ERROR = 10009;
}