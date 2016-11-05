<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/12
 * Time: 上午11:48
 */

namespace modules\cookie;

use com\cube\core\CookieInstance;
use com\cube\core\Response;
use com\cube\core\Request;
use com\cube\middleware\MiddleWare;

/**
 * class Cookie.
 * @package com\cube\core
 */
class Cookie extends MiddleWare
{
    public function run(Request $req, Response $res)
    {
        $this->app->load("modules/cookie/CookieInstance.php");

        $req->cookie(new CookieInstance());
    }
}