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
				'encrypt_str' => 'd9d71b495a614afc43dcfc261e91561b',
			],
			[
				'key' => '1234567890123456',
				'str' => '13799760258',
				'encrypt_str' => 'd9d71b495a614afc43dcfc261e915612',
			]
		];
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