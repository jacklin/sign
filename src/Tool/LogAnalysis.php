<?php 	
namespace Tool; 
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

/**
 * 日志分析工具
 * 默认按5分钟颗粒
 */
class LogAnalysis
{
	public static $preTime = 300;//5min
	public static $ret = [];//日志分析结果集
	public static $flowLine = 4;//日志记录流量的按空格分隔第几列，默认4
	public static $separate = ' ';//默认空格符
	public static $timeLine = 4;//日志格式记录时间按空格分隔第几列，默认4
	public static $timeRegx = "/\[/";//日志格式记录时间字段正则表达式
    public static $timeFromat= "";//日志格式记录时间字段格式 d\/M\/Y:H:i:s


		/**
	 * 设置日志行中第几列
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-01-31T10:40:42+0800
	 * @param    string                   $line 日志中流量列
	 * @return   void                        
	 */
	public static function setFlowLine($line=4){
		self::$flowLine = $line;
	}

    /**
     * @param string $str 指定分隔符
     */
    public static function setSeparate($str=' '){
	    self::$separate = $str;
    }

    /**
     * @param int 指定时间列
     */
    public static function setTimeLine($line=4){
        self::$timeLine = $line;
    }
    /**
     * @param int 指定时间字段正则表达式
     */
    public static function setTimeRegx($str){
        self::$timeRegx = $str;
    }

    /**
     * @para void 指定时间字段格式化
     */
    public static function setTimeFormat($formatStr ){
        self::$timeFromat = $formatStr;
    }
	/**
	 * 分析每行
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-01-31T10:40:42+0800
	 * @param    [type]                   $str 日志一行
	 * @return   void                        
	 */
	private static function dealStr($str){
        $str = preg_replace(self::$separate,' ',$str);
		$res = explode(' ',$str);//空格分隔
        $str_time = preg_replace(self::$timeRegx,'',$res[self::$timeLine-1]);
        $date_time = \DateTime::createFromFormat(self::$timeFromat,$str_time,(new \DateTimeZone('Asia/Shanghai')));
        if ($date_time){
            $timestamp  = $date_time->getTimestamp();
        }else{
            throw new Exception("时间格式化有问题");
        }
        $t = $timestamp;
		$flow = $res[self::$flowLine-1]??0;//流量
		self::compareTime($t,$flow);
	}
	/**
	 * 记录颗粒结果值
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-01-31T10:40:56+0800
	 * @param    [type]                   $t    时间
	 * @param    [type]                   $flow 流量
	 * @return   void                         
	 */
	private static function compareTime($t,$flow){
        date_default_timezone_set('Asia/Shanghai');
        $log_day = strtotime(date('Y-m-d',$t));
        $a = intval($t-$log_day);//当天的第几秒

		$res_key = intdiv($a,self::$preTime)*self::$preTime+$log_day;//时间颗粒
        if(isset(self::$ret[$res_key])&&!empty(self::$ret[$res_key])){
            self::$ret[$res_key]['rate'] += (int)$flow;
        }else{
            self::$ret[$res_key]['date'] = date('Y-m-d H:i:s',$res_key);
            self::$ret[$res_key]['rate'] = (int)$flow;
        }
    }
	/**
	 * 分析日志文件
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-01-31T10:59:05+0800
	 * @param    string                   $file    日志文件
	 * @param    string                   $outfile 分析结果文件
	 * @return   boolean                            
	 */
	public static function analysisLogFile($logFile,$outFile='./analysis_log.csv'){
		$handle = @fopen($logFile, "r");
		if ($handle) {
			$i = 0;
		    while (($buffer = fgets($handle, 4096)) !== false) {
		       self::dealStr($buffer);
		    }
		    ksort(self::$ret);
		    foreach (self::$ret as $value) {
		    	$bandwidth = round($value['rate']/1000/125/self::$preTime,2);//单位Mbps
		    	$flow = round($value['rate']/1000/1000/1000,3);//单位GB
		    	$txt = $value['date']."\t".$flow."GB\t".$bandwidth."Mbps".PHP_EOL;//时间点
		    	try{
			    	file_put_contents($outFile,$txt, FILE_APPEND | LOCK_EX);
		    	}catch(\Exception $e){
		        throw new \Exception("Error: ".$e->getMessage());
		        return false;
		    	}
		    }
		    if (!feof($handle)) {
		        throw new \Exception("Error: unexpected fgets() fail");
		    }
		    fclose($handle);
		   return true;
		}else{
		   return false;
		}
	}
}