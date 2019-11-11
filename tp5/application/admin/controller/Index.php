<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
//        halt(session('adminUser'));

        return $this->fetch();
    }

    public function welcome(){
        return 'hello';
    }
}
