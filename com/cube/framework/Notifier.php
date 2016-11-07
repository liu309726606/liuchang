<?php

namespace com\cube\framework;

use com\cube\core\Application;

/**
 * Created by PhpStorm.
 * Observer .
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
     * proxys array.
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
     * initialize model array.
     *
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
     * register the proxy instance.
     *
     * @param $name the name of the proxy
     * @param $proxy proxy instance
     */
    public function registerModel($name, Proxy $proxy)
    {
        self::$model[$name] = $proxy;
    }

    /**
     * execute the model
     *
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
     * send the notification in the framework.
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
     * remove all models.
     */
    public function gc()
    {
        foreach (self::$model as $key => $value) {
            self::$model[$key]->onRemove();
            unset(self::$model[$key]);
        }
    }
}