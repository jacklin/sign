<?php 
require_once("../src/Tool/Mcrypt.php");

$m = new Tool\Mcrypt();
$str = "Abc!@#$%Z^&*()_+{}|/`http:\/\/";
echo $m->encrypt($str);
echo "<br>";
echo $m->decrypt($m->encrypt($str));