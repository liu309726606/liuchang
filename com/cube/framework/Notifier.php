<?php

namespace com\cube\framework;

use com\cube\core\Application;

/**
 * Created by PhpStorm.
 * 观察者核心类.
 * User: linyang
 * Date: 16/10/2
 * Time: 下午2:28
 */
class Notifier
{
    /**
     * routers array.
     */
    public static $models_array;
    /**
     * 数据代理列表.
     */
    private static $model;

    private static $instance;

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Notifier();
        }
        return self::$instance;
    }

    /**
     * 初始化model array.
     * 记录所有routers
     * @param $value
     * @return $this
     */
    public function init($value)
    {
        self::$model = array();
        self::$models_array = $value;

        return $this;
    }

    /**
     * 注册Model层代理实例.
     * @param $name 代理实例标识(必须唯一)
     * @param $proxy 代理实例
     */
    public function registerModel($name, Proxy $proxy)
    {
        self::$model[$name] = $proxy;
    }

    /**
     * 执行数据模型代理.
     * @param $name
     * @param null $value
     * @return mixed
     */
    public function model($name, $value = null)
    {
        //优化检测,Proxy实现了即用即创建
        if (!empty(self::$model[$name])) {
            return self::$model[$name]->execute($value);
        }

        if (!empty(self::$models_array)) {
            if (!empty(self::$models_array[$name])) {
                Application::getInstance()->load(self::$models_array[$name]);
                return self::$model[$name]->execute($value);
            }
        }

        return null;
    }

    /**
     * 发送消息.
     * @param $name 消息名称
     * @param $value 消息body
     */
    public function sendNotification($name, $value)
    {
        if (!empty(self::$view[$name])) {
            $send_list = self::$view[$name];
            foreach ($send_list as $mediator) {
                $mediator->handleNotification($name, $value);
            }
        }
    }

    /**
     * 移除所有Model层代理实例.
     */
    public function gc()
    {
        foreach (self::$model as $key => $value) {
            self::$model[$key]->onRemove();
            unset(self::$model[$key]);
        }
    }
}