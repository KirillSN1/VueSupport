<?
    const FUNC_REGEXP = "/^([а-яёа-яёa-zA-Z0-9]||[-,_,$])*(@)([а-яёа-яёa-zA-Z0-9]||[-,_,$])*$/";
    class Route{
        public static function get($url="", $callback){
            $path =  parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
            $api_regexp = env("API_REGEXP","");
            $is_regexp = preg_match("/^\/.+\/[a-z]*$/i",$api_regexp);
            $is_api_request = $is_regexp?preg_match($api_regexp,$path):false;
            $exists = $url == $path || ($url =="*" && !$is_api_request);
            if(!$exists) return;
            if(is_callable($callback)) call_user_func($callback,$_GET);
            else if(preg_match(FUNC_REGEXP,$callback)){
                $callback_data = preg_split("/@+/",$callback);
                $class = $callback_data[0];
                $func = $callback_data[1];

                set_error_handler(function($code,$message){
                    if(!headers_sent()){
                        header('HTTP/1.1 500 Internal Server Error');
                        header('Content-Type: application/json; charset=UTF-8');
                    }
                    die(json_encode(array('message' => $message, 'code' => $code, 'trace'=> debug_backtrace())));
                });
                echo($class::{$func}($_REQUEST));
                restore_error_handler();
                exit();
            }
        }
        public static function post($url="",$callback){  
            $path =  parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
            $api_regexp = env("API_REGEXP","");
            $is_regexp = preg_match("/^\/.+\/[a-z]*$/i",$api_regexp);
            $is_api_request = $is_regexp?preg_match($api_regexp,$path):false;
            $exists = $url == $path || ($url =="*" && !$is_api_request);
            if(!$exists) return;
            if(is_callable($callback)) call_user_func($callback,$_POST);
            else if(preg_match(FUNC_REGEXP,$callback)){
                $callback_data = preg_split("/@+/",$callback);
                $class = $callback_data[0];
                $func = $callback_data[1];

                set_error_handler(function($code,$message){
                    if(!headers_sent()){
                        header('HTTP/1.1 500 Internal Server Error');
                        header('Content-Type: application/json; charset=UTF-8');
                    }
                    die(json_encode(array('message' => $message, 'code' => $code, 'trace'=> debug_backtrace())));
                });
                $request = sizeof($_REQUEST)>1?$_REQUEST:json_decode(file_get_contents("php://input"), true);
                echo($class::{$func}($request));
                restore_error_handler();
                exit();
            }
        }
    }