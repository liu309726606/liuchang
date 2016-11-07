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
     * @var string user ip
     */
    public $ip = '';
    /**
     * @var string request protocol
     */
    public $protocol = 'http';
    /**
     * @var string request host
     */
    public $hostname = '';
    /**
     * @var string http refer
     */
    public $refer = '';
    /**
     * @var string router string
     */
    public $path = '';
    /**
     * @var string original http/https url
     */
    public $baseUrl = '';
    /**
     * @var array all request headers(only read)
     */
    public $headers;
    /**
     * @var array cookie instance
     */
    public $cookie;
    /**
     * @var array session instance
     */
    public $session;
    /**
     * @var array body instance
     */
    public $body;
    /**
     * @var array query instance
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
     * redirect router.
     * @param string $value
     */
    public function redirect($value = '')
    {
        $this->path = $value;
    }

    /**
     * post check.
     * @return mixed
     */
    public function isPost()
    {
        return $this->body()->isPost;
    }

    /**
     * get request headers
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
     * set body instance.
     * @param BaseDynamic $cookie
     * @return array
     */
    public function body(BaseDynamic $body)
    {
        $this->body = $body;
    }

    /**
     * set cookie instance.
     * @param ICookie $cookie
     * @return array
     */
    public function cookie(BaseDynamic $cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * set session instance.
     * @return array
     */
    public function session(BaseDynamic $session)
    {
        $this->session = $session;
    }
}