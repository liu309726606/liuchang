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
 * Class RouterIDRouter.
 * get the parameters from the path info
 * such as /:p1/:p2/:p3(demo)
 * @package router
 */
class RouterIDRouter extends Mediator
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
new RouterIDRouter();