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
 * Class ParamsRouter(Demo)
 * @package router
 */
class ParamsRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/params/:id';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $res->send('params.id: ' . $req->params->id);
    }
}

//exec class instance.
new ParamsRouter();