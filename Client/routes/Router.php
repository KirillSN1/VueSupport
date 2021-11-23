<?
    class Route{
        public static function get($url="", $callback){
            $exists = $url == $_SERVER['REQUEST_URI'];
            if(!$exists) return;
            if(is_callable($callback)) call_user_func($callback,$_GET);
            else if(preg_match("/^[а-яёа-яёa-zA-Z0-9]*(@)[а-яёа-яёa-zA-Z0-9]*$/",$callback)){
                $callback_data = preg_split("/@+/",$callback);
                $class = $callback_data[0];
                $func = $callback_data[1];
                $class::{$func}();
            }
        }
        public static function post($url="",$callback){
            $exists = $url == $_SERVER['REQUEST_URI'];
            if(!$exists) return;
            if(is_callable($callback)) call_user_func($callback,$_POST);
            else if(preg_match("/^[а-яёа-яёa-zA-Z0-9]*(@)[а-яёа-яёa-zA-Z0-9]*$/",$callback)){
                $callback_data = preg_split("/@+/",$callback);
                $class = $callback_data[0];
                $func = $callback_data[1];
                $class::{$func}();
            }
        }
    }