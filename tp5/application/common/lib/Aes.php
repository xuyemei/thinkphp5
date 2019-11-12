<?php
namespace app\common\lib;

/**
 * aes 加密 解密类库
 * @by singwa
 * Class Aes
 * @package app\common\lib
 */
class Aes {

    private $key = null;

    /**
     *
     * @param $key 		密钥
     * @return String
     */
    public function __construct() {
        // 需要小伙伴在配置文件app.php中定义aeskey
        $this->key = config('app.aeskey');
    }

    /**
     * php7 采用open_ssl进行加解密
     * @param string $string 需要加密的字符串
     * @param string $key 密钥
     * @return string
     */
    public function encrypt($string)
    {

        // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
        $data = openssl_encrypt($string, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        $data = bin2hex($data);

        return $data;
    }


    /**
     * @param string $string 需要解密的字符串
     * @param string $key 密钥
     * @return string
     */
    public function decrypt($string)
    {
        $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        return $decrypted;
    }


}