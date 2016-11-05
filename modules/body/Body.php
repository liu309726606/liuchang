<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/12
 * Time: 下午5:09
 */

namespace modules\body;

use com\cube\core\Response;
use com\cube\core\Request;
use com\cube\middleware\MiddleWare;

/**
 * Class Body.
 * HTTP POST BODY的升级处理.
 * mimeType: text/html、text/xml、application/octet-stream等
 * @package modules\body
 */
class Body extends MiddleWare
{
    public function run(Request $req, Response $res)
    {
        $this->app->load('modules/body/BodyInstance.php');

        $req->body(new BodyInstance());
    }
}