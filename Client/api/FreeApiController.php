<?
    require_once "Controller.php";
    class FreeApiController extends Controller{
        static function main(){
            self::view("/app.php");
        }
        static function ping($request){
            echo(json_encode($request["text"]));
        }
    }