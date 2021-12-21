<?php
  require_once 'DB.php';
  class ArticlesController{
  static function getArticles(){
    $db = DB::connect();
    $atricles = $db->query("SELECT * FROM articles")->fetch_all(MYSQLI_ASSOC);
    $db->close();
    foreach($atricles as $key=>$article){
      $atricles[$key]["design"] = json_decode($article["design"]);
    }
    return json_encode($atricles);
  }
  static function getArticle($request){
    if(!property_exists((object)$request,"id")) return_error("Не передан параметр id");
    $id = $request["id"];
    $db = DB::connect();
    $article = $db->query("SELECT * FROM articles WHERE id=$id")->fetch_all(MYSQLI_ASSOC)[0];
    $db->close();
    $article["design"] = json_decode($article["design"]);
    return json_encode($article);
  }
  static function saveArticle($request){
    if(!isset($request["article"])) return_error("Не передан параметр article");
    $atricle = $request["article"];
    $id = $atricle["id"]??0;
    $title = $atricle["title"] ?? "dd";
    $html = $atricle["html"] ?? "";
    $css = $atricle["css"] ?? "";
    $posted = $atricle["posted"]?1:0;
    $db = DB::connect();
    $design = $db->real_escape_string(json_encode($atricle["design"]??""));
    $isArticle = $db->query("SELECT COUNT(`id`) FROM articles WHERE id=$id")->fetch_array()[0];
    $sql = $isArticle?
      "UPDATE `articles` SET `title`='$title',`html`='$html', `css`='$css', `design`='$design', `posted`=$posted WHERE id=$id":
      "INSERT INTO `articles`(`id`, `title`, `html`, `design`, `posted`) VALUES (NULL, '$title', '$html', '$design', $posted)";
    if(!$db->query($sql)) return_error("Ошибка sql");
    $newId = $isArticle?$id:$db->query("SELECT MAX(`id`) as `id` FROM `articles`")->fetch_array()[0];
    $db->close();
    return json_encode(['id'=>$newId]);
  }
  static function saveArticleImage($request){
    if(!isset($request["articleId"])) return_error("Не передан параметр articleId");
    if(!isset($_FILES["image"])) return_error("Не передан параметр image");
    $articleId = $request["articleId"];
    $image = $_FILES["image"];
    $fileInfo = new SplFileInfo($image["tmp_name"]);
    if(!preg_match("/image\/(\w)*/",$image["type"])) return_error("Неверный тип файла image");
    $directory = $_SERVER['DOCUMENT_ROOT']."/images/Articles/$articleId/";
    if(!is_dir($directory))
        mkdir($directory, 0777, true);
    $fileName = self::getNextFileName($directory).".".explode(".",$_FILES["image"]["name"])[1];//0.png
    $targetPath = $directory.$fileName;//...dir.../0.png
    move_uploaded_file($fileInfo->getPathname() ,$targetPath);
    return json_encode($fileName);
  }
  static function getNextFileName($directory){
    $names = scandir($directory);
    $max = -1;
    foreach($names as $i => $name){
        if($i<2)
            continue;
        $n = strval($name);
        $max = $n>$max?(int)$n:$max;
    }
    return $max+1;
  }
  static function article($request){
    if(!property_exists((object)$request,"id")) return_error("Не передан параметр id");
    $id = $request["id"];
    $db = DB::connect();
    $article = $db->query("SELECT html FROM articles WHERE id=$id")->fetch_all(MYSQLI_ASSOC)[0];
    $db->close();
    return $article["html"];
  }
}