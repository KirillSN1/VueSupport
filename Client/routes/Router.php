<?
    class Route{
        public static function get($url="", $callback){
            $api_regexp = env("API_REGEXP","");
            $is_regexp = preg_match("/^\/.+\/[a-z]*$/i",$api_regexp);
            $is_api_request = $is_regexp?preg_match($api_regexp,$_SERVER['REQUEST_URI']):false;
            $exists = $url == $_SERVER['REQUEST_URI'] || ($url =="*" && !$is_api_request);
            if(!$exists) return;
            if(is_callable($callback)) call_user_func($callback,$_GET);
            else if(preg_match("/^[а-яёа-яёa-zA-Z0-9]*(@)[а-яёа-яёa-zA-Z0-9]*$/",$callback)){
                $callback_data = preg_split("/@+/",$callback);
                $class = $callback_data[0];
                $func = $callback_data[1];

                set_error_handler(function($code,$message){
                    header('HTTP/1.1 500 Internal Server Error');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => $message, 'code' => $code)));
                });
                $class::{$func}();
                restore_error_handler();
                exit();
            }
        }
        public static function post($url="",$callback){
            $api_regexp = env("API_REGEXP","");
            $is_regexp = preg_match("/^\/.+\/[a-z]*$/i",$api_regexp);
            $is_api_request = $is_regexp?preg_match($api_regexp,$_SERVER['REQUEST_URI']):false;
            $exists = $url == $_SERVER['REQUEST_URI'] || ($url =="*" && !$is_api_request);
            if(!$exists) return;
            if(is_callable($callback)) call_user_func($callback,$_POST);
            else if(preg_match("/^[а-яёа-яёa-zA-Z0-9]*(@)[а-яёа-яёa-zA-Z0-9]*$/",$callback)){
                $callback_data = preg_split("/@+/",$callback);
                $class = $callback_data[0];
                $func = $callback_data[1];

                set_error_handler(function($code,$message){
                    header('HTTP/1.1 500 Internal Server Error');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => $message, 'code' => $code)));
                });
                $class::{$func}();
                restore_error_handler();
                exit();
            }
        }
    }