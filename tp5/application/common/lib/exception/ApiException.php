<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/11 0011
 * Time: 下午 1:36
 */

namespace app\common\lib\exception;

use think\Exception;

class ApiException extends Exception {

    public $message = '';
    public $httpCode = 500;
    public $code = 0;

    /**
     * 重新定义客户端异常处理
     * ApiException constructor.
     * @param string $message
     * @param int $httpCode http状态码
     * @param Throwable $code 业务状态码
     */
    public function __construct($message = "", $httpCode,$code=0)
    {

        $this->message = $message;
        $this->httpCode = $httpCode;
        $this->code = $code;

    }
}