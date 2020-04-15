<?php
namespace Tool; 
class IpRange
{
	/**
	 * ipv4是否在指定多IP段范围内
	 * BaZhang Platform
	 * @Author   Jacklin@shouyiren.net
	 * @DateTime 2020-04-15T10:40:30+0800
	 * @param    string                   $ip      待验证IP
	 * @param    array                   $ipRange ip段集合['192.168.0.0/24','172.16.0.0/16','10.0.0.1/32','101.101.101.101']
	 * @return   boolean                             true-在范围内，false-不在范围内
	 */
    public function ipv4InRange($ip,$ipRange){
        $isIn = false;       
        if ($ipRange && in_array($ip, $ipRange)){
            $isIn = true;
        }
        if(!$isIn){
            $rangeIps = array_filter($ipRange, function($v){return strpos($v, '/') !== false;});
            foreach ($rangeIps as $rangeIp) {
                if($this->v4($ip, $rangeIp)){
                    $isIn = true;
                    break;
                }
            }
        }
        return $isIn;
    }
    /**
     * ipv4是否在指定单IP段范围内
     * BaZhang Platform
     * @Author   Jacklin@shouyiren.net
     * @DateTime 2020-04-15T10:43:47+0800
     * @param    string                   $ip    待验证IP
     * @param    string                   $range ip段 192.168.0.0/24  IP/CIDR
     * @return   boolean                          true-在范围内，false-不在范围内
     */
    private function v4( $ip, $range ) {
        if ( strpos( $range, '/' ) === false ) {
            $range .= '/32';
        }
        list( $range, $netmask ) = explode( '/', $range, 2 );
        $range_decimal = ip2long( $range );
        $ip_decimal = ip2long( $ip );
        $wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
        $netmask_decimal = ~ $wildcard_decimal;
        return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
    }
}