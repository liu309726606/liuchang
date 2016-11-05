<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/19
 * Time: 下午6:52
 */

namespace modules\session;

use com\cube\core\BaseDynamic;
use com\cube\core\ISession;

/**
 * Class LocalSession.
 * 本地Session封装类(使用PHP原生SESSION存取方式).
 * @package modules\session
 */
class LocalSession extends BaseDynamic implements ISession
{
    public function __construct()
    {
        foreach ($_SESSION as $key => $value) {
            $this->$key = $value;
        }
    }

    public function __set($name,$value)
    {
        $this->$name = $value;
        $_SESSION[$name] = $value;
    }

    public function getName()
    {
        // TODO: Implement setID() method.
        return session_name();
    }

    public function getID()
    {
        // TODO: Implement getID() method.
        return session_id();
    }

    public function delete($options)
    {
        // TODO: Implement delete() method.
        parent::delete($options);
        unset($_SESSION[$options]);
    }

    public function clear()
    {
        // TODO: Implement clear() method.
        parent::clear();
        session_destroy();
    }
}