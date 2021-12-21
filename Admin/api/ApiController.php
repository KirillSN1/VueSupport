<?
require_once 'ItemsGroups.php';
    require_once 'DB.php';
    class ApiController {
        static function main(){
            require $_SERVER["DOCUMENT_ROOT"]."/php/app/app.php";
        }
        static function ping($request){
            echo(json_encode($request["text"]));
        }
        static function getMenuLinks(){
            $db = DB::connect();
            echo(json_encode($db->query("SELECT href, id, title FROM menulinks")->fetch_all(MYSQLI_ASSOC)));
            $db->close();
        }
        static function getAboutGroups(){
            $db = DB::connect();
            $categories = $db->query("SELECT id, title from aboutcategories")->fetch_all(MYSQLI_ASSOC);
            foreach($categories as &$categorie){
                $id = $categorie['id'];
                $categorie['paragraphs'] = $db->query("SELECT aboutinfo.id, aboutinfo.text FROM aboutinfo WHERE aboutinfo.category_id=$id")->fetch_all(MYSQLI_ASSOC);
            }
            echo(json_encode($categories));
            $db->close();
        }
        static function getItemsGroups(){
            $db = DB::connect();
            $groups = new ItemsGroups($db);
            $tree = $groups->getTree();
            $db->close();
            return json_encode($tree);
        }
        static function getFooterGroups(){
            $db = DB::connect();
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
        //authorization
        /**
         * проверка и сохранение профиля
         * только для страницф авторизации
         */
        static function checkProfile($request){
            AuthorizationController::check_profile($request["email"], $request["password"]);
            header("Location: /");
        }
        static function logout($request){
            AuthorizationController::unload_profile();
            header("Location: /");
        }
        static function getProfile(){
            return json_encode(AuthorizationController::get_current_profile());
        }
        //articles
        static function linkArticle($request){
            // articleId groupItemId
            if(!isset($request['articleId'])) return_error("Не передан параметр articleId");
            if(!isset($request['groupItemId'])) return_error("Не передан параметр groupItemId");
            $articleId = $request['articleId'];
            $groupItemId = $request['groupItemId'];
            $db = DB::connect();
            $isArticle = $db->query("SELECT COUNT(`id`) FROM `articles` WHERE `id`=$articleId")->fetch_array()[0];
            if(!$isArticle) return_error("Передан несуществующий articleId");
            return json_encode(boolval($db->query("UPDATE `itemsgroups` SET `article_id`=$articleId WHERE `id`=$groupItemId"))); 
        }
        static function unlinkArticle($request){
            // articleId groupItemId
            if(!isset($request['articleId'])) return_error("Не передан параметр articleId");
            if(!isset($request['groupItemId'])) return_error("Не передан параметр groupItemId");
            $articleId = $request['articleId'];
            $groupItemId = $request['groupItemId'];
            $db = DB::connect();
            return json_encode(boolval($db->query("UPDATE `itemsgroups` SET `article_id`=DEFAULT WHERE `id`=$groupItemId AND `article_id`=$articleId"))); 
        }
    }
