<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/6 0006
 * Time: 下午 8:57
 */
namespace app\common\model;

use \think\Model;

class News extends Base{

    public function getList(){

        $where = [
            'status'=>['neq',config('code.admin_user_status_delete')],
        ];
        $order = [
            'update_time'=>'desc'
        ];
        $news = $this->where($where)->order($order)->paginate(5);
        return $news;
    }

}