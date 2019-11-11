<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/11 0011
 * Time: 下午 1:36
 */

namespace app\common\lib\exception;

use think\exception\Handle;

class ApiHandleException extends Handle{

    public $httpCode = 500;
    public function render(\Exception $e){

        if(config('app_debug') == true){

            return parent::render($e);
        }
        if ($e instanceof ApiException) {
            $this->httpCode = $e->httpCode;
        }
        return show(0,$e->getMessage(),[],$this->httpCode);

    }
}