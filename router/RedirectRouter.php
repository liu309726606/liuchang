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
 * Class RedirectRouter.
 * router 重定向(示范性demo)
 * @package router
 */
class RedirectRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/redirect';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $res->redirect('/send');
    }
}

//exec class instance.
new RedirectRouter();