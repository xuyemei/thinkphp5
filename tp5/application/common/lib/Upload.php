<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/8 0008
 * Time: 下午 2:49
 */

namespace  app\common\lib;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 * 七牛图片基础类库
 * Class Upload
 * @package app\common\lib
 */
class Upload{

    public static function image(){

        if(empty($_FILES['file']['tmp_name'])){
            exception('图片数据不合法',404);
        }

        //要上传的文件
        $file = $_FILES['file']['tmp_name'];
        $pathinfo = pathinfo($_FILES['file']['name']);
        $ext = $pathinfo['extension'];

        $config = config('qiniu');
//        构建一个鉴权对象
        $auth = new Auth($config['ak'],$config['sk']);
        //生成上传的token
        $token = $auth->uploadToken($config['bucket']);
        //上传到七牛后保存的文件名
        $key = date('Y').'/'.date('M').'/'.substr(md5($file),0,5).date('YmdHis').rand(0,9999).'.'.$ext;

        $uploadMgr = new UploadManager();
        list($ret,$err) = $uploadMgr->putFile($token,$key,$file);
       if($err !== null){
           return null;
       }else{
           return $key;
       }
    }

}