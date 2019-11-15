<?php
namespace app\api\controller\v1;

use think\Controller;
use app\common\lib\exception\ApiException;
use app\api\controller\Common;
use app\common\lib\PageFromSize;


class News extends Common
{

    /**
     * 获取新闻列表接口
     * @return \think\response\Json
     */
    public function index(){
        //需要的参数：catid,分页相关
        $param = input('param.');

        if(!empty($param['catid'])){
            $whereData['catid'] = $param['catid'];
        }

        if(!empty($param['title'])){
            $whereData['title'] = ['like','%'.$param['title'].'%'];
        }

        //获取记录的总数
        $total = model('News')->getCountByCondition($whereData);
        $pageFromSize = PageFromSize::getInstance();
        $pageData = [
            'page'=>!empty($param['page']) ? $param['page'] : 1,
            'total'=>$total,
        ];
        $page = $pageFromSize->getFromSize($pageData);

        $news = model('News')->getNewsByCondition($whereData,$page['from'],$page['size']);

        $result =[
            'total'=>$total,
            'page_num'=>$page['total_page'],
            'list'=>$news
        ];

        return show(1,'ok',$result,200);
    }



}
