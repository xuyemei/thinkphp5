<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/7 0007
 * Time: 上午 10:09
 */
namespace  app\common\lib;

class IAuth{

    /*
     * 设置密码加密处理
     */
    public static function setPassword($data){

        return md5($data.config('app.password_pre_halt'));

    }
}