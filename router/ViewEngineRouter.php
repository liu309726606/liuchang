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
use com\cube\view\EchoEngine;
use com\cube\view\AngularEngine;
use modules\engine\RaintplEngine;


/**
 * Class ViewEngineRouter.
 * 模板渲染(示范性demo)
 * @package router
 */
class ViewEngineRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/viewengine';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $res->render(new RaintplEngine(), 'page', array('title' => 'cube'));

//        $res->render(new AngularEngine(), '404', array('a' => 1));

//        $res->render(new EchoEngine(), '404');
    }
}

//exec class instance.
new ViewEngineRouter();