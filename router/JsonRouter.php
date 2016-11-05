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
 * Class JsonRouter.
 * 返回json(示范性demo)
 * @package router
 */
class JsonRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/json';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $res->json(array('value' => 'HelloWorld'));
    }
}

//exec class instance.
new JsonRouter();