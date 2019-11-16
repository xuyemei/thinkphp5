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

    /**
     * 新闻详情页接口
     */
    public function read(){
        $id = input('param.id',0,'intval');
        if(empty($id)){
            throw new ApiException('id is null',404);
        }

        try{
            $news = model('News')->get($id);

        }catch (\Exception $e){
            throw new ApiException('获取新闻出错',404);
        }

        if(empty($news) || $news['status'] != 1){
            throw new ApiException('新闻不存在',404);
        }

//        阅读数加一
        try{
            model('News')->where(['id'=>$id])->setInc('read_count');
        }catch (\Exception $e){
            throw new ApiException('error',400);
        }

        $news->catname = config('cat.lists')[$news->catid];
        return show(config('code.success'),'ok',$news,200);
    }



}
