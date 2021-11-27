<?
    class FreeApiController {
        static function main(){
            require $_SERVER["DOCUMENT_ROOT"]."/php/app.php";
        }
        static function ping($request){
            echo(json_encode($request["text"]));
        }
        static function getMenuLinks(){
            $db = new mysqli($_ENV["DB_HOST"],$_ENV["DB_USER"],$_ENV["DB_PASSWORD"],$_ENV["DB_NAME"]);
            echo(json_encode($db->query("SELECT href, id, title FROM menulinks")->fetch_all(MYSQLI_ASSOC)));
        }
    }