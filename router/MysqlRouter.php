<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/8/27
 * Time: 下午3:06
 */

namespace router;

use com\cube\core\Response;
use com\cube\core\Request;
use com\cube\middleware\Connect;
use com\cube\framework\Mediator;

/**
 * Class MysqlRouter.
 * Mysql & Proxy(Demo).
 */
class MysqlRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/mysql';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $result = $this->model('mysql', 'parameters');
        $res->json($result);
    }
}

//exec class instance.
new MysqlRouter();