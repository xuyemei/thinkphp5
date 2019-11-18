<?php
namespace app\api\controller\v1;

use app\common\lib\Aes;
use app\common\lib\IAuth;
use think\Controller;
use app\common\lib\exception\ApiException;
use app\api\controller\Common;
use app\common\lib\PageFromSize;
use think\Request;


class Upvote extends BaseAuth
{

    /**
     * 点赞接口
     * @return \think\response\Json
     * @throws ApiException
     *
     */

    public function save(){
        $news_id = input('param.news_id');
        if(empty($news_id)){
            return show(config('code.error'),'news_id错误',[],401);
        }

        $news = model('News')->get(['id'=>$news_id]);
        if(empty($news) || $news->status != config('code.status_normal')){
            return show(config('code.error'),'新闻不存在',[],404);
        }

        //判断是否已经点在过
        $user_news = model('UserNews')->get(['news_id'=>$news_id,'user_id'=>$this->user->id]);
//        var_dump($user_news);
//        echo model('UserNews')->getLastSql();die;
        if(!empty($user_news)){
            return show(config('code.error'),'该用户已经点赞过该文章',[],401);
        }

        //点赞通过，写库\
        try{
            $id = model('UserNews')->add([
                'news_id'=>$news_id,
                'user_id'=>$this->user->id,
            ]);
            if(empty($id)){
                return show(config('code.error'),'1点赞失败',[],500);
            }else{
                model("News")->where(['id'=>$news_id])->setInc('upvote_count');
                return show(config('code.success'),'ok',[],202);
            }
        }catch (\Exception $e){
            throw new ApiException('点赞失败',500);
        }


    }

    /**
     *
     * 取消点赞接口
     */
    public function delete(){
        $news_id = input('param.news_id');
        if(empty($news_id)){
            return show(config('code.error'),'news_id错误',[],401);
        }

        $news = model('News')->get(['id'=>$news_id]);
        if(empty($news) || $news->status != config('code.status_normal')){
            return show(config('code.error'),'新闻不存在',[],404);
        }

        //判断是否已经点在过
        $user_news = model('UserNews')->get(['news_id'=>$news_id,'user_id'=>$this->user->id]);

        if(empty($user_news)){
            return show(config('code.error'),'没有点赞过',[],401);
        }

        try{
            $UserNews_id = model('UserNews')->where([
                'news_id'=>$news_id,
                'user_id'=>$this->user->id,
            ])->delete();
            if(empty($UserNews_id)){
                return show(config('code.error'),'取消失败',[],500);
            }else{
                model('News')->where(['id'=>$news_id])->setDec('upvote_count');
                return show(config('code.success'),'ok',[],202);
            }
        }catch (\Exception $e){
            return show(config('code.error'),'取消失败',[],500);
        }

    }

    /**
     * 文章是否被用户点赞接口
     */
    public function read(){
        $news_id = input('param.news_id');
        if(empty($news_id)){
            return show(config('code.error'),'news_id错误',[],401);
        }

        $news = model('News')->get(['id'=>$news_id]);
        if(empty($news) || $news->status != config('code.status_normal')){
            return show(config('code.error'),'新闻不存在',[],404);
        }

        //判断是否已经点在过
        $user_news = model('UserNews')->get(['news_id'=>$news_id,'user_id'=>$this->user->id]);
        if(empty($user_news)){
            return show(config('code.success'),'0',[],201);
        }else{
            return show(config('code.success'),'1',[],201);

        }
    }

}
