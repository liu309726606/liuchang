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
 * Class SendRouter(Demo)
 * @package router
 */
class SendRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/send';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $res->send('HelloWorld!');
    }
}

//exec class instance.
new SendRouter();