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
use com\cube\international\International;
use com\cube\middleware\Connect;

/**
 * Class InternationalRouter.
 * 国际化语言包(示范性demo)
 * @package router
 */
class InternationalRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/international';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $res->send(International::get('CN', 'name'));
    }
}

//exec class instance.
new InternationalRouter();