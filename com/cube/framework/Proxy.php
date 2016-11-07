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
 * Model Layer of the MVC.
 * @package com\cube\framework
 */
abstract class Proxy
{
    /**
     * Application Instance.
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
     * Model unique string name.
     * @return string
     */
    public function getName()
    {
        return '';//need override
    }

    /**
     * execute the model.
     * @param $value 携带数据
     */
    public function execute($value)
    {
        //need override.
        return null;
    }

    /**
     * model remove
     */
    public function onRemove()
    {
        //need override.
    }

    /**
     * send the notification in the framework.
     * @param $name 消息名称
     * @param $value 消息body
     */
    protected function sendNotification($name, $value)
    {
        $this->app->notifier->sendNotification($name, $value);
    }
}