<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/19
 * Time: 下午6:54
 */

namespace com\cube\core;


/**
 * Interface ISession.
 * @package com\cube\core
 */
interface ISession
{
    /**
     * 获取session_name.
     * @return mixed
     */
    public function getName();

    /**
     * 获取该访问使用的session_id.
     * @return mixed
     */
    public function getID();

    /**
     * 删除某一个session
     * @param $options
     * @return mixed
     */
    public function delete($options);

    /**
     * 清空session.
     * @return mixed
     */
    public function clear();
}