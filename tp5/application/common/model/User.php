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

    /**
     * 根据条件获取新闻列表
     * @param array $condition
     * @param $from
     * @param $size
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNewsByCondition($condition =[],$from=0,$size=5){

        if(!isset($condition['status'])){
            $condition['status'] = [
                'neq',config('code.status_delete'),
            ];
        }
        $order = [
            'id'=>'desc',
        ];

        $result = $this->where($condition)
            ->field(['id','title','catid','image','update_time','is_position','status','read_count'])
            ->limit($from,$size)
            ->order($order)
            ->select();
        return $result;
    }


    /**
     * 根据条件获取新闻数量
     * @param array $param
     * @return int|string
     */
    public function getCountByCondition($condition=[]){

        if(!isset($condition['status'])){
            $condition['status'] = [
                'neq',config('code.status_delete'),
            ];
        }
        $count = $this
            ->where($condition)
            ->count();
        return $count;
    }


    /**
     * 获取首页头图的数据
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     *
     */
    public function getIndexHeadNormalNews($num = 4){
        $data = [
            'status'=>1,
            'is_head_figure'=>1,
        ];
        $order = ['id'=>'desc'];

        $news = $this
            ->where($data)
            ->field(['id','image','catid','title','read_count'])
            ->order($order)
            ->limit($num)
            ->select();

        return $news;
    }

    public function getIndexPositionNormalNews($num = 20){
        $data = [
            'status'=>1,
            'is_position'=>1,
        ];
        $order = ['id'=>'desc'];

        $news = $this
            ->where($data)
            ->field(['id','image','catid','title','read_count'])
            ->order($order)
            ->limit($num)
            ->select();
        return $news;
    }


    /**
     * 获取排行榜前五（阅读数前五）
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     *
     */
    public function getRankNews($num = 5){
        if(!isset($condition['status'])){
            $condition['status'] = [
                'neq',config('code.status_delete'),
            ];
        }
        $order = [
            'read_count'=>'desc',
        ];

        $result = $this->where($condition)
            ->field(['id','title','catid','image','update_time','is_position','status','read_count'])
            ->limit(0,$num)
            ->order($order)
            ->select();
        return $result;
    }

}