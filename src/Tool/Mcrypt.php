<?php 
namespace Tool;

/**
* 
*/
class Mcrypt  
{  
        private $iv = '1234567890123456'; //加密模式的位置 (可更改默认使用VI)
        private $key = '1234567890123456';   //密钥 (可更改ENCRYPT_KEY)
  
  
        function __construct()  
        {  
        }  
  
        function encrypt($str) {  
  
          //$key = $this->hex2bin($key);      
          $iv = $this->getVi();  
  
          $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);  
          mcrypt_generic_init($td, $this->getKey(), $iv);  
          $encrypted = mcrypt_generic($td, $str);  
  
          mcrypt_generic_deinit($td);  
          mcrypt_module_close($td);  
  
          return bin2hex($encrypted);  
        }  
  
        function decrypt($code) {  
          //$key = $this->hex2bin($key);  
          $code = $this->hex2bin($code);  
          $iv = $this->getVi();  
  
          $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);  
  
          mcrypt_generic_init($td, $this->getKey(), $iv);  
          $decrypted = mdecrypt_generic($td, $code);  
  
          mcrypt_generic_deinit($td);  
          mcrypt_module_close($td);  
  
          return utf8_encode(trim($decrypted));  
        }  
  
        protected function hex2bin($hexdata) {  
          $bindata = '';  
  
          for ($i = 0; $i < strlen($hexdata); $i += 2) {  
                $bindata .= chr(hexdec(substr($hexdata, $i, 2)));  
          }  
  
          return $bindata;  
        }  

  		public function setVi($iv){
  			$this->iv = $iv;
  			return $this;
  		}
  		public function getVi(){
  			return $this->iv;
  		}
  		public function setKey($key){
  			$this->key = $key;
  			return $this;
  		}
  		public function getKey(){
  			return $this->key;
  		}
}  