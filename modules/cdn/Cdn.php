<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/12
 * Time: 下午5:10
 */

namespace modules\cdn;

require_once __DIR__ . '/autoload.php';

/**
 * Class Upload。
 * 文件上传处理中间件.
 * @package modules\cdn
 */
class Cdn
{
    /**
     * CDN加速配置项.
     */
    const CONFIG = array(
        'protocol' => 'http://',
        'domain' => 'static.yijian.tv',
        'bucket' => 'static',
        'prefix' => 'cdn_acc_files/',
        'ACCESS_KEY' => 'u1U6re5aLphVQtWgkCsxsxgHaCml4RwC5fUX68ZN',
        'SECRET_KEY' => 'UEbtfZ-b_0BoItxlwpPIIU5FeFO23-npB04qyKcr',
    );

    /**
     * 文件加速.
     * (采用七牛云加速)
     * $files数据结构
     * array(
     *      array('name'=>'a.txt','path'=>'/User/linyang/yijian-php2/Cube/upload/a.txt'),
     *      array('name'=>'a.php','path'=>'/User/linyang/yijian-php2/Cube/upload/a.php'),
     * )
     * 返回值数据结构
     * array('http://xxx.com/prefix/a.txt','http://xxx.com/prefix/a.php');
     *
     * @param $files 文件名称队列
     * @return null|string
     * @throws \Exception
     */
    public static function upload($files)
    {
        if (empty($files) || !is_array($files) || count($files) == 0) {
            return null;
        }

        //初始化BucketManager.
        $auth = new \Qiniu\Auth(self::CONFIG['ACCESS_KEY'], self::CONFIG['SECRET_KEY']);
        $bucketMgr = new \Qiniu\Storage\BucketManager($auth);
        // 生成上传Token
        $token = $auth->uploadToken(self::CONFIG['bucket']);
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new \Qiniu\Storage\UploadManager();

        $stack = array();
        foreach ($files as $file) {
            if (empty($file['path'])) {
                continue;
            }
            //cdn文件名称.
            $upload_key = self::CONFIG['prefix'] . $file['name'];
            //删除远端文件
            $bucketMgr->delete(self::CONFIG['bucket'], $upload_key);
            //上传文件.
            list($ret, $err_upload) = $uploadMgr->putFile($token, $upload_key, $file['path']);
            if ($err_upload !== null) {
                array_push($stack, '');
            } else {
                array_push($stack, self::CONFIG['protocol'] . self::CONFIG['domain'] . '/' . $upload_key);
            }
        }
        return $stack;
    }
}