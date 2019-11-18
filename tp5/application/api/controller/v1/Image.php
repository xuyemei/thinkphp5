<?php
namespace app\api\controller\v1;

use app\common\lib\Aes;
use think\Controller;
use app\common\lib\exception\ApiException;
use app\api\controller\Common;
use app\common\lib\PageFromSize;


class User extends BaseAuth
{

    /**
     * 获取用户信息
     * @return \think\response\Json
     */
    public function read(){

        $Aes = new Aes();
//        用户数据需加密传输
        return show(config('code.success'),'ok',$Aes->encrypt(json_encode($this->user)));

    }

}
