<?php 
namespace Tool;

/**
 * 基于openssl加解密类
 * (PHP 5 >= 5.3.0, PHP 7)
 * 
 */
class OpensslAes {
	//加密密钥
	private static $key = 'c32ac3ds0vk1209c';
	//向量
	private static $vi = 'd9d71b495a614afc';
	//加密密码模式
	private static $cipherMethod = 'AES-128-CBC';
    /**
     * 加密方法
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2019-01-10T17:37:23+0800
     * @param    string                   $str 待加密字符串
     * @param    string                   $key    密钥(16位字符)
     * @return   string                           加密后的字符串
     */
    public static function encrypt($str, $key='', $vi='')
    {
        if (!extension_loaded('openssl')) {
            throw new \Exception("You must be install openssl.so. The extension.", 1);
        }
    	if (empty($key)) {
    		$key = self::getKey();
    	}
    	if (empty($vi)) {
    		$vi = self::getVi();
    	}
        $data = openssl_encrypt($str, self::getCipherMethod(), $key, OPENSSL_RAW_DATA, $vi);
        $data = strtolower(bin2hex($data));//二进行制转十六制再转小写
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
    public static function decrypt($str, $key='', $vi='')
    {
        if (!extension_loaded('openssl')) {
            throw new \Exception("You must be install openssl.so. The extension.", 1);
        }
    	if (empty($key)) {
    		$key = self::getKey();
    	}
    	if (empty($vi)) {
    		$vi = self::getVi();
    	}
    	$data = hex2bin($str);//十六进制转二进制
        $decrypted = openssl_decrypt($data, self::getCipherMethod(), $key, OPENSSL_RAW_DATA, $vi);
        return $decrypted;
    }
    /**
     * 获取加密密钥
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2019-01-11T09:40:40+0800
     * @return   string                  密钥 
     */
    public static function getKey(){
    	return self::$key;
    }
    /**
     * 设置加密密钥
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2019-01-11T09:41:10+0800
     * @param    string                   $key 加密密钥
     */
    public static function setKey($key){
    	self::$key = $key;
    	return true;
    }
    /**
     * 获取向量
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2019-01-11T09:41:52+0800
     * @return   string                   向量值
     */
    public static function getVi(){
    	return self::$vi;
    }
    /**
     * 设置
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2019-01-11T09:42:47+0800
     * @param    string                   $vi 向量值
     */
    public static function setVi($vi){
    	self::$vi = $vi;
    	return true;
    }
    /**
     * 获取密码加密方法
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2019-01-11T09:41:52+0800
     * @return   string                   加密密码方法
     */
    public static function getCipherMethod(){
    	return self::$cipherMethod;
    }
    /**
     * 设置密码加密方法
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2019-01-11T09:42:47+0800
     * @param    string                   $vi 加密密码方法
     */
    public static function setCipherMethod($cipherMethod){
    	self::$cipherMethod = $cipherMethod;
    	return true;
    }
}
