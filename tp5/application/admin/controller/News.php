<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/7 0007
 * Time: 下午 9:31
 */
namespace app\admin\controller;

use think\Controller;
use app\common\validate\News as Vnews;


class News extends Base
{

    public function index(){
        $news = model("News")->getList();
        $this->assign('news', $news);
        return $this->fetch();
    }

       public function add(){

           if(request()->isPost()){
                $data = request()->post();

                $validate = validate('Newss');
                if(!$validate->check($data)){
                    return $this->result('',2,$validate->getError());
                }

                //保存数据
               try{
                   $news_id = model('News')->add($data);
               }catch (\Exception $e){
                    return $this->result('',1,'新增失败');
               }

               if($news_id){
                   return $this->result(['jump_url'=>url('news/index')],0,'ok');
               }

           }else{
               $cats = config('cat.lists');
               return $this->fetch('',[
                   'cats'=>$cats,
               ]);
           }

           }


}