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
 * the view layer of the MVC Framework.
 * @package com\cube\framework
 */
abstract class Mediator extends RouterMiddleWare
{
    /**
     * Mediator constructor.
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
     * get the model layer instance.
     * @param $name
     * @param null $value
     */
    public function model($name, $value = null)
    {
        return $this->app->notifier->model($name, $value);
    }
}