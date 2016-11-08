<?php

/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/11/8
 * Time: 4:55 pm
 */
namespace com\cube\config;

/**
 * Class Config.
 * save the Application package.json object.
 * save the global values.
 */
final class Config
{
    private static $config = null;

    private static $time = 0;

    private function __construct()
    {
    }

    /**
     * append the package.json object info.
     *
     * @param $json
     * @throws \Exception
     */
    public static function init($json)
    {
        if (!empty($json)) {
            self::$config = $json;
        } else {
            throw new \Exception('config is error or null!');
        }
    }

    /**
     * Get the package.json object children value.
     * 
     * @param $key
     */
    public static function get(...$keys)
    {
        if (!empty(self::$config)) {
            switch (count($keys)) {
                case 0:
                    return null;
                    break;
                case 1:
                    return self::$config[$keys[0]];
                    break;
                case 2:
                    return self::$config[$keys[0]][$keys[1]];
                    break;
            }
        }
        return null;
    }

    /**
     * Set the global value.
     *
     * ['START'=>bool,'TIME'=>microtime(true),'TIME_ZONE'=>'']
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        if (!empty($key)) {
            switch ($key) {
                case 'TIME_ZONE':
                    self::$time = microtime(true);
                    date_default_timezone_set($value);
                    break;
            }
        }
    }

    /**
     * Get the application initial microtime.
     *
     * @return int
     */
    public static function startTime()
    {
        return self::$time;
    }
}