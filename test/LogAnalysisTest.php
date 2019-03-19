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
		$inputFile = '/usr/local/src/2019-03-19-0800-0859_apk9.ww.cdn.7723.com.cn.log';
		$outputFile = '/usr/local/src/2019-03-19-0800-0859_apk9.ww.cdn.7723.com.cn.log.cvs';
		LogAnalysis::setFlowLine(10);//设置日志行流量的列数;默认为4
		LogAnalysis::setTimeLine(4);//设置日志行时间的列数;默认为1
		LogAnalysis::setTimeFormat("d\/M\/Y:H:i:s");//设置日志行时间的格式
		LogAnalysis::setTimeRegx("/\[/");//设置日志行时间的过滤正则表达式
		$res = LogAnalysis::analysisLogFile($inputFile,$outputFile);
		$this->assertTrue($res);
	}
}