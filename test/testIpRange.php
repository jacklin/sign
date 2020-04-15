<?php
require_once("../src/Tool/IpRange.php");
$ipRange = new Tool\IpRange();

$res = $ipRange->ipv4InRange('192.168.0.2',['192.168.0.1','192.168.0.0/24','127.0.0.1']);
var_dump($res);