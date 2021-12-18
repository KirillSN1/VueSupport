<?php
    require_once __DIR__.'\Router.php';//Router
    require $root.'/api/ApiController.php';
    
    Route::post("/Api/checkProfile","ApiController@checkProfile");
    if(!AuthorizationController::check_profile($_SESSION["email"], $_SESSION["password"])){
        require "./php/app/authorizationPage.php";
        exit;
    }

    Route::get("/","ApiController@main");
    Route::get("/Api/ping","ApiController@ping");
    Route::get("*","ApiController@main");
?>