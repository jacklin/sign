<?php 
require_once(__dir__."/vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use Tool\VirusArtists; 
/**
 * 
 */
class VirusArtistsTest extends TestCase
{
	public function testScanUrlFile(){
		$url = 'http://appdown.7723.cn/7723box/test/7723_release-v3.2.3_323_2017.11.17-17.10_dev_test.apk';
		VirusArtists::setTempPath(__dir__);
		$res = VirusArtists::scanUrlFile($url);
		$this->assertSame($res,['status'=>1,'description'=>"The file is safe!"]);
	}
}
