<?php
namespace app\api\controller;

use think\Controller;
use app\common\lib\exception\ApiException;

class Test extends Controller
{
    public function save()
    {

        $data = input('post.');
        if($data['mt'] != 1){
            exception('数据不合法哦');
            throw new ApiException('数据不合法哦',403);
        }

        return show(1,'ok',$data,201);
    }

    public function welcome(){
        return 'hello';
    }
}
