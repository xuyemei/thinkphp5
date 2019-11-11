<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/6 0006
 * Time: 下午 9:44
 */

namespace app\admin\controller;

use think\Controller;
use app\common\lib\IAuth;

class Login extends Base
{
    public function _initialize()
    {
    }

    public function index(){
        if($this->isLogin()){
            return $this->redirect('Index/inddex');
        }else{
            return $this->fetch();
        }

    }

    public function check(){
       //判断是否是post提交
        if(request()->isPost()){

            $data = input('post.');

            if(!captcha_check($data['code'])){
                $this->error('验证码错误');
            }

            try {
                $user = model('AdminUser')->get(['username' => $data['username']]);
            }catch (\Exception $e) {
                $this->error($e->getMessage());
            }


            if(!$user || $user->status != config('code.admin_user_status_normal')){
                $this->error('用户不存在');
            }else{
                //验证密码
                if(IAuth::setPassword($data['password']) != $user['password']){
                    $this->error('密码不正确');
                }
            }

            $updata = [
                'last_login_time' => time(),
                'last_login_ip'=>request()->ip(),
            ];
            try {
                model('AdminUser')->save($updata, ['id' => $user->id]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            session(config('admin.session_user'),$user,config('admin.session_user_scope'));
//            halt($user);
//            halt(session(config('admin.session_user'),config('admin.session_user_scope')));
            $this->success('登录成功','index/index');

        }else{
            $this->error('请求不合法');
        }
    }

    public function logout(){
        session(null,config('admin.session_user_scope'));
        $this->redirect('Login/index');
    }

}