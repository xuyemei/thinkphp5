<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/7 0007
 * Time: 下午 10:10
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\lib\Upload;


class Image extends Base
{

    public function upload0()
    {
        $file = Request::instance()->file('file');
        $info = $file->move('upload');
        if ($info && $info->getPathname()) {
            $data = [
                'status' => 1,
                'massage' => 'ok',
                'data' => '/' . $info->getPathname(),
            ];
            echo json_encode($data);
            exit;
        } else {
            $data = [
                'status' => 0,
                'massage' => 'error',
                'data' => '上传失败',
            ];
            echo json_encode($data);
            exit;
        }
    }


        /**
         * 七牛图片上传
         */
        public function upload(){


            try{
                $img = Upload::image();
            }catch (\Exception $e){
                return json_encode([
                    'status'=>2,
                    'massage'=>$e->getMessage(),
                ]);
            }


            if($img){
                $data = [
                    'status'=>0,
                    'message'=>'ok',
                    'data'=>config('qiniu.image_url').$img,
                ];
                return json_encode($data);
            }else{
                return json_encode(['status'=>1,'message'=>'上传失败']);
            }


        }
}