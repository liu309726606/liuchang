<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/10/2
 * Time: 下午4:55
 */

namespace com\cube\framework;

use com\cube\middleware\RouterMiddleWare;

/**
 * Class Mediator.
 * mvc观察者模式框架View层.
 * @package com\cube\framework
 */
abstract class Mediator extends RouterMiddleWare
{
    /**
     * Mediator constructor.
     * 提前注册当前Mediator所有感兴趣的消息类型.
     */
    public function __construct()
    {
        parent::__construct($this->getName());
    }

    /**
     * router filter string.
     * such as /user or /upload
     * @return string
     */
    public function getName()
    {
        return '/cube';
    }

    /**
     * 观察者管理器将启动相应的数据代理.
     * @param $name
     * @param null $value
     */
    public function model($name, $value = null)
    {
        return $this->app->notifier->model($name, $value);
    }
}