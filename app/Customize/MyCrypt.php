<?php
/*
 * @package [App\Customize]
 * @author [李志刚]
 * @createdate  [2018-04-03]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions mcrypt des方式加解密
 *
 */
namespace App\Customize;

class MyCrypt
{
    /*
    * openssl_encrypt 方式更适合php7.2及以上版本 2018-04-03
    * openssl_encrypt (PHP 5 >= 5.3.0, PHP 7)
     */
    /**向量
     * @var string
     */
    const IV = "lLBvDbxgqUStnz87";//16位
    /**
     * 默认秘钥
     */
    const KEY = 'd22icaUY3o9NpQM0';//16位
    /**
     * 解密字符串
     * @param string $data 字符串
     * @param string $key 加密key
     * @return string
     */
    public static function ssl_decrypt($data,$key = self::KEY,$iv = self::IV){
        return openssl_decrypt(base64_decode($data),"AES-128-CBC",$key,OPENSSL_RAW_DATA,$iv);
    }
    /**
     * 加密字符串
     * @param string $data 字符串
     * @param string $key 加密key
     * @return string
     */
    public static function ssl_encrypt($data,$key = self::KEY,$iv = self::IV){
        return base64_encode(openssl_encrypt($data,"AES-128-CBC",$key,OPENSSL_RAW_DATA,$iv));
    }
    /*
    * Mcrypt 方式不适合php7.2及以上版本 2018-04-03
    * mcrypt_generic (PHP 4 >= 4.0.2, PHP 5, PHP 7 < 7.2.0, PECL mcrypt >= 1.0.0)
     */
    private $key = 'jxf-credit-voucher-keys';
    // 解密
    public static function decrypt($decrypt) {
        /* 打开加密算法和模式 */
        $td = mcrypt_module_open('des', '', 'ecb', '');
        /* 创建初始向量，并且检测密钥长度。
        * Windows 平台请使用 MCRYPT_RAND。 */
        // get_iv_size 返回打开的算法的初始向量大小,从随机源创建初始向量
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);
        // 返回打开的模式所能支持的最长密钥
        $ks = mcrypt_enc_get_key_size($td);
        /* 创建密钥 */
        $key = substr(md5($this->key), 0, $ks);
        /* 初始化解密模块 */
        mcrypt_generic_init($td, $key, $iv);
        /* 解密数据 */
        $decrypted = mdecrypt_generic($td, $this->base64url_decode($decrypt));
        /* 结束解密，执行清理工作，并且关闭模块 */
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $decrypted;
    }
    // 加密
    public static function encrypt($encrypt) {
        /* 打开加密算法和模式 */
        $td = mcrypt_module_open('des', '', 'ecb', '');
        /* 创建初始向量，并且检测密钥长度。
        * Windows 平台请使用 MCRYPT_RAND。 */
        // get_iv_size 返回打开的算法的初始向量大小,从随机源创建初始向量
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);
        // 返回打开的模式所能支持的最长密钥
        $ks = mcrypt_enc_get_key_size($td);
        /* 创建密钥 */
        $key = substr(md5($this->key), 0, $ks);
        /* 初始化加密 */
        mcrypt_generic_init($td, $key, $iv);
        /* 加密数据 */
        $encrypted = $this->base64url_encode(mcrypt_generic($td, $encrypt));
        /* 结束，执行清理工作，并且关闭模块 */
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $encrypted;
    }

    // 增加对url友好的支持
    private function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    private function base64url_decode($data) {
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}
