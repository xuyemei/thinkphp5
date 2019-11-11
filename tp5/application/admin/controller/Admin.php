<?php
namespace app\admin\controller;

use think\Controller;
use app\common\validate\AdminUser;

class Admin extends Controller
{
    public function add()
    {
        //判断是否是post提交
        if(request()->isPost()){
            $data = input('post.');
            $validate = validate('AdminUser');

            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
                $data['password'] = md5($data['password']);
                $data['status'] = 1;
                try{
                   $insertId = model('AdminUser')->add($data);
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                }
                $this->success('数据插入成功,id为:'.$insertId);
            }
        }else{

            return $this->fetch();
        }

    }


}
