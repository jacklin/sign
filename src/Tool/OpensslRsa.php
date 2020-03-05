<?php
namespace Tool;

/**
 * Openssl使用非对称加解密
 */
class OpensslRsa
{
	const KEYSIZE = 2048;
	//公钥文件路径，如：/rsa_public_key.pem
	private static $publicKeyFilePath;
	//私钥文件路径，如：/rsa_private_key.pem
	private static $privateKeyFilePath;

	//设置公钥文件路径
	public static function setPublicKeyFilePath($filePath){
		self::$publicKeyFilePath = $filePath;
	}
	/**
	 * 获取公钥
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2020-03-05T11:05:21+0800
	 * @return   string|mixed                   返回public key
	 */
	public static function getPublicKey(){
		if (is_file(self::$publicKeyFilePath)) {
			return openssl_get_publickey(file_get_contents(self::$publicKeyFilePath));
		}else{
			throw new Exception("no such public key file!");
		}
	}
	//设置私钥文件路径
	public static function setPrivateKeyFilePath($filePath){
		self::$privateKeyFilePath = $filePath;
	}
	/**
	 * 获取私钥
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2020-03-05T11:06:11+0800
	 * @return   string|mixed                   返回private key
	 */
	public static function getPrivateKeyFilePath(){
		if (is_file(self::$privateKeyFilePath)) {
			return openssl_get_privatekey(file_get_contents(self::$privateKeyFilePath));
		}else{
			throw new Exception("no such private key file!");
		}
	}
	/**
	 * 私钥加密
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2020-03-05T11:31:41+0800
	 * @param    string                   $str 待加密字符串
	 * @return   string                        加密后的字符串并进行base64编码
	 */
	public static function privateEncrypt($str){
		$data = "";
		$dataArray = str_split($str, self::KEYSIZE/8);
		$key = self::getPrivateKey();
		foreach ($dataArray as $value) {
		    $encryptedTemp = ""; 
		    openssl_private_encrypt($value,$encryptedTemp,$key,OPENSSL_PKCS1_PADDING);
		    $data .= $encryptedTemp;
		}
		openssl_free_key($key);
		return base64_encode($data);
	}
	/**
	 * 公钥解密
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2020-03-05T11:32:45+0800
	 * @param    string                   $str 待加密字符串
	 * @return   string                        解密后的字符串
	 */
	public static function publicDescrypt($str){
		$decrypted = "";
		$decodeStr = base64_decode($str);
		$key = self::getPublicKey();
		$enArray = str_split($decodeStr, self::KEYSIZE/8);

		foreach ($enArray as $va) {
		    $decryptedTemp = "";
		    openssl_public_decrypt($va,$decryptedTemp,$key,OPENSSL_PKCS1_PADDING);
		    $decrypted .= $decryptedTemp;
		}
		openssl_free_key($key);
		return $decrypted;
	}
	/**
	 * 公钥加密
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2020-03-05T11:33:48+0800
	 * @param    string                   $str 待加密字符串
	 * @return   string                        加密后的字符串
	 */
	public static function publicEncrypt($str){
		$data = "";
		$key = self::getPublicKey();
		$dataArray = str_split($str, self::KEYSIZE/8);
		foreach ($dataArray as $value) {
		   $encryptedTemp = ""; 
		   openssl_public_encrypt($value,$encryptedTemp,$key,OPENSSL_PKCS1_PADDING);
		   $data .= $encryptedTemp;
		}
		openssl_free_key($key);
		return base64_encode($data);
	}
	/**
	 * 私钥解密
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2020-03-05T11:35:02+0800
	 * @param    string                   $str 加密后的字符串
	 * @return   string                        解密后的字符串
	 */
	public static function privateDescrypt($str){
		$decrypted = "";
		$decodeStr = base64_decode($str);
		$key = self::getPrivateKey();
		$enArray = str_split($decodeStr, self::KEYSIZE/8);

		foreach ($enArray as $va) {
		    $decryptedTemp = "";
		    openssl_private_decrypt($va,$decryptedTemp,$key,OPENSSL_PKCS1_PADDING);
		    $decrypted .= $decryptedTemp;
		}
		openssl_free_key($key);
		return $decrypted;
	}

}