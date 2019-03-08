<?php 
namespace Tool; 
use \Curl\Curl;
use \Swoole\Process;
/**
 * 
 */
class VirusAtrtists
{	
	//临时目录
	public static $tmpPath;
	public static $atr;

	public function __construct(){
		self::isExeCmdPermission()&&self::isExsitsClamav();
	}
	/**
	 * 获取类的实列化对象
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-03-07T18:01:18+0800
	 * @return   self                   VirusAtrtists
	 */
	public function getInstance(){
		if (self::$atr instanceof static) {
			return self::$atr;
		}else{
			self::$atr = new static();
			return self::$atr;
		}
	}
	public static function setTempPath($tempPath='./'){
		self::$tmpPath = $tempPath;
	}
	/**
	 * 判断是否可以执行clamscan
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-03-07T18:41:50+0800
	 * @return   boolean                  [description]
	 */
	private static function isExsitsClamav(){
		$cmd = '/usr/local/clamav-0.101.1/bin/clamscan -V';
		$res = [];
		exec($cmd,$res);
		if (count($res) == 1) {
			return true;
		}else{
			throw new Exception("exec(".$cmd.") exception !");
		}
	}
	/**
	 * 判断是否有exe执行权限
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-03-07T18:17:28+0800
	 * @return   boolean                  [description]
	 */
	private static function isExeCmdPermission(){
		if (stripos(ini_get('disable_functions'),'exec') !== false) {
			throw new Exception("Need get 'exec' function permission !");
		}else{
			return true;
		}
	}
	/**
	 * 下载文件
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-03-07T19:06:08+0800
	 * @param    string                   $url        
	 * @param    string                   &$save_file 文件下载后保存路径
	 * @param    string                   $file_md5  文件md5值
	 * @return   boolean                              
	 */
	private static function downFile($url,&$save_file,$file_md5=''){
		$tmp_file_name = md5(substr(parse_url($url,PHP_URL_PATH),1));//临时文件
		$curl = new curl();
		$curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
		$save_file = self::$tmpPath.DIRECTORY_SEPARATOR.$tmp_file_name;
		$res_download = $curl->download($url, $save_file);
		unset($curl);
		if ($res_download) {
			$_file_md5 = file_md5($save_file);
			if ($file_md5 == $_file_md5) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	private static function runCmd($cmd,$args){
		$process = new swoole_process(function($worker) use($cmd,$args){
			$worker->exec($cmd,$args);
		},true);
		$pid = $process->start();
		// swoole_event_add($process->pipe,function($pipe) use($process){echo $process->read();});
		return $process->read();
		// swoole_process::wait();
	}
	public static function scanFile($filePath,$isRemove=false){
		$scan_list_file = $filePath.'.sca';
		file_put_contents($scan_list_file, $filePath,FILE_APPEND);
		$cmd = "/usr/local/clamav-0.101.1/bin/clamscan -f ".$scan_list_file."|grep ".$filePath;
		$res= self::runCmd($cmd);
		if ($res) {
			@unlink($scan_list_file);
			$isRemove?@nlink($filePath):'';
		}
		return $res
	}
	/**
	 * 扫描提交的url文件
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-03-08T15:43:54+0800
	 * @param    [type]                   $url 文件url例如：http://a.com/a.apk
	 * @param    [type]                   $md5 文件md5默认为空
	 * @return   [type]                        [description]
	 */
	public static function scanUrlFile($url,$md5=''){
		$save_file='';
		if(self::downFile($url,$save_file,$md5)){
			$res_scan = self::scanFile($save_file);
			return self::parseScanRes($res_scan);
		}else{
			throw new Exception("download: Error!");
		}
	}
	/**
	 * 解析扫描后返回的内容
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2019-03-08T15:41:53+0800
	 * @param    [type]                   $context 例如：/usr/local/src/Thunder5.8.14.706(1).exe: Win.Trojan.Generic-6878759-0 FOUND
	 * @return   array                           status：0-表示文件有病毒;1-表示文件没有问题;2-文件未知
	 */
	private static function parseScanRes($context){
		strchr($context,'FOUND');
		$arr_context = explode(" ",$context);
		$status = end($arr_context);
		$_res = [];
		switch ($status) {
			case 'OK':
				$_res['status'] = 1;
				$_res['description'] = "The file is safe!";
				break;
			case 'FOUND':
				$_res['status'] = 0;
				$_res['description'] = "The file is dangerous!";
				break;
			default:
				$_res['status'] = 2;
				$_res['description'] = "The file is unknown!";
				break;
		}
		return $_res;
	}

}