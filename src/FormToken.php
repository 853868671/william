<?php
namespace WWD;
/**
* 表单令牌(防止表单恶意提交)
*/
class FormToken
{
    const SESSION_KEY = 'SESSION_KEY';
    
    function __construct()
    {
        if(!isset($_SESSION)){
            session_start();
        }
    }
    /** 
     * 生成一个当前的token 
     * @param string $form_name 
     * @return string 
     */  
    public static function createToken($form_name)
    {
        $key = self::grante_key();
        $_SESSION[self::SESSION_KEY.$form_name] = $key;//存储Key值用来验证
        return $token = md5(substr(time(), 0, 3).$key.$form_name);

    }

    /** 
     * 验证一个当前的token 
     * @param string $form_name 
     * @return string 
     */  
    public static function isToken($form_name,$token)  
    {  
        $key = $_SESSION[self::SESSION_KEY.$form_name]  
        $old_token = md5(substr(time(), 0, 3).$key.$form_name);  
        if($old_token == $token)  
        {  
            self::dropToken($form_name);
            return true;  
        } else {  
            return false;  
        }  
    }  

    /** 
     * 删除一个token 
     * @param string $form_name 
     * @return boolean 
     */  
    public static function dropToken($form_name)  
    {  
        unset($_SESSION[self::SESSION_KEY.$form_name]);
        return true;  
    }          

    /** 
     * 生成一个密钥 
     * @return string 
     */  
    public static function granteKey()  
    {  
        $encrypt_key = md5(((float) date("YmdHis") + rand(100,999)).rand(1000,9999));  
        return $encrypt_key;  
    }      
}

?>