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
 * Class JsonpRouter.
 * 返回jsonp(示范性demo)
 * @package router
 */
class JsonpRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/jsonp';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $res->jsonp(array('value' => 'HelloWorld'));
    }
}

//exec class instance.
new JsonpRouter();