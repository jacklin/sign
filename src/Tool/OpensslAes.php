<?php 
namespace Tool;

/**
 * 基于openssl加解密类
 * (PHP 5 >= 5.3.0, PHP 7)
 */
class OpensslAes {
    /**
     * 加密方法
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2019-01-10T17:37:23+0800
     * @param    string                   $string 待加密字符串
     * @param    string                   $key    密钥(16位字符)
     * @return   string                           加密后的字符串
     */
    public static function encrypt($string, $key)
    {

        // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
        $data = openssl_encrypt($string, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

        $data = strtolower(bin2hex($data));

        return $data;
    }
    /**
     * 解密码方法
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2019-01-10T17:40:03+0800
     * @param    string                   $string 待解密字符串
     * @param    string                   $key    密钥(16位字符)
     * @return   string                           解密后字符串
     */
    public static function decrypt($string, $key)
    {
        $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

        return $decrypted;
    }
}
