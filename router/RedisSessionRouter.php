<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/10/10
 * Time: 下午3:57
 */

namespace router;

use com\cube\framework\Mediator;
use com\cube\core\Response;
use com\cube\core\Request;
use com\cube\middleware\Connect;

/**
 * Class RemoteSessionRouter.
 * RedisSession操作(示范性demo)
 * @package router
 */
class RemoteSessionRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/redis_session';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        /**
         * 注意!记住使用RedisSession 替换 Session中间件.
         */

        $res->send($req->session->username);

        $req->session->username = time();
    }
}

//exec class instance.
new RemoteSessionRouter();