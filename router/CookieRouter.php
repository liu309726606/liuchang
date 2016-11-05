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
 * Class CookieRouter.
 * cookie操作(示范性demo)
 * @package router
 */
class CookieRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/cookie';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $res->json($req->cookie->test_key);

        $req->cookie->test_key = time();
    }
}

//exec class instance.
new CookieRouter();