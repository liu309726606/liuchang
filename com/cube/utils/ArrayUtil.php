<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/12
 * Time: 下午1:53
 */

namespace com\cube\utils;

/**
 * Class ArrayUtil.
 * 数组工具类.
 * @package com\cube\utils
 */
final class ArrayUtil
{
    /**
     * 按照key从数组中删除元素.
     * @param $data
     * @param $key
     * @return mixed
     */
    public static function removeByKey($data, $key)
    {
        if (!array_key_exists($key, $data)) {
            return $data;
        }
        $keys = array_keys($data);
        $index = array_search($key, $keys);
        if ($index !== false) {
            array_splice($data, $index, 1);
        }
        return $data;
    }

    /**
     * 按照value从数组中删除元素.
     * @param $data
     * @param $value
     */
    public static function removeByValue($data, $value)
    {
        if (array_search($value) == false) {
            return $data;
        }
        foreach ($data as $key => $item) {
            if ($item == $value) {
                unset($data[$key]);
            }
        }
        return $data;
    }
}

/**
 * Class ArrayFunction.
 * 数组暂存回调函数类.
 * @package com\cube\utils
 */
class ArrayFunction
{
    private $array;

    public function __construct($func)
    {
        $this->array = array($func);
    }

    public function func()
    {
        return $this->array[0];
    }
}