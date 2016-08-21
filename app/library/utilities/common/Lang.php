<?php


namespace Utilities\Common;


class Lang
{
    public static $lang;

    public function __construct($langConf)
    {
        self::$lang = $langConf;
    }

    public static function _M($name) {
        if(isset(self::$lang[$name])) {
            return self::$lang[$name];
        }
        return array();
    }

}