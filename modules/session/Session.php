<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/12
 * Time: 下午1:47
 */

namespace modules\session;

use com\cube\config\Config;
use com\cube\core\Response;
use com\cube\core\Request;
use com\cube\middleware\MiddleWare;

/**
 * Class Session.
 * Session中间件,也实现了ISession接口。
 * @package modules\session
 */
class Session extends MiddleWare
{
    public function run(Request $req, Response $res)
    {
        $this->app->load("./modules/session/LocalSession.php");

        //default action.
        session_set_cookie_params(Config::get('core', 'session_timeout'));
        session_name(Config::get('core', 'session_name'));
        session_start();

        session_regenerate_id(true);

        $req->session(new LocalSession());
    }
}