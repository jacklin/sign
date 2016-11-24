<?php
namespace shouyiren\helper; 
/**
* 简单md5签名
*/
class Sign
{
	//签名密钥
	protected $key;
	// 表单提交字符集编码
	public $postCharset = "UTF-8";
	//文件字符集编码
	private $fileCharset = "UTF-8";
	//签名类型
	private $signType = "MD5";

	public function __construct($key){
		$this->key = $key;
	}
	/**
	 * 生成签名
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2016-11-24T14:37:23+0800
	 * @version  [3.0.0]
	 * @param    array                   $params   待签名值
	 * @param    string                   $signType 签名类型
	 * @return   string                             签名值
	 */
	public function generateSign($params, $signType = "MD5") {
		if (is_array($params)) {
			return $this->sign($this->getSignContent($params), $signType);
		}else if (is_string($params)) {
			return $this->sign($params, $signType);
		}
	}
	/**
	 * 转换字符集编码
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2016-11-24T14:35:01+0800
	 * @version  [3.0.0]
	 * @param    mixed                   $data          待转换的值
	 * @param    string                   $targetCharset utf|gbk|gb2312
	 * @return   mixed                                  返回转换后的值
	 */
	public function characet($data, $targetCharset) {
		if (!empty($data)) {
			$fileType = $this->fileCharset;
			if (strcasecmp($fileType, $targetCharset) != 0) {
				$data = mb_convert_encoding($data, $targetCharset);
			}
		}
		return $data;
	}
	/**
	 * 获取待签名内容
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2016-11-24T13:30:34+0800
	 * @version  [3.0.0]
	 * @param    [type]                   $params [description]
	 * @return   [type]                           [description]
	 */
	protected function getSignContent($params) {
		ksort($params);

		$stringToBeSigned = "";
		$i = 0;
		foreach ($params as $k => $v) {
			if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

				// 转换成目标字符集
				$v = $this->characet($v, $this->postCharset);

				if ($i == 0) {
					$stringToBeSigned .= "$k" . "=" . "$v";
				} else {
					$stringToBeSigned .= "&" . "$k" . "=" . "$v";
				}
				$i++;
			}
		}

		unset ($k, $v);
		return $stringToBeSigned;
	}
	/**
	 * 签名方法
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2016-11-24T13:30:21+0800
	 * @version  [3.0.0]
	 * @param    string                   $data     [description]
	 * @param    string                   $signType [description]
	 * @return   [type]                             [description]
	 */
	protected function sign($data, $signType = "MD5") {
		$sign = '';
		if ("MD5" == $signType) {
			$sign = md5($data.$this->key);
		}
		return $sign;
	}

	/**
	 * 检测值是否为空 
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2016-11-24T14:32:05+0800
	 * @version  [3.0.0]
	 * @param    mixed                   $value 待检测的值
	 * @return   boolean                     	 null | "" | unsset 返回 true;
	 */
	protected function checkEmpty($value) {
		if (!isset($value))
			return true;
		if ($value === null)
			return true;
		if (trim($value) === "")
			return true;

		return false;
	}
}