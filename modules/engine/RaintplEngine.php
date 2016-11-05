<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/27
 * Time: 下午10:27
 */

namespace modules\engine;

use com\cube\view\ViewEngine;
use modules\engine\raintpl\RainTPL;

/**
 * Class RaintplEngine.
 * 感谢Rain框架中的raintpl模板引擎提供支持.
 * @package modules\engine
 */
class RaintplEngine extends ViewEngine
{
    /**
     * tpl engine core file是否已经被装载.
     * @var bool
     */
    private static $loaded = false;

    /**
     * RaintplEngine constructor.
     */
    public function __construct()
    {
        parent::__construct();

        if (!self::$loaded) {
            self::$loaded = true;

            $this->app->load('./modules/engine/raintpl/rain.tpl.class.php');

            RainTPL::configure('base_url', null);
            RainTPL::configure("root_dir", constant('BASE_DIR'));
            RainTPL::configure("tpl_dir", 'view/');
            RainTPL::configure("cache_dir", "tmp/");
        }
    }

    public function render($name, $data = null)
    {
//        if (!ob_start("ob_gzhandler"))
//            // if the browser don't support gz compression init the regular output buffer
//            ob_start();
        
        $tpl = new RainTPL();

        if (!empty($data) && is_array($data)) {
            foreach ($data as $key => $value) {
                $tpl->assign($key, $value);
            }
        }

        echo $tpl->draw($name, $return_string = true);
    }
}