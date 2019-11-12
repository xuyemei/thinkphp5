<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/7 0007
 * Time: 上午 10:09
 */
namespace  app\common\lib;

use app\common\lib\Aes;
use think\Cache;

class IAuth{

    /*
     * 设置密码加密处理
     */
    public static function setPassword($data){

        return md5($data.config('app.password_pre_halt'));

    }


    public static function setSign($data=[]){
        //1按字典排序
        ksort($data);
        //2把参数进行url拼接
        $string = http_build_query($data);
        //3 进行aes加密
        $string = (new Aes())->encrypt($string);

        return $string;
    }

    public static function checkSign($data){

        //设置每个sign只能使用一次，缓存中存在，说明已经使用过，请求不通过
        if(Cache::get($data['sign'])){
            return false;
        };

        if(empty($data['sign'])
            || empty($data['did']
            || empty($data['app-type'])
            )
        ){
            return false;
        }

        //设置一次请求的有效时间为10分钟
        if(time()-intval($data['time']) > config('app.app_sign_expire_time')){
            return false;
        }

        //对sign解密
        $str = (new Aes())->decrypt($data['sign']);
        parse_str($str,$arr);
        if(!is_array($arr)
            || empty($arr)
            || $arr['did'] != $data['did']
            || $arr['app-type'] != $data['app-type']){
            return false;
        }
        return true;
    }

}