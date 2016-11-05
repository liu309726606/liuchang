<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/8/26
 * Time: 上午10:23
 */

namespace com\cube\core;

use com\cube\log\Log;
use com\cube\view\ViewEngine;


/**
 * Class Response
 * @package com\cube\core
 */
final class Response
{
    public function __construct()
    {
        header('ServiceX:' . Application::$CONFIG['name'] . ' version:' . Application::$CONFIG['version']);

    }

    /**
     * url 重定向
     * @param $path
     */
    public function location($path)
    {
        try {
            header('Location:' . $path);
        } catch (\Exception $e) {
        }
        return $this;
    }

    /**
     * 向客户端发送字符串.
     * @param $value
     */
    public function send($value)
    {
        echo $value;

        Log::log('Response send', true);
    }

    /**
     * 将数据以json形式返回.
     * @param $value
     */
    public function json($value)
    {
        echo json_encode($value);

        Log::log('Response json', true);
    }

    /**
     * 将数据以jsonp形式返回.
     * @param $value
     */
    public function jsonp($value)
    {
        $callback_str = Application::$FRAMEWORK['jsonp'];
        if (empty($callback_str)) {
            return $this;
        }
        $callback_func = Application::getInstance()->request->query[$callback_str];
        if (empty($callback_func)) {
            return $this;
        }
        echo $callback_func . '(' . json_encode($value) . ')';

        Log::log('Response jsonp', true);
    }

    /**
     * 渲染模板.
     * @param $viewEngineClass 渲染模板的ViewEngine子类
     * @param viewName 模板名称
     * @param $value 传递数据
     */
    public function render(ViewEngine $viewEngine, $viewName, $value = null)
    {
        $viewEngine->render($viewName, $value);

        Log::log('Response render ' . $viewName, true);
    }

    /**
     * 重定向router.
     * @param $value
     */
    public function redirect($value)
    {
        Application::getInstance()->redirect($value);
    }

    /**
     * 指定返回的http header statuCode.
     * @param $code
     */
    public function statusCode($code)
    {
        $_status = array(
            // Informational 1xx
            100 => 'Continue',
            101 => 'Switching Protocols',
            // Success 2xx
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            // Redirection 3xx
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Moved Temporarily ',  // 1.1
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            // 306 is deprecated but reserved
            307 => 'Temporary Redirect',
            // Client Error 4xx
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            // Server Error 5xx
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            509 => 'Bandwidth Limit Exceeded'
        );
        if (array_key_exists($code, $_status)) {
            header('HTTP/1.1 ' . $code . ' ' . $_status[$code]);
        }

        return $this;
    }
}