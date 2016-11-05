<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/19
 * Time: 下午6:17
 */

namespace modules\body;

use com\cube\core\Application;
use com\cube\core\BaseDynamic;

/**
 * Class BodyInstance.
 * POST DATA 处理.
 * @package modules\body
 */
class BodyInstance extends BaseDynamic
{
    public function __construct()
    {
        //$_POST数据遍历.
        $this->body = $_POST;

        if (count($this->body) > 0) {
            $this->isPost = true;
        } else {
            $this->isPost = false;
        }
    }

    /**
     * 获取content.
     * (enctype="multipart/form-data"之外的数据源).
     * @return string
     */
    public function content()
    {
        return file_get_contents("php://input");
    }

    /**
     * 返回通过Http上传的文件个数.
     * @return int
     */
    public function files_num()
    {
        return count($_FILES);
    }
}