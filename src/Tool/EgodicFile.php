<?php 
namespace Tool; 
/**
* 遍历目录找查文件
*/
class EgodicFile
{
	
	/**
	 * 递归查找出当前目录下指定扩展名的文件路径
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2018-05-10T10:39:10+0800
	 * @param    待查找的目录                   $dir     例如： /data/www/
	 * @param    array                   $extensions   指定扩展名 例如：['jpg','png']
	 * @param    array                   $re   排除目录名称 例如：['jpg','png']
	 * @return   void                              
	 */
	public function find(string $dir,array $extensions, array $exclusions=[".",".."]):void{
		$it = new \FilesystemIterator($dir);
		foreach ($it as $key => $fi) {
			if ($fi->isFile()) {
				//文件扩展名
				$file_extension = $fi->getExtension();
				if ($file_extension && in_array($file_extension, $extensions)) {
					echo $fi->getPathname().PHP_EOL;
				}
			}
			//
			if ($fi->isDir() && !in_array($fi->getFilename(), $exclusions)) {
				$this->find($fi->getPathname(),$extensions);
			}
		}
	}
}