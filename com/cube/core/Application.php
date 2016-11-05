<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/8/26
 * Time: 上午10:42
 */

namespace com\cube\core;

use com\cube\error\CubeException;
use com\cube\framework\Notifier;
use com\cube\fs\FS;
use com\cube\log\Log;
use com\cube\utils\SystemUtil;
use com\cube\middleware\Connect;
use com\cube\view\EchoEngine;
use com\cube\view\AngularEngine;

/**
 * Class Application.
 * Cube HTTP Framework Facade Core Class.
 * @package com\cube\core
 */
final class Application
{
    /**
     * Framework init dependency package1.
     */
    const INIT_LIBS = array(
        'com/cube/log/Log.php',
        'com/cube/utils/SystemUtil.php',
        'com/cube/error/CubeException.php',
        'com/cube/fs/FS.php',
        'com/cube/view/ViewEngine.php',
        'com/cube/view/EchoEngine.php',
        'com/cube/view/AngularEngine.php'
    );

    /**
     * Framework init dependency package2.
     */
    const COMMON_LIBS = array(
        'com/cube/international/International.php',
        'com/cube/utils/ArrayUtil.php',
        'com/cube/utils/URLUtil.php',
        'com/cube/db/DB.php',
        'com/cube/http/Http.php',
        'com/cube/middleware/Connect.php',
        'com/cube/middleware/MiddleWare.php',
        'com/cube/middleware/RouterMiddleWare.php',
        'com/cube/core/BaseDynamic.php',
        'com/cube/core/Request.php',
        'com/cube/core/Response.php',
        'com/cube/core/ISession.php',
        'com/cube/framework/Notifier.php',
        'com/cube/framework/Mediator.php',
        'com/cube/framework/Proxy.php',
    );

    /**
     * package.json Config JSON.
     */
    public static $CONFIG = array(
        "log" => array(
            "log" => "log/cube.log",
            "mysql" => "log/cube.mysql"
        ),
        "dir" => array(
            "router" => "router/",
            "view" => "view/",
            "tmp" => "tmp/",
            "upload" => "upload/"
        ),
        "framework" => array(
            "router" => "router",
            "session_name" => "PHPSESSID",
            "session_timeout" => 360000,
            "jsonp" => "callback"
        )
    );

    /**
     * 框架时间戳.
     * @var int
     */
    public static $start_time = 0;
    /**
     * 项目根目录.
     * @var string
     */
    public static $www_dir = '';
    /**
     * 路由目录.
     * @var string
     */
    public static $router_dir = 'router/';
    /**
     * 模板目录.
     * @var string
     */
    public static $view_dir = 'view/';
    /**
     * 上传目录.
     * @var string
     */
    public static $upload_dir = 'upload/';
    /**
     * 缓存目录.
     * @var string
     */
    public static $tmp_dir = 'tmp/';

    /**
     * 框架内部通讯核心.
     * @var
     */
    public $notifier;
    /**
     * Http Input Stream Instance.
     * @var Request
     */
    public $request;
    /**
     * Http Output Stream Instance.
     * @var Response
     */
    public $response;
    /**
     * 中间件管理器.
     * @var Router
     */
    public $connect;
    /**
     * 程序是否已经开启.
     * @var bool
     */
    private $started = false;


    private static $instance;

    /**
     * Simple Single Instance.
     * @return Application
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Application();
        }
        return self::$instance;
    }

    /**
     * Application GarbageCollection.
     */
    public static function gc()
    {
        if (!empty(self::$instance)) {
            if (!empty(self::$instance->notifier)) {
                self::$instance->notifier->gc();
            }
            if (!empty(self::$instance->connect)) {
                self::$instance->connect->gc();
            }
        }

        Log::flush();
    }

    /**
     * Application constructor.
     */
    private function __construct()
    {
        if (!empty(self::$instance)) {
            throw new \Exception('Application Instance Must be unique!');
        }
        self::$instance = $this;

        //init time.
        self::$start_time = microtime(true);
        //timezone.
        date_default_timezone_set('Asia/Shanghai');


        $this->load(self::INIT_LIBS);
        //check php version.
        if (!SystemUtil::check_version()) {
            throw new CubeException('PHP VERSION IS LOW.', CubeException::$VERSION_ERROR);
        }
        //check exts.
        $unknown_ext = SystemUtil::check_unknown_extension();
        if (!empty($unknown_ext)) {
            throw new CubeException('Unknown Ext ' . $unknown_ext, CubeException::$EXT_ERROR);
        }

        //load libs.
        $this->load(self::COMMON_LIBS);
    }

    /**
     * initialize Application Framework.
     * @param $www_dir
     * @param $conf_path
     */
    public function init($www_dir, $conf_path)
    {
        self::$www_dir = $www_dir . '/';
        if (!defined("BASE_DIR")) define("BASE_DIR", self::$www_dir);


        //load conf file.
        self::$CONFIG = json_decode(FS::read(self::$www_dir . $conf_path), true);


        //dir config.
        self::$router_dir = self::$www_dir . self::$CONFIG['dir']['router'];
        self::$view_dir = self::$www_dir . self::$CONFIG['dir']['view'];
        self::$upload_dir = self::$www_dir . self::$CONFIG['dir']['upload'];
        self::$tmp_dir = self::$www_dir . self::$CONFIG['dir']['tmp'];


        //load engine.
        $this->load(self::$CONFIG["engine"]);
        //load modules.
        $this->load(self::$CONFIG["modules"]);
        //init model.
        $this->notifier = Notifier::getInstance()->init(self::$CONFIG['model']);


        //init Request.
        $this->request = new Request($this->conf());
        //init Response.
        $this->response = new Response();

        //init router.
        $this->connect = Connect::getInstance()->init(
            $this->request,
            $this->response,
            $this
        );
    }

    /**
     * Application global load php file.
     * @param $options support path string or paths array
     */
    public function load($options)
    {
        $arr = null;
        if (empty($options)) {
            return;
        } elseif (is_array($options)) {
            $arr = $options;
        } else {
            $arr = array($options);
        }
        foreach ($arr as $key => $path) {
            require_once self::$www_dir . $path;
        }
    }

    /**
     * Start to execute all routerMiddleWares.
     */
    public function startup()
    {
        if ($this->started) {
            throw new CubeException(CubeException::$UNKNOW_ERROR);
        }

        foreach (self::$CONFIG['router'] as $key => $value) {
            $this->on($key, $value);
        }

        $this->started = true;
        $this->connect->restart();

        //garbageCollection.
        self::gc();
    }

    /**
     * Make the router redirect and reset connect guide.
     * @param string $router
     */
    public function redirect($router = '')
    {
        $this->request->redirect($router);
        $this->connect->restart();
    }

    /**
     * Add Common MiddleWare
     * @param $middleware
     */
    public function link($value)
    {
        $this->connect->link($value);
    }

    /**
     * Add RouterMiddleWare.
     * @param $filter
     * @param $className router ClassName or Instance.
     */
    public function on($filter, $object)
    {
        if (!empty($object)) {
            $this->connect->on($filter, $object);
        }
    }

    /**
     * Get the package.json framework object.
     * @return null
     */
    public function conf()
    {
        return self::$CONFIG['framework'];
    }

    /**
     * Connect All RouterMiddleWare Not Catch Filter.
     */
    public function onCatch404()
    {
        $this->response->render(new EchoEngine(), '404');
    }
}

//error_reporting(0);
/**
 * Global Error Handler.
 * @param $error_level
 * @param $error_message
 * @param $error_file
 * @param $error_line
 * @param $error_context
 */
function onErrorHandler($error_level, $error_message, $error_file, $error_line, $error_context)
{
    switch ($error_level) {
        case E_USER_NOTICE://提醒级别
        case E_WARNING: //警告级别
        case E_USER_WARNING: //警告级别
        case E_ERROR://错误级别
        case E_USER_ERROR://错误级别
            break;
        default:
            return;
    }

    Log::log('Error ' . $error_message);

    $errors = array('msg' => $error_message, 'trace' => 'ErrorLevel: ' . $error_level . '<br>ErrorContext: ' . serialize($error_context) . '<br>ErrorLine: ' . $error_line . '<br>ErrorFile: ' . $error_file);
    if (!empty(Application::getInstance()->response)) {
        Application::getInstance()->response->render(new AngularEngine(), '500', $errors);
    } else {
        $viewEngine = new AngularEngine();
        $viewEngine->render('500', $errors);
    }

    Application::gc();
}

/**
 * Global Exception Handler.
 * @param Exception $e
 */
function onExceptionHandler(\Exception $e)
{
    Log::log('Exception ' . $e->getMessage());

    $errors = array('msg' => $e->getMessage(), 'trace' => $e->getTraceAsString());
    if (!empty(Application::getInstance()->response)) {
        Application::getInstance()->response->render(new AngularEngine(), '500', $errors);
    } else {
        $viewEngine = new AngularEngine();
        $viewEngine->render('500', $errors);
    }

    Application::gc();
}

/**
 * Code Execute End Error Check.
 */
function onShutDownHandler()
{
    if (error_get_last()) {
        Log::log('ShutDownError ' . error_get_last());
    }
}

set_error_handler('com\cube\core\onErrorHandler');
set_exception_handler('com\cube\core\onExceptionHandler');
register_shutdown_function('com\cube\core\onShutDownHandler');