<?
    $root = dirname($_SERVER["DOCUMENT_ROOT"],1);
    require_once '../vendor/autoload.php';//using composer packages
    require_once "../public/php/config/config.php";//init .env
    require_once "../routes/routes.php";

    http_response_code(404);
    exit(404);
    // require_once "./public/php/";