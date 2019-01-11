<?php 
require_once(__dir__."/../src/Tool/OpensslAes.php");

use PHPUnit\Framework\TestCase;
use Tool\OpensslAes; 
/**
 * 
 */
class OpensslAesTest extends TestCase
{
	public function provider(){
		return [
			[
				'key' => '1234567890123456',
				'str' => '13799760258',
				'encrypt_str' => '8c3c40822c9a4d62976064104114c823',
				'vi' => 'd9d71b495a614afc',
				'cipher_method' => 'AES-128-CBC',
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
	public function testSetKeyViCipherMethod(){
		$func_agrs = func_get_args();
		$key = $func_agrs[0];
		$str = $func_agrs[1];
		$estr = $func_agrs[2];
		$vi = $func_agrs[3];
		$cipher_method = $func_agrs[4];
		$this->assertTrue(OpensslAes::setKey($key));
		$this->assertTrue(OpensslAes::setVi($vi));
		$this->assertTrue(OpensslAes::setCipherMethod($cipher_method));
	}
	/**
	 * @dataProvider provider
	 * @depends testSetKeyViCipherMethod
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-01-11T10:50:43+0800
	 * @param    [type]                   $key [description]
	 * @return   [type]                        [description]
	 */
	public function testGetKeyViCipherMethod(){
		$func_agrs = func_get_args();
		$key = $func_agrs[0];
		$str = $func_agrs[1];
		$estr = $func_agrs[2];
		$vi = $func_agrs[3];
		$cipher_method = $func_agrs[4];
		$this->assertEquals($key,OpensslAes::getKey());
		$this->assertEquals($vi,OpensslAes::getVi());
		$this->assertEquals($cipher_method,OpensslAes::getCipherMethod());
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
		$key = $func_agrs[0];
		$str = $func_agrs[1];
		$estr = $func_agrs[2];
		$encrypt_str = OpensslAes::encrypt($str,$key);
		$this->assertEquals($estr,$encrypt_str);
		return $str;
	}
	/**
	 * @depends testEncrypt
	 * @dataProvider provider
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-01-10T18:19:36+0800
	 * @return   [type]                   [description]
	 */
	public function testDecrypt($str){
		$func_agrs = func_get_args();
		$key = $func_agrs[0];
		$str = $func_agrs[1];
		$estr = $func_agrs[2];
		$descrypt_str = OpensslAes::decrypt($estr,$key);
		$this->assertEquals($str,$descrypt_str);
	}
}