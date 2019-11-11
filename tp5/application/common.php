<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function pagination($obj){
    if(!$obj){
        return '';
    }
    $params = request()->param();
    return '<div class="imooc-app">'.$obj->appends($params)->render().'</div>';
}

function getCatname($catid){

    if(!$catid){
        return '';
    }

    $cats = config('cat.lists');
    return !empty($catid) ? $cats[$catid] : '';
}

function getText($num){
    return $num ? "是" : "否";
}

/**
 * 接口返回数据格式封装
 * @param int $status
 * @param str $message
 * @param array $data
 * @param int $httpCole
 */
function show($status,$message,$data=[],$httpCole=200){

    $data = [
        'status'=>$status,
        'message'=>$message,
        'data'=>$data,
    ];
    return json($data,$httpCole);
}