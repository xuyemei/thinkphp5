<?php
namespace app\api\controller\v1;

use think\Controller;
use app\common\lib\exception\ApiException;
use app\api\controller\Common;


class Index extends Common
{

    /**
     * 首页接口
     * @return \think\response\Json
     */
    public function index(){

        //首页头图新闻
        $heads = model('News')->getIndexHeadNormalNews();
        $news = $this->getCatname($heads);

        //首页推荐位新闻
        $positions = model('News')->getIndexPositionNormalNews();
        $positions = $this->getCatname($positions);

        $resutl = [
            'heads'=>$heads,
            'position'=>$positions,
        ];

        return show(config('app.success'),'ok',$resutl,200);
    }



}
