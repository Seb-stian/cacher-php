<?php

define('CACHE_PATH', 'cache/');

class Cacher {
    
    public static function init() {
        mkdir(CACHE_PATH);
    }

    /**
     * @param string $name
     * @return string
     */
    public static function get($name) {
        return self::cache_get($name);
    }

    /**
     * Shortcut for **echo Cacher::get**
     * @param string $name
     */
    public static function echo($name) {
        echo self::get($name);
    }

    /**
     * @param string $name
     * @param string $file
     */
    public static function set($name, $file) {
        if (self::cache_has($name)) {
            return;
        }

        if (is_file($file)) {
            ob_start();
            include $file;
            self::cache_add($name, ob_get_clean());
        }
    }

    /**
     * @param string $name
     * @param string $func
     * @param mixed $args
     */
    public static function set_func($name, $func, ...$args) {
        if (self::cache_has($name)) {
            return;
        }

        if (function_exists($func)) {
            self::cache_add($name, call_user_func($func, $args));
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function has($name) {
        return self::cache_has($name);
    }

    private static function cache_has($name) {
        return file_exists(CACHE_PATH . $name);
    }

    private static function cache_add($name, &$data) {
        $path = CACHE_PATH . $name;
        file_put_contents($path, $data);
    }

    private static function cache_get($name) {
        $path = CACHE_PATH . $name;
        if (file_exists($path)) {
            return file_get_contents($path);
        }
        else {
            return '';
        }
    }

    /**
     * @param string $name
     */
    public static function remove($name) {
        $path = CACHE_PATH . $name;
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public static function clear() {
        if ($handle = opendir(CACHE_PATH)) {
            while (($entry = readdir($handle)) !== false) {
                unlink(CACHE_PATH . $entry);
            }

            closedir($handle);
        }
    }
}

?>