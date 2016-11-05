<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/10/2
 * Time: 下午5:27
 */

namespace model;

use com\cube\db\DB;
use com\cube\framework\Proxy;
use config\Config;

/**
 * Class MysqlProxy.
 * @package model
 */
class MysqlProxy extends Proxy
{
    public function __construct()
    {
        parent::__construct();

        DB::init([
            'host' => 'localhost',
            'port' => 3306,
            'user' => 'root',
            'password' => '',
            'db' => 'system',
            'prefix' => 'cube_'
        ]);
    }

    public function getName()
    {
        return 'mysql';
    }

    public function execute($value)
    {
        //get remote or local data.
//        return DB::model('user')->where('username="linyang"')->delete();
        return DB::model('user')->where('username="lin"')->select();
        //return DB::model('user')->where('username="lin"')->update(array('phone' => 555));
//        return DB::model('user')->insert(array('username' => '"dabao"','phone'=>159));
//        return DB::model('user')->where('phone=159')->insert(array('username' => '"yangzhuo"'));
    }

    public function onRemove()
    {
        parent::onRemove(); // TODO: Change the autogenerated stub

        DB::close();
    }
}

new MysqlProxy();