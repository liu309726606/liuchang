<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/8/26
 * Time: 上午10:23
 */

namespace com\cube\core;

use com\cube\log\Log;
use com\cube\utils\ArrayUtil;

/**
 * Class Request.
 * @package com\cube\core
 */
final class Request
{
    /**
     * @var 用户ip
     */
    public $ip = '';
    /**
     * @var string 当前网络请求协议
     */
    public $protocol = 'http';
    /**
     * @var string 当前请求的域名
     */
    public $hostname = '';
    /**
     * @var string 当前请求referer
     */
    public $referer = '';
    /**
     * @var string 请求路径(经过处理)
     */
    public $path = '';
    /**
     * @var string 原始http/https url
     */
    public $baseUrl = '';
    /**
     * @var array 所有headers(可读可写)
     */
    public $headers;
    /**
     * @var array cookie(可读可写)
     */
    public $cookie;
    /**
     * @var array session(可读可写)
     */
    public $session;
    /**
     * @var array 可读可写
     */
    public $body;
    /**
     * @var array 可读可写
     */
    public $query;

    /**
     * Request constructor.
     * @param $conf config json framework
     */
    public function __construct($conf)
    {
        //common.
        $this->baseUrl = $this->protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $this->path = $_SERVER['PHP_SELF'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->headers = $this->headers();
        if (isset($_SERVER["HTTP_REFERER"])) {
            $this->referer = $_SERVER['HTTP_REFERER'];
        }

        //queryString.
        $this->query = $_GET;

        //router.
        $router = $conf["router"];
        if (isset($this->query[$router]) && !empty($this->query[$router])) {
            $this->path = $this->query[$router];
        } else {
            $this->path = '/';
        }

        //remove parameter router from query.
        unset($this->query[$router]);

        //request log.
        Log::log($this->baseUrl);
    }

    /**
     * 框架內部重定向.
     * @param string $value
     */
    public function redirect($value = '')
    {
        $this->path = $value;
    }

    /**
     * 本次访问是否为POST.
     * @return mixed
     */
    public function isPost()
    {
        return $this->body()->isPost;
    }

    /**
     * 获取此次请求的http headers相关信息
     * @return array
     */
    public function headers()
    {
        return array(
            "HTTP_CONTENT_LENGTH" => @$_SERVER["HTTP_CONTENT_LENGTH"],
            "HTTP_COOKIE" => @$_SERVER["HTTP_COOKIE"],
            "HTTP_ACCEPT_LANGUAGE" => @$_SERVER["HTTP_ACCEPT_LANGUAGE"],
            "HTTP_ACCEPT_ENCODING" => @$_SERVER["HTTP_ACCEPT_ENCODING"],
            "HTTP_USER_AGENT" => @$_SERVER["HTTP_USER_AGENT"],
            "HTTP_ACCEPT" => @$_SERVER["HTTP_ACCEPT"],
            "HTTP_CACHE_CONTROL" => @$_SERVER["HTTP_CACHE_CONTROL"],
            "HTTP_CONNECTION" => @$_SERVER["HTTP_CONNECTION"],
            "HTTP_HOST" => @$_SERVER["HTTP_HOST"],
        );
    }

    /**
     * body的赋值和获取.
     * @param ICookie $cookie
     * @return array
     */
    public function body(BaseDynamic $body)
    {
        $this->body = $body;
    }

    /**
     * cookie的赋值和获取.
     * @param ICookie $cookie
     * @return array
     */
    public function cookie(BaseDynamic $cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * session的赋值和获取.
     * @return array
     */
    public function session(BaseDynamic $session)
    {
        $this->session = $session;
    }
}