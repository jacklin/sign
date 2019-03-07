<?php 
namespace Tool; 
use \Curl\Curl;
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
	private static function downFile($url,&$save_file){
		$tmp_file_name = md5(substr(parse_url($url,PHP_URL_PATH),1));//临时文件
		$curl = new curl();
		$curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
		$save_file = self::$tmpPath.DIRECTORY_SEPARATOR.$tmp_file_name;
		$curl->download($url, $save_file);
		unset($curl);
		return true;
	}
	public static function scanFile($filePath){

	}
	public static function scanUrlFile($url){

	}

}