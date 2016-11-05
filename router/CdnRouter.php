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
use com\cube\middleware\Connect;
use modules\cdn\Cdn;

/**
 * Class UploadRouter.
 * 文件上传业务(示范性demo)
 * @package router
 */
class UploadRouter extends Mediator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName()
    {
        return '/cdn';
    }

    public function run(Request $req, Response $res, Connect $connect)
    {
        if ($req->body->files_num() > 0) {
            $res->json(Cdn::upload(FS::saveUploadAsFile()));
        } else {
            $content = $req->body->content();
            if (!empty($content)) {
                $res->json(Cdn::upload(FS::saveInputAsFile($content, $req->query->key)));
            } else {
                $res->send('error');
            }
        }
    }
}

//exec class instance.
new UploadRouter();