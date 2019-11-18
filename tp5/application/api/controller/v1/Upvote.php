<?php
namespace app\api\controller\v1;

use app\common\lib\Aes;
use app\common\lib\IAuth;
use think\Controller;
use app\common\lib\exception\ApiException;
use app\api\controller\Common;
use app\common\lib\PageFromSize;
use think\Request;


class User extends BaseAuth
{

    /**
     * 获取用户信息
     * @return \think\response\Json
     */
    public function read(){

        $Aes = new Aes();
//        用户数据需加密传输
        return show(config('code.success'),'ok',$Aes->encrypt(json_encode($this->user)));

    }

    /**
     *
     * 跟新用户数据
     */
    public function  update(){
        $postData = input('param.');

        $data = [];

        if(!empty($postData['username'])){
            $data['username'] = $postData['username'];
        }

        if(!empty($postData['image'])){
            $data['image'] = $postData['image'];
        }

        if(!empty($postData['sex'])){
            $data['sex'] = $postData['sex'];
        }

        if(!empty($postData['signature'])){
            $data['signature'] = $postData['signature'];
        }

        if(!empty($postData['password'])){
//            对客户端传过来的password 进行解密
            $password = (new Aes())->decrypt($postData['password']);
            $data['password'] = IAuth::setPassword($password);
        }

        if(empty($data)){
            return show(config('code.error'),'数据不合法',401);
        }

        try{
            $res  = model('User')->save($data,['id'=>$this->user->id]);
            if($res){
                return show(config('code.success'),'ok',[],202);

            }else{
                return show(config('code.error'),'修改失败',[],403);
            }
        }catch (\Exception $e){
            return show(config('code.error'),$e->getMessage(),[],500);
        }
    }


    /**
     * 验证用户名唯一
     * @return \think\response\Json
     *
     */
    public function checkUserName(){
        $username = input('param.username');
        if(empty($username)){
            return show(config('code.error'),'用户名不能为空',[],401);
        }

//        查询该用户名是否被占用
        $user = model('User')->get(['username'=>$username]);
        if($user && $user->id != $this->user->id){
            return show(config('code.error'),'用户名已经被占用',[],403);
        }

        return show(config('code.success'),'ok',[],201);
    }

}
