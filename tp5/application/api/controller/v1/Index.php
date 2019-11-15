<?php
namespace app\api\controller\v1;

use think\Controller;
use app\common\lib\exception\ApiException;
use app\api\controller\Common;


class Cat extends Common
{

    /**
     * 读取新闻栏目接口
     * @return \think\response\Json
     */
    public function read(){
        $cats = config('cat.lists');

        $result[] = [
            'catid'=>0,
            'catname'=>'首页',
        ];

        foreach ($cats as $key=>$value){
            $result[]=[
                'catid'=>$key,
                'catname'=>$value,
            ];
        }

        return show(config('code.success'),'ok',$result,200);
    }

}
