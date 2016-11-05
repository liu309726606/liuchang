<?php

namespace com\cube\view;

use com\cube\view\view;

/**
 * Class ViewEngine.
 * 模板引擎
 */
class EchoEngine extends ViewEngine
{
    /**
     * 渲染html.
     * @param $name
     * @param array $data
     */
    public function render($name, $data = null)
    {
        echo parent::render($name, $data); // TODO: Change the autogenerated stub
    }
}