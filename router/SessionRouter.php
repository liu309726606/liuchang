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
 * Class SessionRouter.
 * 本地Session操作(示范性demo)
 * @package router
 */
class SessionRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/session';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $res->json($req->session->username);

        $req->session->username = 'test';
    }
}

//exec class instance.
new SessionRouter();