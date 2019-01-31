<?php 
require_once(__dir__."/../src/Tool/LogAnalysis.php");

use PHPUnit\Framework\TestCase;
use Tool\LogAnalysis; 
/**
 * 
 */
class LogAnalysisTest extends TestCase
{
	public function testAnalysisLogFile(){
		$inputFile = '/usr/local/src/2019-01-30.log';
		$outputFile = '/usr/local/src/2019-01-30.csv';
		LogAnalysis::setFlowLine(4);//设置日志行流量的列数;默认为4
		$res = LogAnalysis::analysisLogFile($inputFile,$outputFile);
		$this->assertTrue($res);
	}
}