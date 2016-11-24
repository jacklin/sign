<?php 
require_once("../src/Sign.php");

$s = new shouyiren\helper\Sign("key");
$data = [
	"name" => "Jon",
	"age" => "32",
	0 => "test"
];
$data = json_encode($data);
echo $s->generateSign($data);