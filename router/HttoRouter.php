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
use com\cube\fs\FS;
use com\cube\http\Http;
use com\cube\middleware\Connect;
use modules\cdn\Cdn;

/**
 * Class HttpRouter.
 * Http请求(示范性demo)
 * @package router
 */
class HttpRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/http';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        $content = Http::get('http://www.yijian.tv');

        $res->send($content);
    }
}

//exec class instance.
new HttpRouter();