<?php
namespace WWD;

/**
 * rsa 签名和验签实现类
 * 主要应用于私钥和公钥，openssl
 * 私钥签名，公钥验签，公钥加密，私钥解密
 * 格式 rsa_private_key.pem,rsa_public_key.pem
 */

class Rsa
{
    /***
    生成签名，签名规则
    1、参数名排序，
    2、拼接字符串，&连接
    3、使用私钥进行签名 sha1WithRSA
    4、对签名进行base64加密
    @param array data 签名数据及签名
    @param str private 私钥
    @return str
    */
    public static function sign($data,$private)
    {
        if(array_key_exists('sign_key',$data)) {
            unset($data['sign_key']);
        }    
        $pkeyid = openssl_pkey_get_private($private);    
        ksort($data);
        $str = '';
        foreach ($data as $key => $val) {
            $str .= $key.'&'.$val.'&';
        }
        openssl_sign($str, $signature, $pkeyid,"sha1WithRSAEncryption");
        return $sign_key = base64_encode($signature);
    }

    /***
    验证签名，签名规则
    1、参数名排序，
    2、拼接字符串，&连接
    3、使用私钥进行签名 sha1WithRSA
    4、对签名进行base64解密
    @param array data 签名数据及签名
    @param str public 公钥
    @return boolean
    */
    public static function verify($data,$public)
    {
        if(!array_key_exists('sign_key',$data)) {
            return false;
        }
        $sign = $data['sign_key'];
        unset($data['sign_key']);
        ksort($data);
        $str = '';
        foreach($data as $key=>$val){
            $str .= $key.'&'.$val.'&';
        }
        $ok = openssl_verify($str, base64_decode($sign), $public, OPENSSL_ALGO_SHA1);
        if($ok == 1){
            return true;
        } else {
            return false;
        }
    }

    public static function encrypt($data,$key,$choose=true)
    {
        if($choose) {
            $res = openssl_pkey_get_private($key); 
            openssl_private_encrypt($data,$crypt,$res); 
        } else {
            $res = openssl_pkey_get_public ($key); 
            openssl_public_encrypt($data,$crypt,$res); 
        }
        return base64_encode($crypt);
    }

    public static function decrypt($data,$key,$choose=true)
    {
        $data = base64_decode($data);
        if($choose) {
            $res = openssl_pkey_get_private($key); 
            openssl_private_decrypt($data,$destr,$res); 
        } else {
            $res = openssl_pkey_get_public ($key); 
            openssl_public_decrypt($data,$destr,$res); 
        }
        return $destr;        
    }

}
