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
use OTPHP\TOTP;

/**
 * Class OtpRouter.
 * 获取当前的TOTP数字(示范性demo)
 * @package router
 */
class OtpRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();

        $this->app->load('modules/otp/otphp.php');
    }

    public function getName()
    {
        return '/otp';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        ////otpauth://totp/server_yijian_com_auth?secret=IR3ECMTPFY3SKOCQMIZEYY2SNQUT6MSDHJRGI2KGJYQS4RKTOZGA
        $otp = new TOTP('IR3ECMTPFY3SKOCQMIZEYY2SNQUT6MSDHJRGI2KGJYQS4RKTOZGA');
        $res->send($otp->now());
    }

    public function end()
    {
        parent::end(); // TODO: Change the autogenerated stub
    }
}

//exec class instance.
new OtpRouter();