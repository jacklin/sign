<?php 
require_once("../src/Tool/Mcrypt.php");

$m = new Tool\Mcrypt();
$n = new Tool\Mcrypt();
$str = "Abc!@#$%Z^&*()_+{}|/`http:\/\/";
$iv = "0000000000000000";
$key = "cccccccccccccccccccc";
$enstr = $m->setVi($iv)->setKey($key)->encrypt($str);
echo $enstr;
echo "<br>";
echo $m->decrypt($enstr);