<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/10 0010
 * Time: 上午 11:43
 */

namespace app\common\model;

use \think\Model;

class Base extends Model{
    protected $autoWriteTimestamp=true;
    //增加数据
    public function add($data){

        if(!is_array($data)){
            exception('传递数据不正确');
        }
        $this->allowField(true)->save($data);
        //插入成功，返回插入数据的id
        return $this->id;
    }
}