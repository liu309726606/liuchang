<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/8/26
 * Time: 上午9:59
 */

namespace com\cube\middleware;


/**
 * Class Connect.
 * 中间件控制类
 * @package com\cube\middleware
 */
final class Connect
{
    /**
     * 请求封装实例.
     * @var
     */
    private $request;
    /**
     * 返回封装实例.
     * @var
     */
    private $response;
    /**
     * 程序入口实例.
     * @var
     */
    private $app;
    /**
     * 中间件队列.
     */
    private $middleWares;
    /**
     * 路由中间件队列.
     * @var
     */
    private $routerMiddleWares;


    private static $instance;

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Connect();
        }
        return self::$instance;
    }

    /**
     * Connect constructor.
     * @param $res
     * @param $req
     * @param $app 入口类实例
     */
    public function init($res, $req, $app)
    {
        $this->middleWares = array();
        $this->routerMiddleWares = array();

        $this->request = $res;
        $this->response = $req;
        $this->app = $app;

        return $this;
    }

    /**
     * run init middleware
     * @param $middleware
     */
    public function link($middleware)
    {
        if (!empty($middleware)) {
            if (!is_array($middleware)) {
                $middleware = array($middleware);
            }
            foreach ($middleware as $m) {
                array_push($this->middleWares, $m);
                $m->run(
                    $this->request,
                    $this->response
                );
            }
        }
    }

    /**
     * add router middleware className String.
     * @param $filter
     * @param $object router ClassName or Instance.
     */
    public function on($filter, $object)
    {
//        echo 'Connect.on ' . $filter . ' ' . (is_string($object) ? $object : get_class($object)) . '<br><br>';
        if (empty($filter) || empty($object)) {
            return;
        }
        if (is_string($object)) {
            //router className push.
            array_push($this->routerMiddleWares, array(
                $filter => $object
            ));
        } else {
            //router instance set.
            foreach ($this->routerMiddleWares as $key => $middleware) {
                if (!empty($middleware[$filter])) {
                    $this->routerMiddleWares[$key][$filter] = $object;
//                    echo 'run ' . get_class($object) . '<br><br>';
                    $object->run($this->request, $this->response, $this);
                    return;
                }
            }
        }
    }

    /**
     * 重置队列.
     */
    public function restart()
    {
        reset($this->routerMiddleWares);
        $this->next();
    }

    /**
     * 开始执行.
     */
    public function next()
    {
        $middleWare = current($this->routerMiddleWares);

        //end check or 404.
        if (empty($middleWare)) {
//            echo 'Connect.next end<br>';
            $this->app->onCatch404();
            return;
        }

        next($this->routerMiddleWares);

        //router middleware.
        foreach ($middleWare as $filter => $object) {
            if ($this->routerMatch($filter)) {
                if (is_string($object)) {
//                    echo 'filter: ' . $filter . ' load ' . $object . '<br><br>';
                    $this->app->load($object);
                } else {
//                    echo 'run ' . get_class($object) . '<br><br>';
                    $object->run($this->request, $this->response, $this);
                }
            } else {
                $this->next();
            }
        }
    }

    /**
     * 垃圾回收所有MiddleWare & RouterMiddleWare.
     */
    public function gc()
    {
        foreach ($this->middleWares as $key1 => $middleWare) {
            $middleWare->end();
            unset($this->middleWares[$key1]);
        }
        foreach ($this->routerMiddleWares as $key2 => $routerMiddleWare) {
            foreach ($routerMiddleWare as $instance) if (!is_string($instance)) $instance->end();
            unset($this->routerMiddleWares[$key2]);
        }
    }

    /**
     * 匹配filter router string 和 router-path.
     */
    private function routerMatch($filter)
    {
        $path = $this->request->path;
        $path = substr($path, 0, 1) == '/' ? $path : '/' . $path;
        return strstr($path, $filter);
    }
}