<?php 
require_once(__dir__."/../src/Tool/OpensslRsa.php");

use PHPUnit\Framework\TestCase;
use Tool\OpensslRsa; 
/**
 * 
 */
class OpensslRsaTest extends TestCase
{
	public function provider(){
		return [
			[
				'public_key' => './opensslkey/rsa_public_key.pem',
				'private_key' => './opensslkey/rsa_private_key_pkcs8.pem',
				'str' => '88eab79690b2c9c1c39c0cc523ad1118',
			],
			// [
			// 	'key' => '1234567890123456',
			// 	'str' => '13799760257',
			// 	'encrypt_str' => 'b34734f690e2ceaa0607dbb7f2ff8751',
			// ],
			// [
			// 	'key' => '1234567890123457',
			// 	'str' => '13799760257',
			// 	'encrypt_str' => '76e77fa5bbee01eb97ab9cc9726e2621',
			// ],
			// [
			// 	'key' => '',
			// 	'str' => '13799760257',
			// 	'encrypt_str' => '874890d8903820445be1441ebc19c7dc',
			// ]
		];
	}

	/**
	 * @dataProvider provider
	 * [testSetKey description]
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-01-11T10:46:29+0800
	 * @return   [type]                   [description]
	 */
	public function testSetKey(){
		$func_agrs = func_get_args();
		$public_key_file = $func_agrs[0];
		$private_key_file = $func_agrs[1];
		$this->assertTrue(OpensslRsa::setPublicKeyFilePath($public_key_file));
		$this->assertTrue(OpensslRsa::setPrivateKeyFilePath($private_key_file));
	}
	/**
	 * @dataProvider provider
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-01-10T18:47:00+0800
	 * @return   [type]                   [description]
	 */
	public function testEncrypt(){
		$func_agrs = func_get_args();
		$func_agrs = func_get_args();
		$public_key_file = $func_agrs[0];
		$private_key_file = $func_agrs[1];
		$str = $func_agrs[2];
		OpensslRsa::setPublicKeyFilePath($public_key_file);
		OpensslRsa::setPrivateKeyFilePath($private_key_file);
		echo PHP_EOL;
		echo $str.PHP_EOL;
		$encrypt_str = OpensslRsa::privateEncrypt($str);
		echo $encrypt_str.PHP_EOL;
		$descrypt_str = OpensslRsa::publicDescrypt($encrypt_str);
		echo $descrypt_str.PHP_EOL;
		$this->assertEquals($str,$descrypt_str);
		$encrypt_str = OpensslRsa::publicEncrypt($str);
		echo $encrypt_str.PHP_EOL;
		$descrypt_str = OpensslRsa::privateDescrypt($encrypt_str);
		echo $descrypt_str.PHP_EOL;
		$this->assertEquals($str,$descrypt_str);
	}
	/**
	 * @dataProvider provider
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2020-03-06T10:56:36+0800
	 * @return   [type]                   [description]
	 */
	public function testSignVerify(){
		$func_agrs = func_get_args();
		$func_agrs = func_get_args();
		$public_key_file = $func_agrs[0];
		$private_key_file = $func_agrs[1];
		$str = $func_agrs[2];
		OpensslRsa::setPublicKeyFilePath($public_key_file);
		OpensslRsa::setPrivateKeyFilePath($private_key_file);
		if (($sign = OpensslRsa::sign($str)) !== false) {
			echo PHP_EOL;
			echo $sign . PHP_EOL;
			$verify_result = OpensslRsa::verify($str,$sign);
			$this->assertEquals($verify_result,1);
		}else{
			throw new \Exception("Error:" . openssl_error_string());
		}
	}
}