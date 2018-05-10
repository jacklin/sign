<?php 
/**
 * 测试遍历目录找查文件
 */
require_once("../src/Tool/EgodicFile.php");
$s = new Tool\EgodicFile();
$path = "/data/www/7723.com/bbs.7723.com";//查找当前目录下的
$exclusions=['.','..','.git','.svn'];//过滤不查找目录 
$s->find($path,['png','jpeg','jpg','bmp'],$exclusions);