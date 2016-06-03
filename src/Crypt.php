<?php
namespace WWD;

/**
 * 加密解密类
 */
class Crypt
{

    private static $_handler = '';

    private static $_instance = null;

    const NAME= 'WWD\\Crypt\\';

    /**
     * 构造函数确认加密方式
     * @param string $type 加密的类型 Base64,Crype,Des,Xxtea
     * @return void
     */
    private function __construct($type)
    {
        $type          = $type;
        $class         = self::NAME . ucwords(strtolower($type));
        self::$_handler = $class;
    }    

    public static function getInstance($type='Base64')
    {
        if (self::$_instance === null) {
            self::$_instance = new self($type);
        }
        return self::$_instance;
    }


    /**
     * 加密字符串
     * @param string $str 字符串
     * @param string $key 加密key
     * @param integer $expire 有效期（秒） 0 为永久有效
     * @return string
     */
    public static function encrypt($data, $key, $expire = 0)
    {
        if (empty(self::$_handler)) {
            self::getInstance();
        }
        $class = self::$_handler;
        return $class::encrypt($data, $key, $expire);
    }

    /**
     * 解密字符串
     * @param string $str 字符串
     * @param string $key 加密key
     * @return string
     */
    public static function decrypt($data, $key)
    {
        if (empty(self::$_handler)) {
            self::getInstance();
        }
        $class = self::$_handler;
        return $class::decrypt($data, $key);
    }
}
