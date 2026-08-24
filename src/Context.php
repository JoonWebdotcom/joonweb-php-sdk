<?php
namespace JoonWeb;

class Context {
    public static $API_KEY = '';
    public static $API_SECRET = '';
    public static $API_VERSION = '26.0';
    public static $IS_EMBEDDED = false;
    public static $APP_NAME = 'Joonweb App';
    
    /**
     * Initialize the global SDK Context
     * 
     * @param array $config
     */
    public static function init(array $config) {
        if (isset($config['api_key'])) self::$API_KEY = $config['api_key'];
        if (isset($config['api_secret'])) self::$API_SECRET = $config['api_secret'];
        if (isset($config['api_version'])) self::$API_VERSION = $config['api_version'];
        if (isset($config['is_embedded'])) self::$IS_EMBEDDED = (bool)$config['is_embedded'];
        if (isset($config['app_name'])) self::$APP_NAME = $config['app_name'];
    }
}
