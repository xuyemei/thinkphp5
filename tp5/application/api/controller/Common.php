<?php
namespace app\api\controller;

use app\common\lib\Aes;
use think\Cache;
use think\Controller;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;

class Common extends Controller
{

    public $headers = null;
    public function _initialize()
    {
        $this->checkRequestAuth();
//        $this->testAes();

    }

    public function checkRequestAuth(){
        //获取header 头里面的数据
        $headers = request()->header();
        $param = input('param.');

        if(empty($headers['sign'])){
            throw new ApiException('sign不存在',400);
        }

        if(!in_array($headers['app-type'],config('app.appType'))){
            throw new ApiException('app-type不合法',400);
        }
        //aes加解密
        $jiamiHeader = [
            'did'=>$headers['did'],
            'app-type'=>$headers['app-type'],
        ];
        $signData = array_merge($jiamiHeader,$param);
        $signData['sign']=$headers['sign'];
        //sign检验
        if(!IAuth::checkSign($signData)){
            throw new ApiException('sign授权码不正确',401);
        }

        if(config('app_debug') == false){
            //设置每个sign只能使用一次，缓存中存在，说明已经使用过，请求不通过
            if(Cache::get($headers['sign'])){
                return false;
            };
            Cache::set($headers['sign'],1,config('app.sign_cache_time'));

            //设置一次请求的有效时间为10分钟
            if(time()-intval($param['time']) > config('app.app_sign_expire_time')){
                return false;
            }
        }


        $this->headers = $headers;

    }

    public function testAes(){
        $data = input('post.');
//        echo IAuth::setSign();die;
        $str = IAuth::setSign($data);
        (new Aes())->decrypt($str);
    }

}
