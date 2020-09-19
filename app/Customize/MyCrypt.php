<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: AES/RSA 加解密
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 21:48:03
 * @FilePath: /CoinCMF/app/Customize/MyCrypt.php
 */

namespace App\Customize;

class MyCrypt
{
    /**
     * 解密字符串
     * @param string $data 字符串
     * @param string $key 加密key
     * @return string
     */
    public static function ssl_decrypt($data)
    {
        $iv = config('rsa.aes_iv');
        $key = config('rsa.aes_key');
        return openssl_decrypt(base64_decode($data), "AES-128-CBC", $key, true, $iv);
    }
    /**
     * 加密字符串
     * @param string $data 字符串
     * @param string $key 加密key
     * @return string
     */
    public static function ssl_encrypt($data)
    {
        $iv = config('rsa.aes_iv');
        $key = config('rsa.aes_key');
        return base64_encode(openssl_encrypt($data, "AES-128-CBC", $key, true, $iv));
    }
    // RSA 加密、解密==公钥、私钥
    // $publicKey = config('rsa.rsa_public_key');
    // $privateKey = config('rsa.rsa_private_key'); 

    /**     
     * @uses 公钥加密     
     * @param string $data     
     * @return null|string     
     */
    public static function publicEncrypt($data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        $publicKey = config('rsa.rsa_public_key');
        return openssl_public_encrypt($data, $encrypted, $publicKey) ? base64_encode($encrypted) : null;
    }
    /**     
     * @uses 公钥解密     
     * @param string $encrypted     
     * @return null     
     */
    public function publicDecrypt($encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        $publicKey = config('rsa.rsa_public_key');
        return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, $publicKey)) ? $decrypted : null;
    }
    /**
     * 私钥加密
     */
    public static function privEncrypt($data)
    {
        if (!is_string($data)) {
            return null;
        }
        $privateKey = config('rsa.rsa_private_key');
        return openssl_private_encrypt($data, $encrypted, $privateKey) ? base64_encode($encrypted) : null;
    }
    /**
     * 私钥解密
     */
    public static function privDecrypt($encrypted)
    {
        if (!is_string($encrypted)) {
            return null;
        }
        $privateKey = config('rsa.rsa_private_key');
        $privateKey = openssl_pkey_get_private($privateKey);
        $res = openssl_private_decrypt(base64_decode($encrypted), $decrypted, $privateKey);
        return $res ? $decrypted : null;
    }
}
