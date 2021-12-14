<?
    require_once 'ItemsGroups.php';
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
            $db->close();
        }
        static function getAboutGroups(){
            $db = new mysqli($_ENV["DB_HOST"],$_ENV["DB_USER"],$_ENV["DB_PASSWORD"],$_ENV["DB_NAME"]);
            $categories = $db->query("SELECT id, title from aboutcategories")->fetch_all(MYSQLI_ASSOC);
            foreach($categories as &$categorie){
                $id = $categorie['id'];
                $categorie['paragraphs'] = $db->query("SELECT aboutinfo.id, aboutinfo.text FROM aboutinfo WHERE aboutinfo.category_id=$id")->fetch_all(MYSQLI_ASSOC);
            }
            echo(json_encode($categories));
            $db->close();
        }
        static function getItemsGroups(){
            $db = new mysqli($_ENV["DB_HOST"],$_ENV["DB_USER"],$_ENV["DB_PASSWORD"],$_ENV["DB_NAME"]);
            $groups = new ItemsGroups($db);
            $tree = $groups->getTree();
            echo(json_encode($tree));
            $db->close();
        }
        static function getFooterGroups(){
            $db = new mysqli($_ENV["DB_HOST"],$_ENV["DB_USER"],$_ENV["DB_PASSWORD"],$_ENV["DB_NAME"]);
            $footerGroups = $db->query("SELECT * FROM footerGroups")->fetch_all(MYSQLI_ASSOC);
            foreach($footerGroups as &$group){
                $id = $group['id'];
                $group['paragraphs'] = $db->query("SELECT * FROM footerinfo WHERE group_id=$id")->fetch_all(MYSQLI_ASSOC);
            }
            array_push($footerGroups,[
                'href'=>null,
                'id'=>"0",
                'title'=>"Меню",
                'paragraphs'=>$db->query("SELECT id, href, title as 'text' FROM menulinks")->fetch_all(MYSQLI_ASSOC)
            ]);
            $db->close();
            return json_encode($footerGroups);
        }
        static function getArticlesTitles(){
            $db = new mysqli($_ENV["DB_HOST"],$_ENV["DB_USER"],$_ENV["DB_PASSWORD"],$_ENV["DB_NAME"]);
            $atricles = $db->query("SELECT id, title FROM articles")->fetch_all(MYSQLI_ASSOC);
            $db->close();
            return json_encode($atricles);
        }
        static function getArticle($request){
            if(!property_exists((object)$request,"id")) return_error("Не передан параметр id");
            $id = $request["id"];
            $db = new mysqli($_ENV["DB_HOST"],$_ENV["DB_USER"],$_ENV["DB_PASSWORD"],$_ENV["DB_NAME"]);
            $atricle = $db->query("SELECT * FROM articles WHERE id=$id")->fetch_all(MYSQLI_ASSOC)[0];
            $db->close();
            return json_encode($atricle);
        }
    }