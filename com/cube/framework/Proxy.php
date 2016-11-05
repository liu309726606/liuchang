<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/10/2
 * Time: 下午4:55
 */

namespace com\cube\framework;

use com\cube\core\Application;

/**
 * Class Proxy.
 * 框架数据代理层.
 * @package com\cube\framework
 */
abstract class Proxy
{
    /**
     * 核心框架的引用.
     * @var Application
     */
    protected $app;

    /**
     * Proxy constructor.
     */
    public function __construct()
    {
        $this->app = Application::getInstance();

        $this->app->notifier->registerModel($this->getName(), $this);
    }

    /**
     * 获取该Proxy的唯一标识.
     * @return string
     */
    public function getName()
    {
        return '';//need override
    }

    /**
     * 该数据模型代理被执行.
     * @param $value 携带数据
     */
    public function execute($value)
    {
        //need override.
        return null;
    }

    /**
     * 数据模型代理销毁.
     */
    public function onRemove()
    {
        //need override.
    }

    /**
     * 发送消息.
     * @param $name 消息名称
     * @param $value 消息body
     */
    protected function sendNotification($name, $value)
    {
        $this->app->notifier->sendNotification($name, $value);
    }
}