<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/12
 * Time: 下午1:47
 */

namespace modules\session_redis;

use com\cube\core\Response;
use com\cube\core\Request;
use com\cube\middleware\MiddleWare;

/**
 * Class RedisSession.
 * Session中间件,也实现了ISession接口。
 * @package modules\session
 */
class RedisSession extends MiddleWare
{
    private $instance;
    private $options;

    /**
     * Session constructor.
     * @param $options 数据库
     */
    public function __construct($options)
    {
        parent::__construct();

        $this->options = $options;
        $this->app->load("./modules/session_redis/RedisSessionInstance.php");
    }

    public function run(Request $req, Response $res)
    {
        $session_name = $this->app->conf()["session_name"];
        $session_timeout = $this->app->conf()["session_timeout"];
        $session_id = $req->cookie->$session_name;

        if (empty($session_id)) {
            $session_id = uniqid('cube_');
            $req->cookie->set($session_name, $session_id, time() + $session_timeout);
        }

        $this->options['session_id'] = $session_id;
        $this->options['session_name'] = $session_name;

        $this->instance = new RedisSessionInstance($this->options);
        $req->session($this->instance);
    }

    public function end()
    {
        parent::end(); // TODO: Change the autogenerated stub

        $this->instance->close();
    }
}